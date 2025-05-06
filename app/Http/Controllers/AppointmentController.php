<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Services\AppointmentService;
use App\Services\DoctorService;
use App\Services\PatientService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public $appointmentService;
    public $patientService;
    public $doctorService;

    public function __construct(AppointmentService $appointmentService, PatientService $patientService, DoctorService $doctorService)
    {
        $this->appointmentService = $appointmentService;
        $this->patientService = $patientService;
        $this->doctorService = $doctorService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all appointments
        $appointments = $this->appointmentService->getAllAppointments();
        $doctors = $this->doctorService->getAllDoctors();
        $patients = $this->patientService->getAllPatients();

        // Return the view with the appointments data
        return view('backend.appointments.all-appointments', compact('appointments', 'doctors', 'patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string|max:10',
            'appointment_type' => 'nullable|string|max:255',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check for time conflict within 30 minutes
        $appointmentDate = $request->input('appointment_date');
        $appointmentTime = $request->input('appointment_time');
        $doctorId = $request->input('doctor_id');

        if ($doctorId) {
            $appointmentDateTime = Carbon::parse("$appointmentDate $appointmentTime");

            $conflict = \App\Models\Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $appointmentDate)
                ->whereTime('appointment_time', '>=', $appointmentDateTime->copy()->subMinutes(30)->format('H:i:s'))
                ->whereTime('appointment_time', '<=', $appointmentDateTime->copy()->addMinutes(30)->format('H:i:s'))
                ->exists();

            if ($conflict) {
                return redirect()->back()
                    ->withErrors(['appointment_time' => 'There is already an appointment scheduled for this doctor around the selected time. Please choose another time.'])
                    ->withInput();
            }
        }

        // Create the appointment
        $appointment = $this->appointmentService->createAppointment([
            'patient_id' => $request->input('patient_id'),
            'doctor_id' => $request->input('doctor_id'),
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'scheduled_at' => now(),
            'appointment_type' => $request->input('appointment_type'),
            'notes' => $request->input('notes'),
            'reason' => $request->input('reason'),
            'booked_by' => username(),
            'tenant_id' => tenant_id(),
        ]);

        // if user clicks on book and continue, redirect to vitals page
        if ($request->submit_type === 'book_and_continue') {
            return redirect()->route('vitals.patient', ['appointmentId' => $appointment->id, 'patientId' => $request->patient_id])
                ->with('success', 'Appointment booked. Proceed to record vitals.');
        }

        if ($appointment) {
            flash()->success('Appointment created successfully.');
            return redirect()->route('appointments.index');
        } else {
            flash()->error('Failed to create appointment. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * This update only manages for the basic stage of appointment booking.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string|max:10',
            'appointment_type' => 'nullable|string|max:255',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the appointment
        $appointment = $this->appointmentService->updateAppointment($id, [
            'patient_id' => $request->input('patient_id'),
            'doctor_id' => $request->input('doctor_id'),
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'scheduled_at' => now(),
            'appointment_type' => $request->input('appointment_type'),
            'notes' => $request->input('notes'),
            'reason' => $request->input('reason'),
            'tenant_id' => tenant_id(),
        ]);

        if ($appointment) {
            flash()->success('Appointment updated successfully.');
            return redirect()->route('appointments.index');
        } else {
            flash()->error('Failed to update appointment. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the appointment by ID
        $appointment = $this->appointmentService->getAppointmentById($id);

        // Check if the appointment exists
        if (!$appointment) {
            flash()->error('Appointment not found.');
            return redirect()->back();
        }

        // Delete the appointment
        $deleted = $this->appointmentService->deleteAppointment($id);

        if ($deleted) {
            flash()->success('Appointment deleted successfully.');
            return redirect()->route('appointments.index');
        } else {
            flash()->error('Failed to delete appointment. Please try again.');
            return redirect()->back();
        }
    }

    public function rescheduleAppointment(Request $request, string $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the appointment by ID
        $appointment = $this->appointmentService->getAppointmentById($id);

        // Check if the appointment exists
        if (!$appointment) {
            flash()->error('Appointment not found.');
            return redirect()->back();
        }

        // Update the appointment with new date and time
        $updated = $this->appointmentService->updateAppointment($id, [
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'tenant_id' => tenant_id(),
        ]);

        if ($updated) {
            flash()->success('Appointment rescheduled successfully.');
            return redirect()->route('appointments.index');
        } else {
            flash()->error('Failed to reschedule appointment. Please try again.');
            return redirect()->back();
        }
    }


    public function getDoctorSchedule($doctorId)
    {
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->get(['appointment_date', 'appointment_time', 'reason']);

        // Convert to FullCalendar event format
        $events = $appointments->map(function ($appt) {
            return [
                'title' => $appt->reason ?? 'Booked',
                'start' => $appt->appointment_date . 'T' . $appt->appointment_time,
                'end' => \Carbon\Carbon::parse($appt->appointment_date . ' ' . $appt->appointment_time)->addMinutes(30), // default duration
                'color' => '#dc3545', // red
            ];
        });

        return response()->json($events);
    }
}
