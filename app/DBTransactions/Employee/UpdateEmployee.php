<?php

namespace App\DBTransactions\Employee;

use Carbon\Carbon;
use App\Models\Employee;
use App\Traits\SaveFile;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\Session;
use App\DBTransactions\EmployeeProgrammingLanguage\UpdateEmployeeProgrammingLanguage;
use Illuminate\Support\Facades\Hash;

/**
 * Update Employee
 *
 * @author  Hpone Naing Htun
 * @create  2023/06/23
 */
class UpdateEmployee extends DBTransaction
{
    use SaveFile;
    private $request, $id;

    /**
     * Constructor to assign request and employee id
     */
    public function __construct($request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }

    /**
     * update employee
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return associative array
     */
    public function process()
    {
        $request = $this->request;
        $id = $this->id;

        $fileName = "";
        $file = $request->image;
        $oldPhoto = $request->input('data-image');
        /**
         * user chage photo, old photo will remove from public path and new photo will save in public path.
         */
        if ( isset($file) && $file ) {
            /**
             * check old photo exit or not
            */
            if ( $oldPhoto || isset($oldPhoto) ) {
                $this->deleteFiles([$oldPhoto], "public", "employee-photo");
            }
            $fileList = [];
            array_push($fileList, $file);
            $filesInfos = $this->saveFiles($fileList, "public", "employee-photo");
            $fileName = $filesInfos[0]["name"];
        } else {
            $fileName = $request->input('data-image');
        }
 
        $update = Employee::where("id", $id)->update(
            [
                'password' => Hash::make($request->password),
                "name" => $request->name,
                "nrc" => $request->nrc,
                "phone" => $request->phone,
                "email" => $request->email,
                "gender" => $request->gender,
                "date_of_birth" => Carbon::createFromFormat('Y-m-d', $request->date_of_birth)->format('Y-m-d'),
                "address" => $request->address,
                "employment_type" => $request->employment_type,
                "role_id" => $request->role,
                "language" => implode(', ', $request->languages),
                "career_part" => $request->career_part,
                "level" => $request->level,
                "image" => $fileName,
                'updated_by' => Session::get("login-user"),
                'updated_at' => Carbon::now()
            ]
        );

        $programmingLanguages = [];
        /**
         * iterate programming_languages from request data and programming_language_id to programmingLanguage
         */
        foreach ( $request->programming_languages as $programmingLanguage ) {
            $programmingLanguageId = $programmingLanguage;
            array_push($programmingLanguages, $programmingLanguageId);
        }

        $updateEmployeeProgrammingLanguage = new UpdateEmployeeProgrammingLanguage($programmingLanguages, $id);
        $updatedEmpProgLang = $updateEmployeeProgrammingLanguage->executeProcess();
        /**
         * if updateEmployee or update employee programming language not success, return fail
         */
        if ( !$update || !$updatedEmpProgLang ) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        /**
         * if updateEmployee or update employee programming language success, return no error
         */
        return ['status' => true, 'error' => ''];
    }
}