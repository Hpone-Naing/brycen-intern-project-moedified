<?php

namespace App\DBTransactions\EmployeeProgrammingLanguage;

use App\Models\EmployeeProgrammingLanguage;
use App\Classes\DBTransaction;

/**
 * 
 * 
 * @author 
 * @create  
 */
class SaveEmployeeProgrammingLanguage extends DBTransaction
{
    private $programmingLanguages;

    /**
     * Constructor to assign programmingLanguages
     */
    public function __construct($programmingLanguages)
    {
        $this->programmingLanguages = $programmingLanguages;
    }

     /**
     * save employee programming language
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return associative array
     */
    public function process()
    {     
        $status = true;
        foreach ($this->programmingLanguages as $employeeProgrammingLang) {
            $employeeId = $employeeProgrammingLang['employee_id'];
            $programmingLanguageId = $employeeProgrammingLang['programming_language_id'];
            $employeeProgrammingLanguage = new EmployeeProgrammingLanguage();
            $employeeProgrammingLanguage->employee_id = $employeeId;
            $employeeProgrammingLanguage->programming_language_id = $programmingLanguageId;
            $employeeProgrammingLanguage->save();
            if (!$employeeProgrammingLanguage) { #this row is save or not
                return ['status' => false, 'error' => 'Failed!'];
            }
        }

        if($status) {
            return ['status' => true, 'error' => ''];
        }
    }
}