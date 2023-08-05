<?php

namespace App\DBTransactions\ProjectAssignment;

use Carbon\Carbon;
use App\Traits\SaveFile;
use App\Models\Documentation;
use App\Classes\DBTransaction;
use App\Interfaces\ProjectInterface;
use App\Interfaces\EmployeeInterface;
use App\Models\EmployeeProject;

class SaveProjectAssignment extends DBTransaction
{
    use SaveFile;

    private $request;

    protected $employeeInterface, $projectInterface;

    /**
     * Constructor to assign EmployeeInterface, projectInterface, $request
     */
    public function __construct($request, EmployeeInterface $employeeInterface, ProjectInterface $projectInterface)
    {
        $this->request = $request;
        $this->employeeInterface = $employeeInterface;
        $this->projectInterface = $projectInterface;
    }

    /**
     * save project assignment
     * @author HponeNaingTun
     * @create 22/06/2023
     * @return associative array
     */
    public function process()
    {
        $request = $this->request;
        $documentationSaveStatus = true;
        $employeeId = $request->employee_id;
        $projectId = $request->project_name;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        /**
         * check documentation files exit or not
         * if exit save that files to storage app/documentations
         */
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $filesInfos = $this->saveFiles($files, "storage", "documentations");
        }

        $employeeProject = new EmployeeProject;
        $employeeProject->employee_id = $employeeId;
        $employeeProject->project_id = $projectId;
        $employeeProject->start_date = $startDate;
        $employeeProject->end_date = $endDate;
        $saveEmployeeProject = $employeeProject->save();
        
        /**
         * iterate documentations file and get fileName, fileSize and filePath from that documentation and
         *  save to documentations table
         */
        foreach ($filesInfos as $fileInfo) {
            $documentation = new Documentation;
            $fileName = $fileInfo["name"];
            $filePath = $fileInfo["path"];
            $fileSize = $fileInfo["size"];
            $documentation->file_name = $fileName;
            $documentation->file_path = $filePath;
            $documentation->file_size = $fileSize;
            $documentation->employeeProject()->associate($employeeProject);
            $saveDocumentation =  $documentation->save();
            if (!$saveDocumentation) {
                $documentationSaveStatus = false;
                return;
            }
        }

        if (!$saveEmployeeProject || !$documentationSaveStatus) { #this row is save or not
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
