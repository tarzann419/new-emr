<?php

namespace App\Services;

use App\Models\Vital;
use App\Models\Vitals;
use Illuminate\Support\Facades\Log;

class VitalsService
{
    public function getPatientVitals($patientId)
    {
        return Vitals::where('tenant_id', tenant_id())
            ->where('patient_id', $patientId)
            ->latest()
            ->get();
    }

    public function getPatientVitalById($patientId, $id)
    {
        return Vitals::where('tenant_id', tenant_id())
            ->where('patient_id', $patientId)
            ->find($id);
    }

    public function getAllVitals()
    {
        return Vitals::where('tenant_id', tenant_id())->latest()->get();
    }

    public function getVitalById($id)
    {
        return Vitals::find($id);
    }

    public function createVital(array $data)
    {
        try {
            return Vitals::create($data);
        } catch (\Exception $e) {
            // Log error 
            Log::error('Vital creation failed: ' . $e->getMessage());
            return false;
        }
    }

    public function updateVital($id, array $data)
    {
        $vital = Vitals::find($id);

        // Check if the vital exists
        if (!$vital) {
            return null;
        }

        $vital->update($data);
        return $vital;
    }

    public function deleteVital($id)
    {
        $vital = Vitals::find($id);

        // Check if the vital exists
        if (!$vital) {
            return null;
        }

        return $vital->delete();
    }
}
