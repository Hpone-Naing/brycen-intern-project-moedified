<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => '1', "employee_id" => "00001", "password" => Hash::make("hponenaing"), "name" => "Hpone Naing Tun", "nrc" => "12/OOKATA(N)189258", "phone" => "0912345678", "email" => "hponenaingtun@gmail.com",  "gender" => 1, "date_of_birth" => Carbon::now(), "address" => "Yangon", "role_id" => 4,'employment_type' => 2, "language" => "1, 2", "career_part" => 3, "level" => 4,  "created_at" => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', "employee_id" => "00002", "password" => Hash::make("thunandar"), "name" => "Thu Nandar Aye Min", "nrc" => "12/OOKATA(N)189259", "phone" => "0912345679", "email" => "thunandarayemin@gmail.com",  "gender" => 2, "date_of_birth" => Carbon::now(), "address" => "Yangon, Mandalay", "role_id" => 3,'employment_type' => 2, "language" => "1, 2", "career_part" => 3, "level" => 4,  "created_at" => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', "employee_id" => "00003", "password" => Hash::make("eimonkyaw"), "name" => "Ei Mon Kyaw", "nrc" => "12/OOKATA(N)189248", "phone" => "0912345668", "email" => "eimonkyaw@gmail.com",  "gender" => 2, "date_of_birth" => Carbon::now(), "address" => "Yangon, Mandalay", "role_id" => 1,'employment_type' => 1, "language" => "1, 2", "career_part" => 1, "level" => 1,  "created_at" => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', "employee_id" => "00004", "password" => Hash::make("zinmyo"), "name" => "Zin Myo Htet Aung", "nrc" => "12/OOKATA(N)189249", "phone" => "0912345669", "email" => "zinmyo@gmail.com",  "gender" => 1, "date_of_birth" => Carbon::now(), "address" => "Yangon, Mandalay", "role_id" => 1,'employment_type' => 1, "language" => "1, 2", "career_part" => 1, "level" => 1,  "created_at" => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '5', "employee_id" => "00005", "password" => Hash::make("ying"), "name" => "Ying", "nrc" => "12/OOKATA(N)189238", "phone" => "0912345659", "email" => "ying@gmail.com",  "gender" => 2, "date_of_birth" => Carbon::now(), "address" => "Yangon, Mandalay", "role_id" => 2,'employment_type' => 2, "language" => "1, 2", "career_part" => 2, "level" => 3,  "created_at" => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        // Insert the data into the database
        Employee::insert($data);
    }
}
