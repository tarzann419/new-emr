<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Tenant;
use Illuminate\Support\Str;

class PatientService
{
    public function getAllPatients()
    {
        return Patient::where('tenant_id', tenant_id())->latest()->get();
    }

    public function getPatientById($id)
    {
        return Patient::find($id);
    }

    public function createPatient(array $data, $userId)
    {
        // return Patient::create($data);
        $tenant = Tenant::where('tenant_id', tenant_id())->first();
        $prefix = $tenant->prefix;
        $patientId = strtoupper($prefix) . strtoupper(Str::random(8));

        return Patient::create([
            'patient_id' => $patientId,
            'user_id' => $userId,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
            'phone' => $data['phone'] ?? null,
            'is_active' => true,
            'profile_picture' => $data['profile_picture'] ?? null,
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'state_of_origin' => $data['state_of_origin'] ?? null,
            'nationality' => $data['nationality'] ?? null,
            'marital_status' => $data['marital_status'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
            'genotype' => $data['genotype'] ?? null,
            'next_of_kin' => $data['next_of_kin'] ?? null,
            'next_of_kin_phone' => $data['next_of_kin_phone'] ?? null,
            'occupation' => $data['occupation'] ?? null,
            'medical_conditions' => $data['medical_conditions'] ?? null,
            'tenant_id' => $tenant->tenant_id,
        ]);
    }

    public function updatePatient($id, array $data)
    {
        $patient = Patient::find($id);
        $patient->update($data);
        return $patient;
    }

    public function deletePatient($id)
    {
        $patient = Patient::find($id);
        return $patient->delete();
    }
}