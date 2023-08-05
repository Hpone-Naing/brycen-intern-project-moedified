<?php

namespace App\Rules;

use Closure;
use App\Models\EmployeeProject;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDateRange implements Rule
{
    protected $employeeId;

    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function passes($attribute, $value)
    {
        $overlapProjects = 0;
        echo($value);
        // $startDate = $value;

        // $overlapProjects = EmployeeProject::where('employee_id', $this->employeeId)
        //     ->where('start_date', '<=', $this->endDate)
        //     ->where('end_date', '>=', $startDate)
        //     ->count();
            /**
             * check project id exit in employees_projects table
             * Assume add new project "Testing2" but Testing2's id have not exit in employees_projects table yet.
             * So first check project's id exit in employees_projects table. IF exit, check employee's id and project's id
             * to get start date and end date of current working project
             * 
             * If not exit, check employee's id of current working project 
             */
            // if (isset($projectForEmployee) && $projectForEmployee->exists()) {
            //     print_r("here if");
            //     $overlapProjects = EmployeeProject::where('employee_id', $this->employeeId)->where('project_id', $this->projectId)
            //     ->where('start_date', '<=', $value)
            //     ->where('end_date', '>=', $value)
            //     ->count();
            // } else {
            //     print_r("here else");
            //     $overlapProjects = EmployeeProject::where('employee_id', $this->employeeId)
            //     ->where('start_date', '<=', $value)
            //     ->where('end_date', '>=', $value)
            //     ->count();
            // }
            $overlapProjects = EmployeeProject::where('employee_id', $this->employeeId)
            ->where('start_date', '<=', $value)
            ->where('end_date', '>=', $value)
            ->count();
        print_r($overlapProjects);
        return $overlapProjects === 0;
    }

    public function message()
    {
        return 'The project date range overlaps with an existing project for this employee.';
    }
}
