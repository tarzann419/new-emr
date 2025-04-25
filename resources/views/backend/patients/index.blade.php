@section('title') All Patients @endsection
@extends('backend.admin_dashboard')
@section('content')

<div class="content">
    
    <!-- Start Content-->
    <div class="container-fluid">
        
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Patient Management</h4>
            </div>
            
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patient Management</li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Patient Registration</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Search by name or ID">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="row">
            
            <!-- Striped Rows -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">All Patients</h5>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#newPatient" class="btn btn-primary">Register New Patient</button>
                    </div><!-- end card header -->
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Actions </th>
                                        <th>Patient Name</th>
                                        <th>Phone Number</th>
                                        <th>Gender</th>
                                        <th>Date of Birth</th>
                                        <th>Patient ID No.</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $patient)
                                    <tr>
                                        <th scope="row">
                                            {{-- button group --}}
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#updatePatient{{ $patient->id }}" class="btn btn-sm btn-primary">Edit</button>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#bookAppointmentPatient{{ $patient->id }}" class="btn btn-sm btn-warning">Book Appointment</button>
                                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE') 
                                                    
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </th>
                                        <td>{{ $patient->first_name . ' ' . $patient->last_name }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->gender }}</td>
                                        <td>{{ $patient->date_of_birth }}</td>
                                        <td>{{ $patient->patient_id }}</td>
                                        <td>{{ $patient->created_at }}</td>
                                    </tr>
                                    
                                    {{-- edit patient --}}
                                    <div class="modal fade" data-bs-backdrop="static" id="updatePatient{{ $patient->id }}" tabindex="-1" aria-labelledby="updatePatientLabel">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updatePatientLabel">Update a Patient's Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <h5>Personal Details</h5>
                                                        <div class="row g-3">
                                                            <!-- First Name -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" required name="first_name" id="first_name" placeholder="e.g., John" value="{{ old('first_name', $patient->first_name ?? '') }}">
                                                            </div><!--end col-->
                                                            
                                                            <!-- Middle Name -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="middleName" class="form-label">Middle Name </label>
                                                                <input type="text" class="form-control" required name="middle_name" id="middle_name" placeholder="e.g., Jane" value="{{ old('middle_name', $patient->middle_name ?? '') }}">
                                                            </div><!--end col-->
                                                            
                                                            <!-- Last Name -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" required name="last_name" id="last_name" placeholder="e.g., Doe" value="{{ old('last_name', $patient->last_name ?? '') }}">
                                                            </div><!--end col-->
                                                        </div>
                                                        
                                                        <div class="row g-3">
                                                            <!-- Gender -->
                                                            <div class="col-xxl-4 mb-4">
                                                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                                                <select class="form-select" name="gender" id="gender" required>
                                                                    <option value="" disabled>Select a Gender</option>
                                                                    <option value="male" {{ old('gender', $patient->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                                                    <option value="other" {{ old('gender', $patient->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <!-- Date of Birth -->
                                                            <div class="col-xxl-4 mb-4">
                                                                <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" required value="{{ old('date_of_birth', $patient->date_of_birth ?? '') }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row g-3">
                                                            <!-- Phone -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="phone" class="form-label">Phone</label>
                                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="e.g., 123-456-7890" value="{{ old('phone', $patient->phone ?? '') }}">
                                                            </div>
                                                            
                                                            <!-- email -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                                <input type="email" class="form-control" required name="email" id="email" placeholder="e.g., example@example.com" value="{{ old('email', $patient->email ?? '') }}">
                                                            </div>
                                                            
                                                            <!-- Marital Status -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="marital_status" class="form-label">Marital Status</label>
                                                                <select name="marital_status" id="marital_status" class="form-select">
                                                                    <option value="" disabled>Select a Marital Status</option>
                                                                    <option value="married" {{ old('marital_status', $patient->marital_status ?? '') == 'married' ? 'selected' : '' }}>Married</option>
                                                                    <option value="single" {{ old('marital_status', $patient->marital_status ?? '') == 'single' ? 'selected' : '' }}>Single</option>
                                                                    <option value="divorced" {{ old('marital_status', $patient->marital_status ?? '') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                                                    <option value="other" {{ old('marital_status', $patient->marital_status ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row g-3">
                                                            <!-- Profile Picture -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                                                <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
                                                            </div>
                                                            
                                                            <!-- Address -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="address" class="form-label">Address</label>
                                                                <input type="text" class="form-control" name="address" id="address" placeholder="e.g., 123 Main St" value="{{ old('address', $patient->address ?? '') }}">
                                                            </div>
                                                            
                                                            <!-- State of Origin -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="state_of_origin" class="form-label">State of Origin</label>
                                                                <input type="text" class="form-control" name="state_of_origin" id="state_of_origin" placeholder="e.g., Lagos" value="{{ old('state_of_origin', $patient->state_of_origin ?? '') }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row g-3">
                                                            <!-- Nationality -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="nationality" class="form-label">Nationality</label>
                                                                <input type="text" class="form-control" name="nationality" id="nationality" placeholder="e.g., Nigerian" value="{{ old('nationality', $patient->nationality ?? '') }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <hr>
                                                        <h5>Medical Details</h5>
                                                        
                                                        <div class="row">
                                                            <!-- Genotype -->
                                                            <div class="col-xxl-6 mb-3">
                                                                <label for="genotype" class="form-label">Genotype <span class="text-danger">*</span></label>
                                                                <select required class="form-control" name="genotype" id="genotype">
                                                                    <option value="AA" {{ old('genotype', $patient->genotype ?? '') == 'AA' ? 'selected' : '' }}>AA</option>
                                                                    <option value="AS" {{ old('genotype', $patient->genotype ?? '') == 'AS' ? 'selected' : '' }}>AS</option>
                                                                    <option value="SS" {{ old('genotype', $patient->genotype ?? '') == 'SS' ? 'selected' : '' }}>SS</option>
                                                                    <option value="AC" {{ old('genotype', $patient->genotype ?? '') == 'AC' ? 'selected' : '' }}>AC</option>
                                                                    <option value="SC" {{ old('genotype', $patient->genotype ?? '') == 'SC' ? 'selected' : '' }}>SC</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <!-- Blood Group -->
                                                            <div class="col-xxl-6 mb-3">
                                                                <label for="blood_group" class="form-label">Blood Group <span class="text-danger">*</span></label>
                                                                <select required class="form-control" name="blood_group" id="blood_group">
                                                                    <option value="A+" {{ old('blood_group', $patient->blood_group ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                                                                    <option value="A-" {{ old('blood_group', $patient->blood_group ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                                                    <option value="B+" {{ old('blood_group', $patient->blood_group ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                                                    <option value="B-" {{ old('blood_group', $patient->blood_group ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                                                    <option value="AB+" {{ old('blood_group', $patient->blood_group ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                                    <option value="AB-" {{ old('blood_group', $patient->blood_group ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                                    <option value="O+" {{ old('blood_group', $patient->blood_group ?? '') == 'O+' ? 'selected' : '' }}>O+</option>
                                                                    <option value="O-" {{ old('blood_group', $patient->blood_group ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <!-- Medical Conditions -->
                                                            <div class="col-xxl-12 mb-8">
                                                                <label for="medical_conditions" class="form-label">Medical Conditions</label>
                                                                <textarea class="form-control" name="medical_conditions" id="medical_conditions" placeholder="e.g., Hypertension">{{ old('medical_conditions', $patient->medical_conditions ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <hr>
                                                        <h5>Next of Kin Details</h5>
                                                        
                                                        <div class="row">
                                                            <!-- Next of Kin -->
                                                            <div class="col-xxl-6 mb-3">
                                                                <label for="next_of_kin" class="form-label">Next of Kin</label>
                                                                <input type="text" class="form-control" name="next_of_kin" id="next_of_kin" placeholder="e.g., Jane Doe" value="{{ old('next_of_kin', $patient->next_of_kin ?? '') }}">
                                                            </div>
                                                            
                                                            <!-- Next of Kin Phone -->
                                                            <div class="col-xxl-6 mb-3">
                                                                <label for="next_of_kin_phone" class="form-label">Next of Kin Phone</label>
                                                                <input type="text" class="form-control" name="next_of_kin_phone" id="next_of_kin_phone" placeholder="e.g., 987-654-3210" value="{{ old('next_of_kin_phone', $patient->next_of_kin_phone ?? '') }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row g-3">
                                                            <!-- Occupation -->
                                                            <div class="col-xxl-4 mb-4">
                                                                <label for="occupation" class="form-label">Occupation</label>
                                                                <input type="text" class="form-control" name="occupation" id="occupation" placeholder="e.g., Teacher" value="{{ old('occupation', $patient->occupation ?? '') }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Submit Button -->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <input type="hidden" value="{{ $tenant_id }}" class="form-control" required name="tenant_id" id="tenant_id">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div><!-- end col -->
                                                    </form>
                                                </div> <!-- end modal body -->
                                            </div> <!-- end modal content -->
                                        </div>
                                    </div>
                                    {{-- end: edit patient --}}
                                    
                                    
                                    {{-- bookAppointment --}}
                                    <div class="modal fade" data-bs-backdrop="static" id="updatePatient{{ $patient->id }}" tabindex="-1" aria-labelledby="updatePatientLabel">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updatePatientLabel">Update a Patient's Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <h5>Personal Details</h5>
                                                        <div class="row g-3">
                                                            <!-- First Name -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" required name="first_name" id="first_name" placeholder="e.g., John" value="{{ old('first_name', $patient->first_name ?? '') }}">
                                                            </div><!--end col-->
                                                            
                                                            <!-- Middle Name -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="middleName" class="form-label">Middle Name </label>
                                                                <input type="text" class="form-control" required name="middle_name" id="middle_name" placeholder="e.g., Jane" value="{{ old('middle_name', $patient->middle_name ?? '') }}">
                                                            </div><!--end col-->
                                                            
                                                            <!-- Last Name -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" required name="last_name" id="last_name" placeholder="e.g., Doe" value="{{ old('last_name', $patient->last_name ?? '') }}">
                                                            </div><!--end col-->
                                                        </div>
                                                        
                                                        <div class="row g-3">
                                                            <!-- Phone -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="phone" class="form-label">Phone</label>
                                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="e.g., 123-456-7890" value="{{ old('phone', $patient->phone ?? '') }}">
                                                            </div>
                                                            
                                                            <!-- email -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                                <input type="email" class="form-control" required name="email" id="email" placeholder="e.g., example@example.com" value="{{ old('email', $patient->email ?? '') }}">
                                                            </div>
                                                            
                                                            <!-- Marital Status -->
                                                            <div class="col-xxl-4 mb-3">
                                                                <label for="marital_status" class="form-label">Marital Status</label>
                                                                <select name="marital_status" id="marital_status" class="form-select">
                                                                    <option value="" disabled>Select a Marital Status</option>
                                                                    <option value="married" {{ old('marital_status', $patient->marital_status ?? '') == 'married' ? 'selected' : '' }}>Married</option>
                                                                    <option value="single" {{ old('marital_status', $patient->marital_status ?? '') == 'single' ? 'selected' : '' }}>Single</option>
                                                                    <option value="divorced" {{ old('marital_status', $patient->marital_status ?? '') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                                                    <option value="other" {{ old('marital_status', $patient->marital_status ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <hr>
                                                        <h5>Appointment Details</h5>
                                                        <div class="col-xxl-6 mb-3">
                                                            <label for="email" class="form-label">Appointment Date<span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" required name="appointment_date" id="appointment_date">
                                                        </div>
                                                        <div class="col-xxl-6 mb-3">
                                                            <label for="email" class="form-label">Appointment Time<span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" required name="appointment_time" id="appointment_time">
                                                        </div>
                                                        
                                                        
                                                        <!-- Submit Button -->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <input type="hidden" value="{{ $tenant_id }}" class="form-control" required name="tenant_id" id="tenant_id">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div><!-- end col -->
                                                    </form>
                                                </div> <!-- end modal body -->
                                            </div> <!-- end modal content -->
                                        </div>
                                    </div>
                                    {{-- end: bookAppointment --}}
                                    
                                    
                                    
                                    
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        
        
        <div class="modal fade" data-bs-backdrop="static" id="newPatient" tabindex="-1" aria-labelledby="newPatientLabel">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newPatientLabel">Register a New Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5>Personal Details</h5>
                            <div class="row g-3">
                                <!-- First Name -->
                                <div class="col-xxl-4 mb-3">
                                    <div>
                                        <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="first_name" id="first_name" placeholder="e.g., John">
                                    </div>
                                </div><!--end col-->
                                
                                <!-- Last Name -->
                                <div class="col-xxl-4 mb-3">
                                    <div>
                                        <label for="middleName" class="form-label">Middle Name </label>
                                        <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="e.g., Jane">
                                    </div>
                                </div><!--end col-->
                                
                                <!-- Last Name -->
                                <div class="col-xxl-4 mb-3">
                                    <div>
                                        <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="last_name" id="last_name" placeholder="e.g., Doe">
                                    </div>
                                </div><!--end col-->
                            </div>
                            
                            <div class="row g-3">
                                <!-- Gender -->
                                <div class="col-xxl-4 mb-4">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" name="gender" id="gender" required>
                                        <option value="" selected disabled>Select a Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <!-- Date of Birth -->
                                <div class="col-xxl-4 mb-4">
                                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" required>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Phone -->
                                <div class="col-xxl-4 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="e.g., 123-456-7890">
                                </div>
                                
                                <!-- email -->
                                <div class="col-xxl-4 mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" required name="email" id="email" placeholder="e.g., 123-456-7890">
                                </div>
                                
                                <!-- Marital Status -->
                                <div class="col-xxl-4 mb-3">
                                    <label for="marital_status" class="form-label">Marital Status</label>
                                    <select name="marital_status" id="marital_status" class="form-select">
                                        <option value="" selected disabled>Select a Marital Status</option>
                                        <option value="married">Married</option>
                                        <option value="single">Single</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Profile Picture -->
                                <div class="col-xxl-4 mb-3">
                                    <label for="profile_picture" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
                                </div>
                                
                                <!-- Address -->
                                <div class="col-xxl-4 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="e.g., 123 Main St">
                                </div>
                                
                                <!-- State of Origin -->
                                <div class="col-xxl-4 mb-3">
                                    <label for="state_of_origin" class="form-label">State of Origin</label>
                                    <input type="text" class="form-control" name="state_of_origin" id="state_of_origin" placeholder="e.g., Lagos">
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Nationality -->
                                <div class="col-xxl-4 mb-3">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" class="form-control" name="nationality" id="nationality" placeholder="e.g., Nigerian">
                                </div>
                            </div>
                            
                            <hr>
                            <h5>Medical Details</h5>
                            
                            <div class="row">
                                <!-- Genotype -->
                                <div class="col-xxl-6 mb-3">
                                    <label for="genotype" class="form-label">Genotype <span class="text-danger">*</span></label>
                                    <select required class="form-control" name="genotype" id="genotype">
                                        <option value="AA">AA</option>
                                        <option value="AS">AS</option>
                                        <option value="SS">SS</option>
                                        <option value="AC">AC</option>
                                        <option value="SC">SC</option>
                                    </select>
                                </div>
                                
                                
                                <!-- Blood Group -->
                                <div class="col-xxl-6 mb-3">
                                    <label for="blood_group" class="form-label">Blood Group <span class="text-danger">*</span></label>
                                    <select required class="form-control" name="blood_group" id="blood_group">
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                                
                                <!-- Medical Conditions -->
                                <div class="col-xxl-12 mb-8">
                                    <label for="medical_conditions" class="form-label">Medical Conditions</label>
                                    <textarea class="form-control" name="medical_conditions" id="medical_conditions" placeholder="e.g., Hypertension"></textarea>
                                </div>
                            </div>
                            
                            <hr>
                            <h5>Next of Kin Details</h5>
                            
                            <div class="row">
                                <!-- Next of Kin -->
                                <div class="col-xxl-6 mb-3">
                                    <label for="next_of_kin" class="form-label">Next of Kin</label>
                                    <input type="text" class="form-control" name="next_of_kin" id="next_of_kin" placeholder="e.g., Jane Doe">
                                </div>
                                
                                <!-- Next of Kin Phone -->
                                <div class="col-xxl-6 mb-3">
                                    <label for="next_of_kin_phone" class="form-label">Next of Kin Phone</label>
                                    <input type="text" class="form-control" name="next_of_kin_phone" id="next_of_kin_phone" placeholder="e.g., 987-654-3210">
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Occupation -->
                                <div class="col-xxl-4 mb-4">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" class="form-control" name="occupation" id="occupation" placeholder="e.g., Teacher">
                                </div>
                                
                                
                                
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <!-- Tenant ID -->
                                    <input type="hidden" value="{{ $tenant_id }}" class="form-control" required name="tenant_id" id="tenant_id" placeholder="e.g., T12345">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div><!-- end col -->
                        </form> <!-- end form -->
                    </div> <!-- end modal body -->
                </div> <!-- end modal content -->
            </div>
        </div>
        
        
    </div> <!-- container-fluid -->
    
</div>

@endsection