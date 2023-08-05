<?php

namespace App\Http\Controllers;

use App\DBTransactions\Project\DeleteProject;
use App\Traits\SaveFile;
use Illuminate\Http\Request;
use App\Interfaces\ProjectInterface;
use App\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\Session;
use App\DBTransactions\Project\SaveProject;
use App\Http\Requests\ProjectAssignmentRequest;
use App\DBTransactions\ProjectAssignment\SaveProjectAssignment;
use App\Http\Requests\ProjectRequest;

class ProjectAssignmentController extends Controller
{
    protected $employeeInterface, $projectInterface;

    /**
     * Constructor to assign EmployeeInterface, projectInterface
     */
    public function __construct(EmployeeInterface $employeeInterface, ProjectInterface $projectInterface)
    {
        $this->employeeInterface = $employeeInterface;
        $this->projectInterface = $projectInterface;
    }

    /**
     * show ProjectAssign save form
     * @author HponeNaingTun
     * @create 29/06/2023
     * @param  Request  $request
     * @return view show ProjectAssignment save form
     */
    public function getCreateForm() 
    {
        $employees = $this->employeeInterface->getIds();
        // $currentProjects = $this->projectInterface->getAllCurrentProjects();
        $currentProjects = $this->projectInterface->getAllProjects();
        return view('project-assignment.create', compact("employees", "currentProjects"));
    }

    /**
     * save project to projet to db
     * @author HponeNaingTun
     * @create 29/06/2023
     * @param  Request  $request
     * @return if success view show ProjectAssignment save form
     * @return if fail view show ProjectAssignment save form
     */
    public function saveProject(ProjectRequest $request) 
    {
        $employeeId = $request->employee_id;
        $employeeName = $request->employee_name;
        $projectName = $request->add_project_name;
        $oldProjectName = $request->save_form_project_name;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $saveProject = new SaveProject($projectName);
        $save = $saveProject->executeProcess();
        if ( $save ) {
            Session::flash("success", "Save Success");
            Session::flash("selectedEmployeeId", $employeeId);
            Session::flash("selectedEmployeeName", $employeeName);
            if( isset($projectName) ) {
                Session::flash("selectedProjectName", $projectName);
            } else {
                Session::flash("selectedProjectName", $oldProjectName);
            }
            Session::flash("selectedStartDate", $startDate);
            Session::flash("selectedEndDate", $endDate);
            return redirect()->back();
        } else {
            Session::flash("saveError", "Save Fail!");
            return redirect()->back();
        }

    }

    /**
     * for js api call, get all projects datas.
     * @author HponeNaingTun
     * @create 29/06/2023
     * @param  Request  $request
     * @return view show ProjectAssignment save form
     */
    public function getAllProjects() 
    {
        $projects = $this->projectInterface->getAllProjects();
        return response()->json(
            [
                "status"=>"success",
                'data' => $projects
            ]
        );
    }

    /**
     * save project assignment
     * @author HponeNaingTun
     * @create 02/07/2023
     * @param  Request  $request
     * @return view show ProjectAssignment save form
     */
    public function saveProjectAssignment(ProjectAssignmentRequest $request) 
    {
        $save = new SaveProjectAssignment($request, $this->employeeInterface, $this->projectInterface);
        $save = $save->executeProcess();
        if ( $save ) {
            Session::flash("success", "Save Success");
            return redirect()->back();

        } else {
            Session::flash("saveError", "Save Fail!");
            return redirect()->back();
        }
    }

    /**
     * delete project
     * @author HponeNaingTun
     * @create 02/07/2023
     * @param  Request  $request
     * @return view show ProjectAssignment save form
     */
    public function deleteProject(Request $request) 
    {
        $projectId = $request->delete_project;
        $isProjectAssignedOtherEmployees = $this->projectInterface->isProjectAssignedOtherEmployees($projectId);
        // $currentWorkingProject = $this->projectInterface->getCurrentProjectsById($projectId);
        if ( $isProjectAssignedOtherEmployees ) {
            Session::flash("saveError", "Project is currently inprogress.");
            return redirect()->back();
        } 
        $deleteProject = new DeleteProject($projectId, $this->projectInterface);
        $delete = $deleteProject->executeProcess();
        if ( $delete ) {
            Session::flash("success", "Delete Success");
            return redirect()->back();
        } else {
            Session::flash("saveError", "Delete Fail!");
            return redirect()->back();
            
        }
    }

    /**
     * download documentation
     * @author HponeNaingTun
     * @create 02/07/2023
     * @param stirng  $filename
     * @return download file
     */
    public function downloadDocumentations($file)
    {
        $filePath = storage_path('app/documentations/' . $file);
        /**
         * check documentation fill exit in storage path appp/documentations or not.
         */
        if ( file_exists($filePath) ) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
    }

    # --------------Add new feature and ui template----------------------

    /**
     * show ProjectAssign save form
     * @author HponeNaingTun
     * @create 29/06/2023
     * @param  Request  $request
     * @return view show ProjectAssignment save form
     */
    public function getProjectAssignmentForm() 
    {
        $employees = $this->employeeInterface->getIds();
        // $currentProjects = $this->projectInterface->getAllCurrentProjects();
        $currentProjects = $this->projectInterface->getAllProjects();
        return view('project-assignment.add-new-pj', compact("employees", "currentProjects"));
    }
}
