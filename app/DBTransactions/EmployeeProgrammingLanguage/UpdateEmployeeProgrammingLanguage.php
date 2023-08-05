<?php

namespace App\DBTransactions\EmployeeProgrammingLanguage;

use Carbon\Carbon;
use App\Models\Employee;
use App\Traits\SaveFile;
use App\Classes\DBTransaction;
use App\Models\EmployeeProgrammingLanguage;

class UpdateEmployeeProgrammingLanguage extends DBTransaction
{
    private $programmingLanguages, $id;

    /**
     * Constructor to assign programmingLanguages
     */
    public function __construct($programmingLanguages, $id)
    {
        $this->programmingLanguages = $programmingLanguages;
        $this->id = $id;
    }

    /**
         * Delete Email Passcode
     *
     * @author  
     * @return  array
         */
    public function process()
    {        
        $status = true;
        $id = $this->id;

        $employee = Employee::find($id);
        $update = $employee->programmingLanguages()->sync($this->programmingLanguages);

        if (!$update) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
        
        // foreach ($this->programmingLanguages as $employeeProgrammingLang) {
        //     $programmingLanguageId = $employeeProgrammingLang['programming_language_id'];     
        //     dd($programmingLanguageId);
        //     $update = EmployeeProgrammingLanguage::where("employee_id", $id)->update(
        //         [
        //             "programming_language_id" => $programmingLanguageId,
        //         ]
        //     );
        //     if (!$update) { #this row is save or not
        //         return ['status' => false, 'error' => 'Failed!'];
        //     }
        // }
        // if($status) {
        //     return ['status' => true, 'error' => ''];
        // }
    }
}