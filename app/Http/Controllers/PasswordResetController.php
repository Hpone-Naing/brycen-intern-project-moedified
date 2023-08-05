<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Traits\ConstantKeys;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\Session;
use App\DBTransactions\Employee\UpdateEmployeeV1;
use App\DBTransactions\PasswordReset\SavePasswordReset;

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
        $employee = $this->employeeInterface->getEmployeeById($request->id);
        $employee->password = Hash::make($request->passowrd);
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
}