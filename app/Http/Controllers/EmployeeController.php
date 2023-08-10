<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Traits\ResponseAPI;
use App\Traits\ConstantKeys;
use App\Traits\MakeEmployee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Interfaces\EmployeeInterface;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Session;
use App\DBTransactions\Employee\SaveEmployee;
use App\DBTransactions\Employee\DeleteEmployee;
use App\DBTransactions\Employee\UpdateEmployee;

class EmployeeController extends Controller
{
    use ResponseAPI;
    use ConstantKeys;
    use MakeEmployee;

    protected $employeeInterface;

    /**
     * Constructor to assign EmployeeInterface
     */
    public function __construct(EmployeeInterface $employeeInterface)
    {
        $this->employeeInterface = $employeeInterface;
    }

    /**
     * For Javascript api call, retrieve row count of employees table, and then make that count to get employee id. eg 00001, 00019, 00111,...
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return json format
     */
    public function getMakedEmployeeId()
    {
        $employeesCount =  $this->employeeInterface->makeEmployeeId();
        return response()->json(
            [
                "status" => "success",
                'data' => $employeesCount
            ]
        );
    }


    /**
     * show employee form
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param  Request  $request
     * @return view showEmployeeForm
     */
    public function showEmployeesForm(Request $request)
    {
        $employeeList = $this->employeeInterface->getAllEmployees($request);
        $employees = $this->makeEmployees($employeeList);
        return view("employee.index", compact("employees"));
    }

    /**
     * show save form
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return view saveForm
     */
    public function showSaveForm()
    {
        return view('employee.create');
    }

    /**
     * show edit form
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param  Request  $request
     * @return view editform
     */
    public function showEditForm(Request $request)
    {
        $employee = $this->employeeInterface->getEmployeeById($request->employee_id);
        return view('employee.edit', compact("employee"));
    }

    /**
     * show detail form
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param  Request  $request
     * @return view detailform
     */
    public function showDetailForm(Request $request)
    {
        $employees = $this->employeeInterface->getEmployeeByIdEgerLoad($request->employee_id);
        $employee = $this->makeEmployee($employees);
        return view('employee.detail', compact("employee"));
    }

    /**
     * get all employees from db, if search data exit only return search results.
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param  Request  $request
     * @return if success, view index form
     */
    public function getAllEmployee(Request $request)
    {
        return view("employees.index", compact("employees"));
    }

    /**
     * save employee from database
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param  EmployeeRequest  $request
     * @return if success, view index form
     * @return if fail view index form
     */
    public function saveEmployee(EmployeeRequest $request)
    {
        $save = new SaveEmployee($request);
        $save = $save->executeProcess();
        if ($save) {
            Session::flash("success", "Save Success");
            return redirect()->back();
        } else {
            Session::flash("saveError", "Save Fail!");
            return redirect()->back();
        }
    }

    /**
     * download Excel
     * @author HponeNaingTun
     * @create 23/06/2023
     * @param  Request  $request
     * @return Reirect Response
     */
    // public function downloadExcel(Request $request)
    // {
    //     return Excel::download(new EmployeeExport($request, $this->employeeInterface), 'EmployeeInformations-'. time()  . '.xlsx');
    // }

    /**
     * download pad
     * @author HponeNaingTun
     * @create 23/06/2023
     * @param  Request  $request
     * @return Reirect Response
     */
    // public function downloadPdf(Request $request) 
    // {
    //     $employeeList = $this->employeeInterface->getAllEmployees($request);
    //     $employees = $this->makeEmployees($employeeList);
    //     $this->generate($employees);
    // }

    /**
     * Update Employee data into DB.
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param  Request  $tempData
     * @param  integer  $id
     * @return if success, view index form
     * @return if fail view create form
     */
    public function updateEmployee(EmployeeRequest $request, $id)
    {
        // try {
        $updateEmployee = new UpdateEmployee($request, $id);
        $employee = $updateEmployee->executeProcess();

        if ($employee) {
            Session::flash("success", "Update Success");
            // return redirect("show-all-pages");
            # modified code
            return redirect("list");


        } else {
            Session::flash("saveError", "Update Fail!");
            // return redirect("show-all-pages");
            # modified code
            return redirect("list");
        }
    }

    /**
     * Delete Employee data into DB.
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param  Request  $tempData
     * @return if success, view index form
     * @return if fail view create form
     */
    public function deleteEmployee(Request $request)
    {
        $employeeId = $request->employee_id;
        $deleteEmployee = new DeleteEmployee($employeeId, $this->employeeInterface);
        $employee = $deleteEmployee->executeProcess();
        if ($employee) {
            Session::flash("success", "Delete Success");
            // return redirect("show-all-pages");
            # modified code
            return redirect("list");
        } else {
            Session::flash("saveError", "Delete Fail!");
            // return redirect("show-all-pages");
            # modified code
            return redirect("list");
        }
    }

    /**
     * for javascript api call, it will return match employee informations with optional column lazy load that match id
     * @author HponeNaingTun
     * @create 29/06/2023
     * @param  integer  $id
     * @return json format
     */
    public function getEmployeeByIdLazyLoad($id)
    {
        $columns = ['name'];
        $employee = $this->employeeInterface->getEmployeesByIdOptionalColumns($columns, $id);
        return response()->json(
            [
                "status" => "success",
                'data' => $employee
            ]
        );
    }

    /**
     * for javascript api call, it will return Employee (eger load) match employee id
     * @author HponeNaingTun
     * @create 29/06/2023
     * @param  integer  $id
     * @return json format
     */
    public function getEmployeeProjectById($id)
    {
        $employee = $this->employeeInterface->getEmployeeProjectById($id);
        return response()->json(
            [
                "status" => "success",
                'data' => $employee
            ]
        );
    }

    /**
     * --------------Add new feature and ui template----------------------
    */

    /**
     * show employee dashboard form
     * 
     * @author HponeNaingTun
     * 
     * @create 31/07/2023
     * 
     * @return view employee/dashboard/dashboard.blade.php
     */
    public function showDashboard()
    {
        $activeEmployees = $this->employeeInterface->getActiveEmployees();
        $birthdayEmployees = $this->employeeInterface->getBirthdayEmployees();
        $resignedEmployees = $this->employeeInterface->getResignedEmployees();
        return view("dashboard.dashboard", compact('activeEmployees', 'birthdayEmployees','resignedEmployees'));
    }

    /**
     * Get employee list form
     * 
     * @author HponeNaingTun
     * 
     * @create 31/07/2023
     * 
     * @return view employee/list.blade.php
     */
    public function showAllEmployees(Request $request)
    {
        $employeeList = $this->employeeInterface->getAllEmployees($request);
        $employees = $this->makeEmployees($employeeList);
        return view("employee.list", compact("employees"));
    }

    /**
     * Get add new employee form
     * 
     * @author HponeNaingTun
     * 
     * @create 31/08/2023
     * 
     * @return view employee/add-new.blade.php
     */
    public function getCreateForm()
    {
        $autoGenerateEmployeeId =  $this->employeeInterface->makeEmployeeId();
        return view("employee.add-new", compact('autoGenerateEmployeeId'));
    }

    /**
     * Get employee edit form
     * 
     * @author HponeNaingTun
     * 
     * @create 31/08/2023
     * 
     * @return view employee/update-emp.blade.php
     */
    public function getEditForm(Request $request)
    {
        $employee = $this->employeeInterface->getEmployeeById($request->employee_id);
        return view("employee.update-emp", compact('employee'));
    }

     /**
     * for javascript api call (For dashboard chart), it will return all employees have not been deleted 
     * 
     * @author HponeNaingTun
     * 
     * @create 31/08/2023
     * 
     * @return json format
     */
    public function getActiveEmployees()
    {
        $employeeList = $this->employeeInterface->getActiveEmployees();
        $employees = $this->makeEmployees($employeeList);
        return response()->json(
            [
                "status" => "success",
                'data' => $employees
            ]
        );
    }
}

