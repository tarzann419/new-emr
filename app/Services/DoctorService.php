<?php

namespace App\Services; 

use App\Models\Doctor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DoctorService {
    public function getAllDoctors()
    {
        return Doctor::where('tenant_id', tenant_id())->latest()->get();
    }

    public function getDoctorById($id)
    {   
        return Doctor::find($id);
    }   

    public function createDoctor(array $data, $role)
    {
        return Doctor::create([
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
    
    public function updateDoctor($id, array $data)
    {
        $doctor = Doctor::find($id);

        // Check if the doctor exists
        if (!$doctor) {
            return null; 
        }

        $doctor->update($data);
        return $doctor;
    }

    public function deleteDoctor($id)
    {
        $doctor = Doctor::find($id);

        // Check if the doctor exists
        if (!$doctor) {
            return null; 
        }

        return $doctor->delete();
    }
}