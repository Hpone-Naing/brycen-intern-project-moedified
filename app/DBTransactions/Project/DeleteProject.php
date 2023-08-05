<?php

namespace App\DBTransactions\Project;

use App\Models\Project;
use App\Classes\DBTransaction;
use App\Interfaces\ProjectInterface;

class DeleteProject extends DBTransaction
{
    private $id, $projectInterface;

    public function __construct($id, ProjectInterface $projectInterface)
    {
        $this->id = $id;
        $this->projectInterface = $projectInterface;
    }
    public function process()
    {
        $documentationDeleteStatus = true;
        $id = $this->id;
        $project = $this->projectInterface->getProjectDocumentationsById($id);
        echo $project;
        if(count($project->employeesProjects) > 0) {
            foreach ($project->employeesProjects as $employeeProject) {
                echo "here for loop";
                $documentationDeleteStatus = $employeeProject->documentations()->delete();
                if ( !$documentationDeleteStatus ) {
                    return;
                }
            }
            echo "here exit for loop";
            $deleteEmployeeProject = $project->employeesProjects()->delete();
        } else {
            echo "null emp proj";
        }
        $deleted = $project->delete();

        if (!$deleted || !$deleteEmployeeProject || !$documentationDeleteStatus) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}