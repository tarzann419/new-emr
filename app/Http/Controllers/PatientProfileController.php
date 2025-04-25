<?php

namespace App\Http\Controllers;

use App\Services\DoctorService;
use App\Services\PatientService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientProfileController extends Controller
{
    public $userService;
    public $patientService;
    public $doctorService;

    public function __construct(UserService $userService, PatientService $patientService, DoctorService $doctorService)
    {
        $this->userService = $userService;
        $this->patientService = $patientService;
        $this->doctorService = $doctorService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = $this->patientService->getAllPatients();
        $tenant_id = tenant_id();
        $doctors = $this->doctorService->getAllDoctors();
        return view('backend.patients.index', compact('patients', 'tenant_id', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenant_id = tenant_id();
        return view('backend.patients.create', compact('tenant_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // User-specific fields
            'email' => 'required|string|email|max:255|unique:users,email',

            // Patient profile fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
            'address' => 'nullable|string|max:255',
            'state_of_origin' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'genotype' => 'nullable|in:AA,AS,SS,AC,SC',
            'next_of_kin' => 'nullable|string|max:255',
            'next_of_kin_phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'medical_conditions' => 'nullable|string',
            'tenant_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            flash()->error('Validation failed. Please check your input.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $this->userService->createUser($request->all(), 11);
        // give user patient role
        $user->assignRole('patient');
        // create patient profile
        $patient = $this->patientService->createPatient($request->all(), $user->id);

        if ($patient) {
            flash()->success('Patient created successfully.');
            return redirect()->back()->with('success', 'Patient created successfully.');
        } else {
            flash()->error('Failed to create patient.');
            return redirect()->back()->with('error', 'Failed to create patient.');
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
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            // User-specific fields 
            // 'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id',

            // Patient profile fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
            'address' => 'nullable|string|max:255',
            'state_of_origin' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'genotype' => 'nullable|in:AA,AS,SS,AC,SC',
            'next_of_kin' => 'nullable|string|max:255',
            'next_of_kin_phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'medical_conditions' => 'nullable|string',
            'tenant_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $patient = $this->patientService->updatePatient($id, $request->all());

        $user = $this->userService->updateUser($id, $request->all());

        if ($patient) {
            flash()->success('Patient updated successfully.');
            return redirect()->back()->with('success', 'Patient updated successfully.');
        } else {
            flash()->error('Failed to update patient.');
            return redirect()->back()->with('error', 'Failed to update patient.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = $this->patientService->deletePatient($id);
        $user = $this->userService->deleteUser($id);

        if ($patient) {
            flash()->success('Patient deleted successfully.');
            return redirect()->back()->with('success', 'Patient deleted successfully.');
        } else {
            flash()->error('Failed to delete patient.');
            return redirect()->back()->with('error', 'Failed to delete patient.');
        }
    }
}
