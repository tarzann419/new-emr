<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'doctor'],
            ['name' => 'nurse'],
            ['name' => 'receptionist'],
            ['name' => 'accountant'],
            ['name' => 'pharmacist'],
            ['name' => 'lab_technician'],
            ['name' => 'radiologist'],
            ['name' => 'supervisor'],
            ['name' => 'super_admin'],
        ]);
    }
}
