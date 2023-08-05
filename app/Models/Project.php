<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [];
    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023    
     * 
     * many to many relation with  employees table
     * 
     * @access  public
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_projects')->withPivot('start_date', 'end_date');
    }

    public function employeesProjects()
    {
        return $this->hasMany(EmployeeProject::class);
    }
}
