<?php

namespace App\DBTransactions\PasswordReset;

use App\Traits\ConstantKeys;
use Carbon\Carbon;
use App\Models\PasswordReset;
use App\Traits\SaveFile;
use App\Classes\DBTransaction;
use App\Models\EmployeePasswordReset;
use Illuminate\Support\Facades\DB;
use App\DBTransactions\EmployeePasswordReset\SaveEmployeePasswordReset;
use App\DBTransactions\EmployeeProgrammingLanguage\SaveEmployeeProgrammingLanguage;
use App\Models\ForgetPassword;

class SavePasswordReset extends DBTransaction
{
    use ConstantKeys;
    private $request;

    /**
     * Constructor to assign request to variable
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * save Project
     * @author HponeNaingTun
     * @create 28/06/2023
     * @return associative array
     */
    public function process()
    {
        $request = $this->request;
        $forgetPassword = new ForgetPassword();
        $forgetPassword->employee_id = $request->id;
        $forgetPassword->heigher_level_role_id = $request->heigher_level_role;
        $forgetPassword->status = $this->PENDING;
        $forgetPassword->save();

        if ( !$forgetPassword ) { #this row is save or not
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}