<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface EmployeeInterface
{

/**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023
     * 
     * Get employee table row count
     * 
     * @method  GET api/employees/rows-counts
     * 
     * @access  public
     * 
     * return integer
     */
    public function getEmployeesCount();

    /**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023
     * 
     * Get maked employee id.
     * 
     * @method  GET api/employees/make-employees-id
     * 
     * @access  public
     * 
     * return integer
     */
    public function makeEmployeeId();

    /**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023
     * 
     * Get all Employees
     * 
     * @param   Request request
     * 
     * @access  public
     * 
     * return array
    */
    public function getAllEmployees(Request $request);

    /**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023
     * 
     * Get Employee By ID
     * 
     * @param   integer     $id
     * 
     * return employee
     * 
     * @access  public
     */
    public function getEmployeeById($id);

    /**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023
     * 
     * This is testing function
     * 
     * @param   integer     $employeeId
     *  
     * @access  public
     * 
     * return integer
     */
    public function makeExistingEmployeeId($employeeId);

    /**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023
     * 
     * Get all Employees, projects, documentations that match employee id
     * 
     * @param   integer     $id
     * 
     * return employee object
     * 
     * @access  public
     */
    public function getEmployeeByIdEgerLoad($id);

    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get all Employees, projects that match employee id
     * 
     * @param   integer     $id
     * 
     * return employee object
     * 
     * @access  public
     */
    public function getEmployeeProjectById($id);

    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get all Employees, projects, documentations
     * 
     * return array
     * 
     * @access  public
     */
    public function getEmployeesProjectsEgerLoad();
    
    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get all Employees only id and employee_id column
     * 
     * return array
     * 
     * @access  public
     */
    public function getIds();

    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get only all Employees by id
     * 
     * @param   integer     $id
     * 
     * return array
     * 
     * @access  public
     */
    public function getEmployeeByIdLazyLoad($id);

    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get only all Employees by optional columns
     * 
     * @param   array 
     * 
     * return array
     * 
     * @access  public
     */
    public function getEmployeesOptionalColumns($columns);

    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get only  Employee  optional data(name, email,....)  that match employee id
     * 
     * @param   array 
     * 
     * return array
     * 
     * @access  public
     */
    public function getEmployeesByIdOptionalColumns($columns, $id);


    # Modified code
    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get all resigned employees
     * 
     * @param   array 
     * 
     * return array
     * 
     * @access  public
     */
    public function getResignedEmployees();

    public function getActiveEmployees();

    public function getBirthdayEmployees();

    public function getEmployeesByEmployeeIdOptionalColumns($columns, $employeeId);
    
    public function getEmployeesByRoles($role);

    public function getInProgressToResetPasswordList($employeeId);

}