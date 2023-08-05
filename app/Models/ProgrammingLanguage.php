<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammingLanguage extends Model
{
    use SoftDeletes;

    /**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023    
     * 
     * many to many relation with  employees table
     * 
     * @access  public
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_programming_languages'); // if not set employees_programming_languages error show employee_programming_language does not exit.
    }
}
