<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ProgrammingLanguage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgrammingLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => '1', "name" => "C++", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', "name" => "Java", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', "name" => "PHP", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', "name" => "React", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '5', "name" => "Android", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '6', "name" => "Laravel", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        // Insert the data into the database
        ProgrammingLanguage::insert($data);
    }
}
