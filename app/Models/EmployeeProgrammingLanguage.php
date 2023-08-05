<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeProgrammingLanguage extends Pivot
{
    use SoftDeletes;
    
    protected $table = "employees_programming_languages";
}
