<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Traits\ConstantKeys;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Classes\TemporaryClass;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\Session;
use App\Classes\PasswordResetRequestEmployee;
use App\DBTransactions\Employee\UpdateEmployeeV1;
use App\DBTransactions\PasswordReset\SavePasswordReset;
use App\DBTransactions\PasswordReset\UpdatePasswordReset;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

class PasswordResetController extends Controller
{
    use ConstantKeys;
    protected $employeeInterface;

    /**
     * Constructor to assign EmployeeInterface
     */
    public function __construct(EmployeeInterface $employeeInterface)
    {
        $this->employeeInterface = $employeeInterface;
    }

    /**
     * @author HponeNaingTun
     * 
     * @create 04/08/2023
     * 
     * Get employee_id and then retrieve id, name, role_id 
     * Check role_id, if role_id < 2 return member password reset form, heigher 2 return heigher level password reset form
     * 
     * @param Request $request 
     * 
     * return view authentication/
     * 
     * @access  public
     */
    public function getPasswordResetForm(Request $request)
    {
        $employee = $this->employeeInterface->getEmployeesByIdOptionalColumns(['id', 'employee_id', 'name', 'email', 'role_id'], $request->employee_id);
        if (!isset($employee)) {
            return new Response(view("authentication.login")->with("invalid_employee_id", "Invalid Employee Id")->render());
        }
        if ($employee->role_id <= 2) {
            if ($employee->role_id < 2) {
                $heigherLevelEmployees = $this->employeeInterface->getEmployeesByRoles($this->ROLE['admin']);
            } else {
                $heigherLevelEmployees = $this->employeeInterface->getEmployeesByRoles($this->ROLE['manager']);
            }
            return view('authentication.password-reset-member', compact('employee', 'heigherLevelEmployees'));
        }
        return view('authentication.password-reset-heigher-level', compact('employee'));
    }

    public function resetPassword(Request $request)
    {
        $update = Employee::where('id', $request->id)->update(['password' =>  Hash::make($request->password)]);
        if ($update) {
            return new Response(view("authentication.login")->with("success", "Password reset success.")->render());
        }
        return new Response(view("authentication.login")->with("error", "Update Fail")->render());
    }

    public function requestResetPassword(Request $request)
    {
        $save = new SavePasswordReset($request);
        $save = $save->executeProcess();
        if ($save) {
            return new Response(view("authentication.login")->with("success", "Request reset password to admin success.")->render());
        }
        return new Response(view("authentication.login")->with("error", "Server error encounter!")->render());
    }
    public function getPendingPasswordResetEmployeesForm()
    {
        $pendingResetPasswordList = $this->employeeInterface->getInProgressToResetPasswordList(request()->session()->get('logedinId'));
        $pendingEmployeeList = [];
        foreach ($pendingResetPasswordList as $pendingResetPassword) {
            $employee = $this->employeeInterface->getEmployeesByIdOptionalColumns(['id', 'employee_id', 'name', 'email'], $pendingResetPassword->employee_id);
            $heigherLevelEmployee = $this->employeeInterface->getEmployeesByIdOptionalColumns(['id', 'employee_id', 'name', 'email'], $pendingResetPassword->heigher_level_role_id);

            $pendingEmployee = new PasswordResetRequestEmployee($employee->id, $employee->name, $employee->email, $employee->employee_id, $heigherLevelEmployee->id, $heigherLevelEmployee->name, $heigherLevelEmployee->email, $heigherLevelEmployee->employee_id);
            array_push($pendingEmployeeList, $pendingEmployee);
        }
        return view('employee.pending-password-reset-form', compact('pendingEmployeeList'));
    }

    public function memberPasswordReset(Request $request)
    {
        $requestPasswordResetEmployeeId = $request->request_id;
        $requestPasswordResetEmployeeEmail = $request->request_employee_email;
        $heigherLevelEmployeeId = $request->heigher_level_id;
        $heigherLevelEmployeeEmail = $request->heigher_level_employee_email;
        $resetPassword = $request->reset_password;
        $update = Employee::where('id', $requestPasswordResetEmployeeId)->update(['password' =>  Hash::make($resetPassword)]);
        if ($update) {
            $updatePasswordReset = new UpdatePasswordReset($requestPasswordResetEmployeeId, $heigherLevelEmployeeId);
            $updateStatus = $updatePasswordReset->executeProcess();
            if ($updateStatus) {
                Session::flash("success", "Password reset success.");
                return redirect()->back();
            }
            Session::flash("saveError", "Server error encounter!");
            return redirect()->back();
        }
        Session::flash("saveError", "Server error encounter!");
        return redirect()->back();
    }
}
