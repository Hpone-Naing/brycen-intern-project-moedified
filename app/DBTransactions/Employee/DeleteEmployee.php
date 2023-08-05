<?php

namespace App\DBTransactions\Employee;

use App\Models\Employee;
use App\Classes\DBTransaction;
use App\Interfaces\EmployeeInterface;
use App\Traits\SaveFile;

class DeleteEmployee extends DBTransaction
{
    use SaveFile;
    private $id, $employeeInterface;

    public function __construct($id, EmployeeInterface $employeeInterface)
    {
        $this->id = $id;
        $this->employeeInterface = $employeeInterface;
    }
    public function process()
    {
        $inProgressOtherEmployee = false;
        $id = $this->id;
        $employee = $this->employeeInterface->getEmployeeByIdEgerLoad($id);

        if (!$employee) {
            return ['status' => true, 'error' => ''];
        }
        $employee->programmingLanguages()->detach();
        // $project = $this->employeeInterface->getEmployeeProjectById($id);
        /**
         * iterate employee's projects and soft delete employees_projects tables, and delete documentations files from storage/documentations
         */
        if ($employee->projects || isset($employee->projects)) {
            print_r("emp proj not null");
            foreach ($employee->projects as $project) {
                $projectId = $project->pivot->project_id;
                $employeeId = $project->pivot->employee_id;
                // foreach( $project->documentations as $documentation ) {
                //     $file = $documentation->file_name;
                //     $this->deleteFiles([$file], "storage", "app/documentations");
                //     $project->documentations()->delete();
                // }
                foreach ($project->employeesProjects as $employeeProject) {
                    if ($employeeProject || isset($employeeProject)) {
                        if ($employeeProject->employee_id || isset($employeeProject->employee_id)) {
                            if ($employeeProject->employee_id != $employeeId) {
                                $inProgressOtherEmployee = $employeeProject->employee_id != $employeeId;
                            }
                        }
                    }
                }
                if (!$inProgressOtherEmployee) {
                    $employee->projects()->updateExistingPivot($project->id, ['deleted_at' => now()]);
                    foreach ($employee->employeesProjects as $employeeProject) {
                        $employeeProject->documentations()->delete();
                    }
                }
            }
        }
        $file = $employee->image;
        $this->deleteFiles([$file], "public", "employee-photo");
        $deleted = $employee->delete();

        if (!$deleted) {
            return ['status' => false, 'error' => 'Failed!'];
        }


        return ['status' => true, 'error' => ''];
    }
}
