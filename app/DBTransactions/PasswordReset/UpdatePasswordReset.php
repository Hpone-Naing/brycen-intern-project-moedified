<?php

namespace App\DBTransactions\PasswordReset;

use App\Traits\ConstantKeys;
use Carbon\Carbon;
use App\Models\PasswordReset;
use App\Traits\SaveFile;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\Session;
use App\DBTransactions\PasswordResetProgrammingLanguage\UpdatePasswordResetProgrammingLanguage;
use App\Models\ForgetPassword;
use Illuminate\Support\Facades\Hash;

/**
 * Update PasswordReset
 *
 * @author  Hpone Naing Htun
 * @create  2023/06/23
 */
class UpdatePasswordReset extends DBTransaction
{
    use ConstantKeys;
    private $requestId, $heigherLevelId;

    /**
     * Constructor to assign requestId and PasswordReset id
     */
    public function __construct($requestId, $heigherLevelId)
    {
        $this->requestId = $requestId;
        $this->heigherLevelId = $heigherLevelId;
    }

    /**
     * update PasswordReset
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return associative array
     */
    public function process()
    {
        $requestId = $this->requestId;
        $heigherLevelId = $this->heigherLevelId;
        $update = ForgetPassword::where("employee_id", $requestId)->where("heigher_level_role_id", $heigherLevelId)->update(
            [
                "status" => $this->COMPLETE,
            ]
        );
        if ( !$update ) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        /**
         * if updatePasswordReset or update PasswordReset programming language success, return no error
         */
        return ['status' => true, 'error' => ''];
    }
}