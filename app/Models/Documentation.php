<?php

namespace App\Models;

use App\Models\EmployeeProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documentation extends Model
{
    use SoftDeletes;

    protected $fillable = ['employees_projects_id'];

    
    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023    
     * 
     * many to one relation bi-directional with projects table
     * 
     * @access  public
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employeeProject()
    {
        return $this->belongsTo(EmployeeProject::class, 'employees_projects_id');
    }
}
