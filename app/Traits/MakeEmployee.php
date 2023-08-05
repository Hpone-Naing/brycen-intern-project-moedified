<?php

namespace App\Traits;

trait MakeEmployee
{
    use ConstantKeys;

    public function makeEmployee($employee)
    {
        $lang = '';
        $employee->level = ['levelKey' => $employee->level, 'levelValue' => $this->LEVEL[$employee->level]];
        /**
         *  In employees table, language column store 1", "2. 
         *  So split this string and make langauge from key to actual value
         */
        foreach(explode(", ", $employee->language) as $language) {
            $lang .= $this->LANGUAGE[$language] . ',';
        }
        $employee->language = $lang;
        $lang = '';
        $employee->career_part = ['careerPartKey' => $employee->career_part, 'careerPartValue' => $this->CAREER_PART[$employee->career_part]];
        $employee->gender = $this->GENDER[$employee->gender];
        return $employee;
    }

    /**
     * Assign employee's language, level, career_part from key to key value pair
     * @author HponeNaingTun
     * @create 23/06/2023
     * @param  Array employees
     * @return Array employees
     */
    public function makeEmployees($employees) 
    {
        $lang = '';

        /**
         * iterate employees and 
         * convert empoloyee's level language, career part, gener from key to actual value
         */
        foreach($employees as $employee) {
            $employees->$employee = $this->makeEmployee($employee);
            // $employee->level = ['levelKey' => $employee->level, 'levelValue' => $this->LEVEL[$employee->level]];
            // /**
            //  *  In employees table, language column store 1", "2. 
            //  *  So split this string and make langauge from key to actual value
            //  */
            // foreach(explode(", ", $employee->language) as $language) {
            //     $lang .= $this->LANGUAGE[$language] . ',';
            // }
            // $employee->language = $lang;
            // $lang = '';
            // $employee->career_part = ['careerPartKey' => $employee->career_part, 'careerPartValue' => $this->CAREER_PART[$employee->career_part]];
            // $employee->gender = $this->GENDER[$employee->gender];
        }
        return $employees;
    }

    /**
     * Assign employee's language, level, career_part from key to value
     * @author HponeNaingTun
     * @create 29/06/2023
     * @param  Array employees
     * @return Array employees
     */
    public function makeEmployeeForExcelDownload($employees) 
    {
        $lang = '';
        /**
         * iterate employees and 
         * convert empoloyee's level language, career part, gener from key to actual value
         */
        foreach($employees as $employee) {
            $employee->level = $this->LEVEL[$employee->level];//['levelKey' => $employee->level, 'levelValue' => $this->LEVEL[$employee->level]];
            /**
             *  In employees table, language column store 1", "2. 
             *  So split this string and make langauge from key to actual value
             */
            foreach(explode(", ", $employee->language) as $language) {
                $lang .= $this->LANGUAGE[$language] . ',';
            }
            /**
             * split comma(,) last position of string.
             */
            $splitedLastPositionComma = substr($lang, 0, strlen($lang)-1);
            $employee->language = $splitedLastPositionComma;
            $lang = '';
            $employee->career_part = $this->CAREER_PART[$employee->career_part];//['careerPartKey' => $employee->career_part, 'careerPartValue' => $this->CAREER_PART[$employee->career_part]];
            $employee->gender = $this->GENDER[$employee->gender];
        }
        return $employees;
    }
}