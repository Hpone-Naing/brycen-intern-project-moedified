<?php

namespace App\DBTransactions\Project;

use Carbon\Carbon;
use App\Models\Project;
use App\Traits\SaveFile;
use App\Classes\DBTransaction;
use App\Models\EmployeeProject;
use Illuminate\Support\Facades\DB;
use App\DBTransactions\EmployeeProject\SaveEmployeeProject;
use App\DBTransactions\EmployeeProgrammingLanguage\SaveEmployeeProgrammingLanguage;

class SaveProject extends DBTransaction
{
    private $projectName;

    /**
     * Constructor to assign request to variable
     */
    public function __construct($projectName)
    {
        $this->projectName = $projectName;
    }

    /**
     * save Project
     * @author HponeNaingTun
     * @create 28/06/2023
     * @return associative array
     */
    public function process()
    {
        $projectName = $this->projectName;
        $project = new Project;
        $project->name = $projectName;
        $project->save();

        if ( !$project ) { #this row is save or not
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}