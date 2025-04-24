<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'role_id' => 1, // Make sure this role exists in roles table
            'username' => 'admin',
            'phone' => '08012345678',
            'group_id' => null,
            'user_id' => Str::uuid(),
            'is_active' => true,
            'created_by' => null,
            'profile_picture' => null,
            'tenant_id' => '111000', // Replace with actual tenant ID
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Replace with a secure password
            'remember_token' => Str::random(10),
        ]);

        // Add another example user
        User::create([
            'name' => 'Doctor John',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'role_id' => 2, // Make sure doctor role exists
            'username' => 'drjohn',
            'phone' => '08098765432',
            'group_id' => 1,
            'user_id' => Str::uuid(),
            'is_active' => true,
            'created_by' => 1,
            'profile_picture' => null,
            'tenant_id' => '111000',
            'email' => 'john.doe@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
