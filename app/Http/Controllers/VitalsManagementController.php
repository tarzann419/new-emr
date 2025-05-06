<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVitalRequest;
use App\Http\Requests\UpdateVitalRequest;
use App\Services\AppointmentService;
use App\Services\PatientService;
use App\Services\VitalsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VitalsManagementController extends Controller
{
    public $vitalService;
    public $appointmentService;
    public $patientService;
    public function __construct(VitalsService $vitalService, AppointmentService $appointmentService, PatientService $patientService)
    {
        $this->vitalService = $vitalService;
        $this->appointmentService = $appointmentService;
        $this->patientService = $patientService;
    }

    /**
     * Display a listing of the resource.
     */
    public function patientVitals($appointmentId, $patientId)
    {
        // Fetch all vitals for the patient
        $vitals = $this->vitalService->getPatientVitals($patientId);
        $patient = $this->patientService->getPatientById($patientId);
        $appointment = $this->appointmentService->getAppointmentById($appointmentId);

        // Return the view with the vitals data
        return view('backend.vitals.patient-vitals', compact('vitals', 'patient', 'appointment'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function recordPatientVital($appointmentId, $patientId)
    {
        // Fetch the patient details
        $patient = $this->vitalService->getPatientVitalById($patientId, $appointmentId);

        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        // Show the form to record a new vital
        return view('backend.vitals.record-vital', compact('patient'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'nurse_id' => 'nullable|exists:users,id',
            'appointment_id' => 'nullable|exists:appointments,id',

            'temperature' => 'nullable|numeric',
            'temperature_unit' => 'nullable|string',

            'blood_pressure' => 'nullable|string',
            'blood_pressure_unit' => 'nullable|string',

            'heart_rate' => 'nullable|integer',
            'heart_rate_unit' => 'nullable|string',

            'respiratory_rate' => 'nullable|integer',
            'respiratory_rate_unit' => 'nullable|string',

            'oxygen_saturation' => 'nullable|integer',
            'oxygen_saturation_unit' => 'nullable|string',

            'height' => 'nullable|numeric',
            'height_unit' => 'nullable|string',

            'weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|string',

            'bmi' => 'nullable|numeric',
            'bmi_unit' => 'nullable|string',

            'blood_sugar' => 'nullable|numeric',
            'blood_sugar_unit' => 'nullable|string',

            'pain_score' => 'nullable|integer|min:0|max:10',
            'notes' => 'nullable|string',

            'patient_id' => 'required|exists:patients,id',
        ]);

        if ($validator->fails()) {
            flash()->error('Validation failed. Please check your input.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the patient exists
        $patient = $this->patientService->getPatientById($request->input('patient_id'));

        if (!$patient) {
            flash()->error('Patient not found.');
            return redirect()->back();
        }
        // Check if the appointment exists
        $appointment = $this->appointmentService->getAppointmentById($request->input('appointment_id'));
        if (!$appointment) {
            flash()->error('Appointment not found.');
            return redirect()->back();
        }

        // pass tenant_id to the request
        $request->merge(['tenant_id' => tenant_id()]);

        $vital = $this->vitalService->createVital($request->all());


        if ($vital) {
            flash()->success('Vital recorded successfully.');
            return redirect()->route('vitals.patient', ['appointmentId' => $request->input('appointment_id'), 'patientId' => $request->input('patient_id')]);
        } else {
            flash()->error('Failed to record vital. Please try again.');
            return redirect()->back();
        }
    }

    public function update(UpdateVitalRequest $request, $id)
    {
        $vital = $this->vitalService->updateVital($id, $request->validated());

        if ($vital) {
            flash()->success('Vital updated successfully.');
            return redirect()->back();
        } else {
            flash()->error('Failed to update vital. Please try again.');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $vital = $this->vitalService->deleteVital($id);

        if ($vital) {
            flash()->success('Vital deleted successfully.');
            return redirect()->back();
        } else {
            flash()->error('Failed to delete vital. Please try again.');
            return redirect()->back();
        }
    }
}
