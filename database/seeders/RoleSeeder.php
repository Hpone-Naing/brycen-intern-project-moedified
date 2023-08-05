<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => '1', "role_name" => "1", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', "role_name" => "2", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', "role_name" => "3", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', "role_name" => "4", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ];

        // Insert the data into the database
        Role::insert($data);
    }
}
