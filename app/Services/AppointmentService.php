<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

class AppointmentService
{
    public function getAllAppointments()
    {
        return Appointment::where('tenant_id', tenant_id())->latest()->get();
    }

    public function getAppointmentById($id)
    {
        return Appointment::find($id);
    }

    public function createAppointment(array $data)
    {
        try {
            return Appointment::create($data);
        } catch (\Exception $e) {
            // Log error 
            Log::error('Appointment creation failed: ' . $e->getMessage());
            return false;
        }
    }

    public function updateAppointment($id, array $data)
    {
        $appointment = Appointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return null;
        }

        $appointment->update($data);
        return $appointment;
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return null;
        }

        return $appointment->delete();
    }

    public function resheduleAppointment($id, array $data)
    {
        $appointment = Appointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return null;
        }

        $appointment->update($data);
        return $appointment;
    }
}
