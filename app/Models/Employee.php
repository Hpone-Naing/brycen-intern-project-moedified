<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    /**
     * @author HponeNaingTun
     * 
     * @create 20/06/2023    
     * 
     * many to many relation with programming languages table
     * 
     * @access  public
     */
    public function programmingLanguages()
    {
        return $this->belongsToMany(ProgrammingLanguage::class, 'employees_programming_languages'); // if not set employees_programming_languages error show employee_programming_language does not exit.
    }

    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023    
     * 
     * many to many relation with projects table
     * 
     * @access  public
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employees_projects')->withPivot('start_date', 'end_date');
    }

    public function employeesProjects()
    {
        return $this->hasMany(EmployeeProject::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
