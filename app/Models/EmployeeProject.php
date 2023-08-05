<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * EmployeeProject model
 *
 * @author  Hpone Naing Htun
 * 
 * @create  2023/06/29
 */
class EmployeeProject extends Model
{
    use SoftDeletes;

    protected $table = "employees_projects";

    public function documentations()
    {
        return $this->hasMany(Documentation::class, 'employees_projects_id');
    }
}
