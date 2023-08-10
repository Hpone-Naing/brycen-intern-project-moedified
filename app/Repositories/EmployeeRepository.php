<?php

namespace App\Repositories;


use Carbon\Carbon;
use App\Models\Employee;
use App\Traits\ResponseAPI;
use App\Traits\ConstantKeys;
use Illuminate\Http\Request;
use App\Models\ForgetPassword;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\EmployeeInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Session\Session;

/**
 * Employee Respository
 *
 * @author  Hpone Naing Htun
 * @create  2023/06/23
 */
class EmployeeRepository implements EmployeeInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;
    use ConstantKeys;

    /**
     * get row count of employees table
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return integer
     */
    public function getEmployeesCount()
    {
        return  Employee::count();
    }

    /**
     * According to row count, make employee_id to 00001, 00011, 00111,....
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return string
     */
    public function makeEmployeeId()
    {
        $count = Employee::withTrashed()->count(); //Employee::count();
        $count++;

        /**
         * if employees table row count 1 digit add 0000
         * if employees table row count 2 digit add 000
         * if employees table row count 3 digit add 00
         * if employees table row count 4 digit add 0
         */
        if ($count >= 1 && $count <= 9) {
            return "0000" . $count;
        }
        if ($count >= 10 && $count <= 99) {
            return "000" . $count;
        }
        if ($count >= 100 && $count <= 999) {
            return "00" . $count;
        }
        if ($count >= 1000 && $count <= 9999) {
            return "0" . $count;
        }
    }

    /**
     * this is testing function not use in code.
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return string
     */
    public function makeExistingEmployeeId($employeeId)
    {
        if ($employeeId >= 1) {
            return "0000" . $employeeId;
        }
        if ($employeeId >= 10 && $employeeId <= 99) {
            return "000" . $employeeId;
        }
        if ($employeeId >= 100 && $employeeId <= 999) {
            return "00" . $employeeId;
        }
        if ($employeeId >= 1000 && $employeeId <= 9999) {
            return "0" . $employeeId;
        }
    }

    private function isAllSearchValueEmpty($request)
    {
        $searchKeys = $request->keys();
        foreach ($searchKeys as $searchKey) {
            if ($searchKey != "page") {
                $inputValue = $request->all()[$searchKey];
                if (isset($inputValue)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * get all employee, if search data exit it will return employee informations that match search data
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return array
     * @deprecated
     */
    public function getAllEmployees(Request $request)
    {
        # Check request search value ['00001', 'hponenaingtun', ...] is empty or not. if empty, return all employees
        # If not empty, get $request's key(request param name [id, name, email,....]) from [id:00001, name:"hponenaingtun", ...]
        # iterate this keys and build sql query. Example $employee->where(id, '00001') -> $employee->(key, value);
        # for id, name, email, nrc, address accept only match single character instead of the whole word. So use like operator
        if (!$this->isAllSearchValueEmpty($request)) {
            $searchKeys = $request->keys();
            $employees = Employee::query();
            foreach ($searchKeys as $searchKey) {
                #
                #
                #
                if (isset($request->all()[$searchKey])) {
                    if ($searchKey != 'page') {
                        if ($searchKey == 'employee_id' || $searchKey == 'email' || $searchKey == 'name' || $searchKey == 'nrc' || $searchKey == 'address') {
                            $employees->where($searchKey, 'like', '%' . $request->input($searchKey) . '%');
                        } else {
                            $employees->where($searchKey, $request->input($searchKey));
                        }
                    }
                }
            }
            $employees = $employees->where('role_id', '<=', $request->session()->get('logedinEmployeeRole'));
            $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER)
                ->appends($request->all());

            return $employees;
        }
        $employees = Employee::query();
        $employees = $employees->where('role_id', '<=', $request->session()->get('logedinEmployeeRole'));
        $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER);
        return $employees;

        // $careerPart = $request->career_part;
        // $level = $request->level;
        // $employeeId = $request->search;
        // $sortColumn = $request->sortColumn;
        // $sort = $request->sort;

        // /**
        //  * check search data exit or not
        //  */
        // if (isset($careerPart) || isset($level) || isset($employeeId))  //
        // {

        //     /**
        //      * if all search datas exit.
        //      *
        //      */
        //     if (isset($careerPart) && isset($level) && isset($employeeId)) {
        //         // $employees = Employee::query()
        //         //     ->where('career_part', $careerPart)
        //         //     ->where('level', $level)
        //         //     ->where('employee_id','LIKE',"%{$employeeId}%")
        //         //     ->paginate($this->DEFAULT_PAGINATE_NUMBER)
        //         //     ->appends([
        //         //         'career_part' => $careerPart,
        //         //         'level' => $level,
        //         //         'search' => $employeeId
        //         //     ]);

        //         $employees = Employee::query()
        //             ->where('career_part', $careerPart)
        //             ->where('level', $level)
        //             ->where('employee_id', 'LIKE', "%{$employeeId}%");

        //         if ( $sortColumn || isset($sortColumn) ) {
        //             $employees = $employees->orderBy($sortColumn, $sort);
        //         }

        //         $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER)
        //             ->appends([
        //                 'career_part' => $careerPart,
        //                 'level' => $level,
        //                 'search' => $employeeId
        //             ]);

        //         return $employees;
        //         /**
        //          * if among of 2 search data exit.
        //          */
        //     } elseif ((isset($careerPart) && isset($level)) || (isset($careerPart) && isset($employeeId)) || (isset($level) && isset($employeeId))) { //if among of 2 search data exit
        //         $employees = Employee::query()
        //             ->where(function ($query) use ($careerPart, $level) {
        //                 $query->where('career_part', $careerPart)
        //                     ->where('level', $level);
        //             })
        //             ->orWhere(function ($query) use ($careerPart, $employeeId) {
        //                 $query->where('career_part', $careerPart)
        //                     ->where('employee_id', 'LIKE', "%{$employeeId}%");
        //             })
        //             ->orWhere(function ($query) use ($careerPart, $level, $employeeId) {
        //                 $query->where('level', $level)
        //                     ->where('employee_id', 'LIKE', "%{$employeeId}%");
        //             });
        //         if ($sortColumn || isset($sortColumn)) {
        //             $employees = $employees->orderBy($sortColumn, $sort);
        //         }

        //         $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER)
        //             ->appends([
        //                 'career_part' => $careerPart,
        //                 'level' => $level,
        //                 'search' => $employeeId
        //             ]);
        //         return $employees;
        //         /**
        //          * if only one search data exit.
        //          */
        //     } else {
        //         /**
        //          * if careerPart exit
        //          */
        //         if (isset($careerPart)) {
        //             $employees = Employee::query()
        //                 ->where(function ($query) use ($careerPart) {
        //                     $query->where('career_part', $careerPart);
        //                 });

        //             if ( $sortColumn ) {
        //                 $employees = $employees->orderBy($sortColumn, $sort);
        //             }

        //             $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER)
        //                 ->appends([
        //                     'career_part' => $careerPart,
        //                     'level' => $level,
        //                     'search' => $employeeId
        //                 ]);
        //             return $employees;
        //         /**
        //          * if level exit
        //          */
        //         } elseif ((isset($level))) {
        //             $employees = Employee::query()
        //                 ->where(function ($query) use ($level) {
        //                     $query->where('level', $level);
        //                 });

        //             if ( $sortColumn ) {
        //                 $employees = $employees->orderBy($sortColumn, $sort);
        //             }

        //             $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER)
        //                 ->appends([
        //                     'career_part' => $careerPart,
        //                     'level' => $level,
        //                     'search' => $employeeId
        //                 ]);

        //             return $employees;
        //         /**
        //          * if employeeId exit
        //          */
        //         } else {
        //             $employees = Employee::query()
        //                 ->where(function ($query) use ($employeeId) {
        //                     $query->orWhere('employee_id', 'LIKE', "%{$employeeId}%");
        //                 });
        //             if ( $sortColumn ) {
        //                 $employees = $employees->orderBy($sortColumn, $sort);
        //             }
        //             $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER)
        //                 ->appends([
        //                     'career_part' => $careerPart,
        //                     'level' => $level,
        //                     'search' => $employeeId
        //                 ]);
        //             return $employees;
        //         }
        //     }
        //     /**
        //      * if no search data exit.
        //      */
        // } else {
        //     $employees = Employee::query();
        //     if ($sortColumn || isset($sortColumn)) {
        //         $employees = $employees->orderBy($sortColumn, $sort);
        //     }
        //     $employees = $employees->paginate($this->DEFAULT_PAGINATE_NUMBER);
        //     return $employees;
        // }
    }

    /**
     * Eger loading Employees with programmingLanguages by employee id
     * @author HponeNaingTun
     * @create 26/06/2023
     * @return array
     */
    public function getEmployeeById($id)
    {
        $employee = Employee::with('programmingLanguages')->find($id);
        return $employee;
    }

    /**
     * get employees by id
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return array
     */
    public function getEmployeeByIdLazyLoad($id)
    {
        $employee = Employee::find($id);
        return $employee;
    }

    /**
     * get employee with projects, documentations eger load using employee id
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return employee object
     */
    public function getEmployeeByIdEgerLoad($id)
    {
        // $employee = Employee::with('projects', 'projects.documentations', 'programmingLanguages')->find($id);
        $employee = Employee::with('projects', 'employeesProjects.documentations', 'programmingLanguages')->find($id);
        return $employee;

        // $employee = Employee::with('projects', 'employeeProjects', 'projects.documentations')->find($id);
        // return $employee;
    }


    /**
     * get employee with projects eger load using employee id
     * @author HponeNaingTun
     * @create 29/06/2023
     * @parame
     * @return employee array
     */
    public function getEmployeeProjectById($id)
    {
        $employee = Employee::with('projects')->find($id);
        return $employee;
    }

    /**
     * get all employees with projects, documentations eger load
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return array
     */
    public function getEmployeesProjectsEgerLoad()
    {
        $employees = Employee::with('projects', 'projects.documentations', 'projects.employees')->get();
        return $employees;
    }

    /**
     * get all employees with id, employee_id of employee table
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return array
     */
    public function getIds()
    {
        $employees = Employee::select('id', 'employee_id')->get();
        return $employees;
    }

    /**
     * get all employees with custom columns of employees table,
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return array
     */
    public function getEmployeesOptionalColumns($columns)
    {
        $query = Employee::query();
        foreach ($columns as $column) {
            $query->select($column);
        }
        $employees = $query->get();
        return $employees;
    }

    /**
     * get employee with custom columns of employees table using employee id
     * @author HponeNaingTun
     * @create 29/06/2023
     * @return employee
     */
    public function getEmployeesByIdOptionalColumns($columns, $id)
    {
        $query = Employee::query();
        foreach ($columns as $column) {
            $query->addSelect($column);
        }
        $employee = $query->find($id);
        return $employee;
    }

    # -----------add new fetures----------

    /**
     * Get all resigned employees, they have been deleted
     * 
     * @author HponeNaingTun
     * 
     * @create 31/07/2023
     * 
     * return array
     * 
     * @access  public
     */
    public function getResignedEmployees()
    {
        return Employee::withTrashed()->whereNotNull("deleted_at")->get();
    }

    /**
     * Get all active employees, they have not been deleted
     * 
     * @author HponeNaingTun
     * 
     * @create 31/07/2023
     * 
     * return array
     * 
     * @access  public
     */
    public function getActiveEmployees()
    {
        $employees = Employee::get();
        return $employees;
    }

    /**
     * Get all birthday employees. current date == date of birth
     * 
     * @author HponeNaingTun
     * 
     * @create 31/07/2023
     * 
     * return array
     * 
     * @access  public
     */
    public function getBirthdayEmployees()
    {
        $activeEmployees = $this->getActiveEmployees();
        $birthdayEmployees = [];
        foreach ($activeEmployees as $activeEmployee) {
            $dateOfBirth = Carbon::parse($activeEmployee->date_of_birth)->format("m-d");
            if ($dateOfBirth == date('m-d')) {
                array_push($birthdayEmployees, $activeEmployee);
            }
        }
        return $birthdayEmployees;
    }

    /**
     * Get an employee by employeeId with custom columns. eg from all columns of employees table, you want only id, name => ['id', 'name']
     * 
     * @author HponeNaingTun
     * 
     * @create 31/07/2023
     * 
     * return array
     * 
     * @access  public
     */
    public function getEmployeesByEmployeeIdOptionalColumns($columns, $employeeId)
    {
        $query = Employee::query();
        foreach ($columns as $column) {
            $query->addSelect($column);
        }
        $employee = $query->where('employee_id', $employeeId)->first();
        return $employee;
    }

    /**
     * Get all employee by role
     * 
     * @author HponeNaingTun
     * 
     * @create 31/07/2023
     * 
     * @param string $role
     * 
     * return array
     * 
     * @access  public
     */
    public function getEmployeesByRoles($role)
    {
        $employees = Employee::where('role_id', $role)->get();
        return $employees;
    }

    /**
     * Get all password request employees from forgetpassword table where status column = 'pending'
     * 
     * @author HponeNaingTun
     * 
     * @create 02/08/2023
     * 
     * return array
     * 
     * @access  public
     */
    public function getInProgressToResetPasswordList($employeeId)
    {
        # Login employee is general manager(role = 4), he can see all reset password request employees.
        if (session()->get('logedinEmployeeRole') > 3) {
            $totalPendingResetPasswordList = ForgetPassword::where('status', $this->PENDING)->get();
            return $totalPendingResetPasswordList;
        }
        # Login employee is lower general manager (role < 4), they can see their associated reset password request employees.
        $totalPendingResetPasswordList = ForgetPassword::where('heigher_level_role_id', $employeeId)->where('status', $this->PENDING)->get();
        return $totalPendingResetPasswordList;
    }
}
