<?php

namespace App\DBTransactions\EmployeeProgrammingLanguage;

use App\Models\Employee;
use App\Classes\DBTransaction;
use App\Models\EmployeeProgrammingLanguage;

class DeleteEmployeeProgrammingLanguage extends DBTransaction
{
    // private $id;

    // public function __construct($id)
    // {
    //     $this->id = $id;
    // }
    // public function process()
    // {
    //     $id = $this->id;
    //     $employee = Employee::find($id);   
    //     $employee->programmingLanguages()->detach($model2); //soft delete employee_programming_languages table's row
    //     if (!$update) {
    //         return ['status' => false, 'error' => 'Failed!'];
    //     }
    //     return ['status' => true, 'error' => ''];
    // }
} 