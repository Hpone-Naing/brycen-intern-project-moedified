<?php

namespace App\Repositories;


use App\Models\Project;
use App\Interfaces\ProjectInterface;

/**
 * Employee Respository
 *
 * @author  Hpone Naing Htun
 * @create  2023/06/23
 */
class ProjectRepository implements ProjectInterface
{
        /**
     * get all projects
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return array
     */
    public function getAllProjects()
    {
        $projects = Project::all();
        return $projects;
    }
    
    /**
     * get all current working project. end date less than or equal current date.
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return array
     */
    public function getAllCurrentProjects()
    {
        $projects = Project::join("employees_projects", "projects.id", "employees_projects.project_id")
                    ->where("employees_projects.end_date", "<=", Date("Y-m-d"))->get();
        return $projects;
    }

    /**
     * get  project by id
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return object
     */
    public function getProjectById($id)
    {
        $project = Project::find($id);
        return $project;
    }

    /**
     * get current working project by id. 
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return object
     */
    public function getCurrentProjectsById($id)
    {
        $projects = Project::join("employees_projects", "projects.id", "employees_projects.project_id")
                    ->where("projects.id", $id)
                    ->whereNull('employees_projects.deleted_at')
                    ->get();
        return $projects;
    }

    /**
     * Check Project is working by other employees
     * Get employee id from employees_projects table and then push these ids to array [1,1,1,2]
     * get unique valu from these array [1,2]. If unique array greater than 1 can deside that project is assigned by other employees
     * @author HponeNaingTun
     * @create 14/07/2023
     * @return boolean
     */   
    public function isProjectAssignedOtherEmployees($id) 
    {
        $employeeIdList = [];
        $uniqueEmployeeIdList = [];
        $projects = $this->getCurrentProjectsById($id);
        /**
         * iterate project and assigned employee_id to $employeeIdList
         */
        foreach ( $projects as $project ) {
            array_push($employeeIdList, $project->employee_id);
        }

        $uniqueEmployeeIdList = array_unique($employeeIdList);
        return count($uniqueEmployeeIdList) > 1;
    }

    /**
     * get projects with employee projects and documentations eger load using project id
     * @author HponeNaingTun
     * @create 14/07/2023
     * @parame
     * @return employee array
     */
    public function getProjectDocumentationsById($id)
    {
        $employee = Project::with('employeesProjects', 'employeesProjects.documentations')->find($id);
        return $employee;
    }
}