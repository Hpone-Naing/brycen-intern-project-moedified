<?php

namespace App\Classes;


/**
 * Manage database transactions
 *
 * @author  Hpone Naing Tun
 * @create  2023/08/05
 */
class PasswordResetRequestEmployee
{

    public $passwordRequestEmployeeId, $passwordRequestEmployeeName, $passwordRequestEmployeeEmail, $passwordRequestEmployeeEmployeeId;
    public $heighLevelEmployeeId, $heighLevelEmployeeName, $heighLevelEmployeeEmail, $heighLevelEmployeeEmployeeId;

    public function __construct($passwordRequestEmployeeId, $passwordRequestEmployeeName, $passwordRequestEmployeeEmail, $passwordRequestEmployeeEmployeeId, $heighLevelEmployeeId, $heighLevelEmployeeName, $heighLevelEmployeeEmail, $heighLevelEmployeeEmployeeId)
    {
        $this->passwordRequestEmployeeId = $passwordRequestEmployeeId;
        $this->passwordRequestEmployeeName = $passwordRequestEmployeeName;
        $this->passwordRequestEmployeeEmail = $passwordRequestEmployeeEmail;
        $this->passwordRequestEmployeeEmployeeId = $passwordRequestEmployeeEmployeeId;
        $this->heighLevelEmployeeId = $heighLevelEmployeeId;
        $this->heighLevelEmployeeName = $heighLevelEmployeeName;
        $this->heighLevelEmployeeEmail = $heighLevelEmployeeEmail;
        $this->heighLevelEmployeeEmployeeId = $heighLevelEmployeeEmployeeId;
    }
}
