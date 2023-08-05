<?php

namespace App\DBTransactions\EmployeeProject;

use Carbon\Carbon;
use App\Models\EmployeeProject;
use App\Traits\SaveFile;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\DB;
use App\DBTransactions\EmployeeProjectProgrammingLanguage\SaveEmployeeProjectProgrammingLanguage;

class SaveEmployeeProject extends DBTransaction
{
    private $employeeProject;

    /**
     * Constructor to assign employeeProject
     */
    public function __construct(EmployeeProject $employeeProject)
    {
        $this->employeeProject = $employeeProject;
    }

     /**
     * save employee programming language
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return associative array
     */
    public function process()
    {     
        $this->employeeProject->start_date = Date("Y-m-d");
        $this->employeeProject->end_date = Date("Y-m-d");
        $this->employeeProject->save();
        if (!$this->employeeProject) { #this row is save or not
            return ['status' => false, 'error' => 'Failed!'];
        }
        
        return ['status' => true, 'error' => ''];
    }
}