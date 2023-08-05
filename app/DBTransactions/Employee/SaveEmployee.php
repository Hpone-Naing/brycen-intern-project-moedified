<?php

namespace App\DBTransactions\Employee;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Employee;
use App\Traits\SaveFile;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\DBTransactions\EmployeeProgrammingLanguage\SaveEmployeeProgrammingLanguage;

class SaveEmployee extends DBTransaction
{
    use SaveFile;
    private $request;

    /**
     * Constructor to assign request to variable
     */
    public function __construct($request)
    {
        $this->request = $request;
        
    }

     /**
     * save employee
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return associative array
     */
    public function process()
    {
        $request = $this->request;
        $employee = new Employee;
        $employee->employee_id = $request->employee_id;
        $employee->password = Hash::make($request->password);
        $employee->name = $request->name;
        $employee->nrc = $request->nrc;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->gender = $request->gender;
        $employee->date_of_birth =  Carbon::createFromFormat('Y-m-d', $request->date_of_birth)->format('Y-m-d');
        $employee->address = $request->address;
        $employee->role_id = $request->role;
        $employee->employment_type = $request->employment_type;
        $employee->language = implode(', ', $request->languages);
        $employee->career_part = $request->career_part;
        $employee->level = $request->level;
        $employee->created_at = Carbon::now();
        $employee->updated_at = Carbon::now();
        $employee->created_by =  Session::get("login-user");

        $file = $request->image;
        if( isset($file) && $file ) {
            $fileList = [];
            array_push($fileList, $file);
            $fileName = $this->saveFiles($fileList, "public", "employee-photo");
            $employee->image = $fileName[0]["name"];
        }
        
        // $role = new Role();
        // $role->role_name = $request->role;
        // $role->save();
        // $employee->role()->associate($role);
        $employee->save();

        $programmingLanguages = [];
        /**
         * Iterate programming_languages from request data and then create 2D array $employeeProgrammingLanguage 
         * and push employee_id and programming_language_id and then push these 2d array to $programmingLanguages array
         */
        foreach ( $request->programming_languages as $programmingLanguage ) {  
            $employeeId = $employee->id; 
            $programmingLanguageId = $programmingLanguage;
            $employeeProgrammingLanguage = [
                "employee_id" => $employeeId,
                "programming_language_id" => $programmingLanguageId
            ];
           array_push($programmingLanguages, $employeeProgrammingLanguage);
        }

        $SaveEmployeeProgrammingLanguage = new SaveEmployeeProgrammingLanguage($programmingLanguages);
        $save = $SaveEmployeeProgrammingLanguage->executeProcess();
        if ( !$employee || !$save ) { #this row is save or not
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}