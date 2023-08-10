<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Employee;
use App\Traits\ConstantKeys;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\MailServices;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\Session;
use App\Classes\PasswordResetRequestEmployee;
use App\DBTransactions\PasswordReset\SavePasswordReset;
use App\DBTransactions\PasswordReset\UpdatePasswordReset;

/**
 * PasswordReset controller
 *
 * @author  Hpone Naing Htun
 * 
 * @create  2023/08/04
 */
class PasswordResetController extends Controller
{
    use ConstantKeys;
    protected $employeeInterface, $mailServices;

    /**
     * Constructor to assign EmployeeInterface
     */
    public function __construct(EmployeeInterface $employeeInterface, MailServices $mailServices)
    {
        $this->employeeInterface = $employeeInterface;
        $this->mailServices = $mailServices;
    }

    /**
     * Get employee_id and then retrieve id, employee id, name, email, role_id 
     * Check role_id, if role_id < 2 return member password reset form, heigher than 2 return heigher level password reset form
     * 
     * @author HponeNaingTun
     * 
     * @create 04/08/2023
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

    /**
     * Login employee is manager and above level, they dont need to request reset password. They can reset their password.
     * 
     * @author HponeNaingTun
     * 
     * @create 04/08/2023
     * 
     * @param Request $request 
     * 
     * return view authentication/login.blade.php
     * 
     * @access  public
     */
    public function resetPassword(Request $request)
    {
        $update = Employee::where('id', $request->id)->update(['password' =>  Hash::make($request->password)]);
        if ($update) {
            return new Response(view("authentication.login")->with("success", "Password reset success.")->render());
        }
        return new Response(view("authentication.login")->with("error", "Update Fail")->render());
    }

    /**
     * Login employee is lower than manager level (role < 3). They must send password reset request to heigher role level.
     * For send password reset request, first save request employee id, approver id, status='pending' save to forget_passwords table.
     * 
     * @author HponeNaingTun
     * 
     * @create 04/08/2023
     * 
     * @param Request $request 
     * 
     * return view authentication/login
     * 
     * @access  public
     */
    public function requestResetPassword(Request $request)
    {
        $save = new SavePasswordReset($request);
        $save = $save->executeProcess();
        if ($save) {
            return new Response(view("authentication.login")->with("success", "Request reset password to admin success.")->render());
        }
        return new Response(view("authentication.login")->with("error", "Server error encounter!")->render());
    }

    /**
     * Get pending password reset request employees. forget_password tables column status = 'pending' 
     * 
     * @author HponeNaingTun
     * 
     * @create 04/08/2023
     *      
     * return view employee/pending-password-reset-form.blade.php
     * 
     * @access  public
     */
    public function getPendingPasswordResetEmployeesForm()
    {
        $pendingResetPasswordList = $this->employeeInterface->getInProgressToResetPasswordList(request()->session()->get('logedinId'));
        $pendingEmployeeList = [];
        # In forget_password tables, store request_employee_id and heigher_level_employee_id. 
        # Iterate all datas from forget_passwords table where status = 'pending' and get request_employee_id, heigher_level_employee_id.
        # request these Ids from employees table with custom columns(id, employee id, name, email) and assign these data to custom class app/Classes/PasswordResetRequestEmployee
        # And then this PasswordResetRequestEmployee to $pendingEmployeeList array.
        foreach ($pendingResetPasswordList as $pendingResetPassword) {
            $employee = $this->employeeInterface->getEmployeesByIdOptionalColumns(['id', 'employee_id', 'name', 'email'], $pendingResetPassword->employee_id);
            $heigherLevelEmployee = $this->employeeInterface->getEmployeesByIdOptionalColumns(['id', 'employee_id', 'name', 'email'], $pendingResetPassword->heigher_level_role_id);

            $pendingEmployee = new PasswordResetRequestEmployee($employee->id, $employee->name, $employee->email, $employee->employee_id, $heigherLevelEmployee->id, $heigherLevelEmployee->name, $heigherLevelEmployee->email, $heigherLevelEmployee->employee_id);
            array_push($pendingEmployeeList, $pendingEmployee);
        }
        return view('employee.pending-password-reset-form', compact('pendingEmployeeList'));
    }

    /**
     * Update forget_password table column from status=pending to stauts = "complete", employees table column password.
     * Sending HTML format email to request_employee
     * 
     * @author HponeNaingTun
     * 
     * @create 04/08/2023
     * 
     * @param Request $request 
     * 
     * return view employee/pending-password-reset-form.blade.php
     * 
     * @access  public
     */
    public function memberPasswordReset(Request $request)
    {
        $requestPasswordResetEmployeeId = $request->request_id;
        $requestEmployeeName = $request->request_employee_name;
        $requestPasswordResetEmployeeEmail = $request->request_employee_email;
        $heigherLevelEmployeeId = $request->heigher_level_id;
        $heigherLevelEmployeeEmail = $request->heigher_level_employee_email;
        $resetPassword = $request->reset_password;

        $mailServices = $this->mailServices;
        $mailServices->setMailTemplate('mail');
        $mailServices->setMailFrom($heigherLevelEmployeeEmail);
        $mailServices->setSenderName($request->heigher_level_employee_name);
        $mailServices->setMailTo($requestPasswordResetEmployeeEmail);
        $mailServices->setMailReceiverName($requestEmployeeName);
        $mailServices->setMailSubject("Hello! " . $requestEmployeeName);
        $mailContents = [
            'name' => $requestEmployeeName,
            'content' => 'Your New Password is ',
            'resetPassword' => $resetPassword,
            'requestEmployeeId' => $request->requestPasswordResetEmployeeId
        ];
        $mailServices->setmailDatas($mailContents);

        $update = Employee::where('id', $requestPasswordResetEmployeeId)->update(['password' =>  Hash::make($resetPassword)]);
        if ($update) {
            $updatePasswordReset = new UpdatePasswordReset($requestPasswordResetEmployeeId, $heigherLevelEmployeeId);
            $updateStatus = $updatePasswordReset->executeProcess();
            if ($updateStatus) {
                Session::flash("success", "Password reset success.");
                try {
                    $this->mailServices->sendHtmlEmail([$requestPasswordResetEmployeeEmail]);
                    Session::flash("success", "Send Reset Password Mail successful.");
                    return redirect()->back();
                } catch (Exception $e) {
                    Session::flash("error", "Send Fail Reset Password Mail." . $e->getMessage());
                    redirect()->back();
                }
            }
            Session::flash("saveError", "Server error encounter!");
            return redirect()->back();
        }
        Session::flash("saveError", "Server error encounter!");
        return redirect()->back();
    }
}
