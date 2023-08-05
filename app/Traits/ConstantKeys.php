<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;

trait ConstantKeys
{

    /**
     * Set default paginate number
     * @author HponeNaingTun
     */
    public $DEFAULT_PAGINATE_NUMBER = 5;

    public $LANGUAGE = [
        "1" => "English",
        "2" => "Japanese"
    ];

    public $CAREER_PART = [
        "1" => "Font End",
        "2" => "Back End",
        "3" => "Full Stack",
        "4" => "Mobile"
    ];

    public $LEVEL = [
        "1" => "Begineer",
        "2" => "Junior Engineer",
        "3" => "Engineer",
        "4" => "Senior Engineer"
    ];

    public $GENDER = [
        "1" => 'Male',
        "2" => 'Female'
    ];

    public $ROLE = [
        "employee" => "1",
        "admin" => "2",
        "manager" => "3",
        "gm" => "4"
    ];

    public $PENDING = 0;
    
    public $COMPLETE = 1;
}
