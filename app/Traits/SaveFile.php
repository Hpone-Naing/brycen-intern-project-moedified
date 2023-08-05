<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


trait SaveFile
{
    
    /**
     * get file path
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param   UploadFile  $File
     * @return string
     */
    function getFilePath(UploadedFile $file)
    {
        $filePath = $file->path();
        return $filePath;
    }

     /**
     * get file size
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param   UploadFile   $File
     * @return int
     */
    function getFileSize(UploadedFile $file)
    {
        $fileSize = $file->getSize();
        return $fileSize;
    }

    /**
     * get file name
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param   UploadFile     $File
     * @return string
     */
    function getFileName(UploadedFile $file)
    {
        $FileName = uniqid() . $file->getClientOriginalName();
        return $FileName;
    }

    /**
     * save files
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param   array    $files
     * @param   string    $filePath
     * @param   string    $saveFolder
     */
    function saveFiles(array $files, $filePath, string $saveFolder)
    {
        $filesInfos = [];
        
        //$path = Storage::putFile($saveFolder, $file);
        switch ( $filePath ) {
            case "public" : 
                foreach ( $files as $file ) {
                    $fileName = $this->getFileName($file);
                    array_push($filesInfos, [
                        "name" => $fileName,
                        "path" => $this->getFilePath($file),
                        "size" => $this->getFileSize($file)
                    ]);
                
                    // $fileName = uniqid().$file->getClientOriginalName();
                    $file->move(public_path($saveFolder), $fileName);
                }
                return $filesInfos;
                case "storage" : 
                    foreach ( $files as $file ) {
                        $fileName = $this->getFileName($file);
                        array_push($filesInfos, [
                            "name" => $fileName,
                            "path" => $this->getFilePath($file),
                            "size" => $this->getFileSize($file)
                        ]);
                    
                        $path = $saveFolder . '/' . $fileName;
                        Storage::disk('local')->put($path, file_get_contents($file));

                    }
                    return $filesInfos;
                    // $fileName = uniqid().$file->getClientOriginalName();
            }
    }

    /**
     * delete files
     * @author HponeNaingTun
     * @create 22/06/2023
     * @param   array    $files
     * @param   string    $filePath
     * @param   string    $dir
     */
    function deleteFiles(array $files, $filePath, $dir)
    {   /**
        * check filepath public or storage
        */
        switch ( $filePath ) {
            case "public" : 
                /**
                 * iterate files name
                 */
                foreach ( $files as $file ) {   
                    $filePath = public_path($dir."/".$file);
                    if( file_exists($filePath) ) {
                        File::delete($filePath);
                    } 
                }
            break;
                case "storage" : 
                    /**
                     * iterate files name
                     */
                    foreach ( $files as $file ) {
                        $path = storage_path($dir . '/' . $file);
                        if ( file_exists($path) ) {
                            File::delete($path);
                        } 
                    }
            break;
            }
    }

}