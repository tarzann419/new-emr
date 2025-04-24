<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('roles')->insert([
        //     ['name' => 'admin'],
        //     ['name' => 'doctor'],
        //     ['name' => 'nurse'],
        //     ['name' => 'receptionist'],
        //     ['name' => 'accountant'],
        //     ['name' => 'pharmacist'],
        //     ['name' => 'lab_technician'],
        //     ['name' => 'radiologist'],
        //     ['name' => 'supervisor'],
        //     ['name' => 'super_admin'],
        // ]);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'doctor']);
        Role::create(['name' => 'nurse']);
        Role::create(['name' => 'receptionist']);
        Role::create(['name' => 'accountant']);
        Role::create(['name' => 'pharmacist']);
        Role::create(['name' => 'lab_technician']); 
        Role::create(['name' => 'radiologist']);
        Role::create(['name' => 'supervisor']);
        Role::create(['name' => 'super_admin']);
    }
}
