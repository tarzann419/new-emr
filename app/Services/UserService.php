<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function createUser(array $data, $role)
    {
        return User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $role, 
            'username' => Str::slug($data['first_name'] . '.' . Str::random(4)),
            'phone' => $data['phone'] ?? null,
            'user_id' => Str::uuid(),
            'tenant_id' => $data['tenant_id'] ?? 'default_tenant',
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
    }

    public function updateUser($id, array $data)
    {
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return null; 
        }

        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return null; 
        }

        return $user->delete();
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getUserByRole($role)
    {
        return User::where('role', $role)->get();
    }
}