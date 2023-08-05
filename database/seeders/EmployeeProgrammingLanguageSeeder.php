<?php

namespace Database\Seeders;

use App\Models\EmployeeProgrammingLanguage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeProgrammingLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => '1', "employee_id" => "1",  "programming_language_id" => "1", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', "employee_id" => "2",  "programming_language_id" => "2", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', "employee_id" => "3",  "programming_language_id" => "3", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', "employee_id" => "4",  "programming_language_id" => "4", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '5', "employee_id" => "5",  "programming_language_id" => "5", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        // Insert the data into the database
        EmployeeProgrammingLanguage::insert($data);
    }
}
