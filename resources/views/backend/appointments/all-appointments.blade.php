@section('title') All Appointments @endsection
@extends('backend.admin_dashboard')
@section('content')

<div class="content">
    
    <!-- Start Content-->
    <div class="container-fluid">
        
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Appointment Management</h4>
            </div>
            
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Appointment Management</li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Appointment Management</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="">Patient Name</label>
                                <input type="text" class="form-control" placeholder="Enter Patient Name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Patient ID</label>
                                <input type="text" class="form-control" placeholder="Enter Patient ID">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Booked On From</label>
                                <input type="date" class="form-control" placeholder="Select Date From">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Booked on To</label>
                                <input type="date" class="form-control" placeholder="Select Date To">
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="text-center col-md-12 mb-3">
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
                        <h5 class="card-title mb-0">All Appointments</h5>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#bookAppointmentPatient" class="btn btn-success">Book New Appointment</button>
                    </div><!-- end card header -->
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Actions </th>
                                        <th>Patient Name</th>
                                        <th>Patient Age</th>
                                        <th>Appointment Schedule</th>
                                        <th>Appointment Type</th>
                                        <th style="text-align: center;">Has Paid</th>
                                        <th style="text-align: center;">Has Recorded Vitals</th>
                                        <th style="text-align: center;">Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                    @php 
                                    $patient = $appointment->patient;
                                    $age = \Carbon\Carbon::parse($patient->date_of_birth)->age;
                                    $hasPaid = $appointment->has_paid ? 'Yes' : 'No';
                                    $hasRecordedVitals = $appointment->has_recorded_vitals ? 'Yes' : 'No';
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            {{-- button group --}}
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#rescheduleAppointment{{ $appointment->id }}" class="btn btn-sm btn-primary">Reshedule Appointment</button>
                                                <a href="{{ route('vitals.patient', [$appointment->id, $appointment->patient->id]) }}" class="btn btn-sm btn-success">Record Vitals</a>
                                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE') 
                                                    
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </th>
                                        <td>{{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}</td>
                                        <td>{{ $age }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') . ' :: ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                        <td>{{ $appointment->appointment_type }}</td>
                                        <td style="text-align: center;">
                                            @if ($hasPaid == 'Yes')
                                            <i class="fa-solid fa-circle-check" style="color: #18c324;"></i>
                                            @else
                                            <i class="fa-solid fa-circle-xmark" style="color: #c45f5f;"></i>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if ($hasRecordedVitals == 'Yes')
                                            <i class="fa-solid fa-circle-check" style="color: #18c324;"></i>
                                            @else
                                            <i class="fa-solid fa-circle-xmark" style="color: #c45f5f;"></i>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if ($appointment->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                            @elseif ($appointment->status == 'checked_in')
                                            <span class="badge bg-info">Checked In</span>
                                            @elseif ($appointment->status == 'in_consultation')
                                            <span class="badge bg-info">In Consultaiton</span>
                                            @elseif ($appointment->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @else
                                            <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $appointment->created_at }}</td>
                                    </tr>
                                    
                                    
                                    {{-- reschedule appointment --}}
                                    <div class="modal fade" data-bs-backdrop="static" id="rescheduleAppointment{{ $appointment->id }}" tabindex="-1" aria-labelledby="rescheduleAppointmentLabel">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rescheduleAppointmentLabel">Reschedule Patient's Appointment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('appointments.reschedule', $appointment->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <h5>Patient Details</h5>
                                                        <div class="row g-3">
                                                            <!-- First Name -->
                                                            <div class="col-xxl-12 mb-3">
                                                                <label for="firstName" class="form-label">Patient <span class="text-danger">*</span></label>
                                                                <select disabled name="" id="" class="form-control">
                                                                    <option value="" selected disabled>Select a Patient</option>
                                                                    @foreach($patients as $patient)
                                                                    <option {{ $appointment->patient_id == $patient->id ? 'selected' : '' }} value="{{ $patient->id }}">{{ $patient->first_name . ' ' . $patient->last_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div><!--end col-->
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-xxl-6 mb-3">
                                                                <label for="email" class="form-label">Appointment Date<span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" required name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" id="appointment_date">
                                                            </div>
                                                            <div class="col-xxl-6 mb-3">
                                                                <label for="email" class="form-label">Appointment Time<span class="text-danger">*</span></label>
                                                                <input type="time" class="form-control" required name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" id="appointment_time">
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        <!-- Submit Button -->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-warning">Complete Rescheduling</button>
                                                            </div>
                                                        </div><!-- end col -->
                                                    </form>
                                                </div> <!-- end modal body -->
                                            </div> <!-- end modal content -->
                                        </div>
                                    </div>
                                    {{-- end: reschedule appointment --}}
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        
        {{-- book appointment --}}
        <div class="modal fade" data-bs-backdrop="static" id="bookAppointmentPatient" tabindex="-1" aria-labelledby="bookAppointmentPatientLabel">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookAppointmentPatientLabel">Book Appointment for a Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('appointments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5>Patient Details</h5>
                            <div class="row g-3">
                                <!-- First Name -->
                                <div class="col-xxl-12 mb-3">
                                    <label for="firstName" class="form-label">Patient <span class="text-danger">*</span></label>
                                    <select name="" id="" class="form-control">
                                        <option value="" selected disabled>Select a Patient</option>
                                        @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->first_name . ' ' . $patient->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div><!--end col-->
                            </div>
                            
                            <hr>
                            <h5>Appointment Details</h5>
                            <div class="row">
                                <div class="col-xxl-6 mb-3">
                                    <label for="email" class="form-label">Appointment Type <span class="text-danger">*</span></label>
                                    <select name="appointment_type" id="appointment_type" class="form-select">
                                        <option selected value="consultation">Consultation</option>
                                        <option value="follow-up">Follow Up</option>
                                        <option value="emergency">Emergency</option>
                                        <option value="admission">Admission</option>
                                        <option value="test">Test</option>
                                    </select>
                                </div>
                                <div class="col-xxl-6 mb-3">
                                    <label for="email" class="form-label">Doctor</label>
                                    <select name="doctor_id" id="doctor_id" class="form-select">
                                        <option selected value="" disabled>Select a Doctor</option>
                                        @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->first_name . ' ' . $doctor->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xxl-6 mb-3">
                                    <label for="email" class="form-label">Appointment Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" required name="appointment_date" id="appointment_date">
                                </div>
                                <div class="col-xxl-6 mb-3">
                                    <label for="email" class="form-label">Appointment Time<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" required name="appointment_time" id="appointment_time">
                                </div>
                            </div>
                            
                            <hr>
                            <h6>Extra Details (can be left empty)</h6>
                            <div class="row">
                                <div class="col-xxl-12 mb-3">
                                    <label for="email" class="form-label">Reason for this Appointment</label>
                                    <textarea name="reason" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xxl-12 mb-3">
                                    <label for="email" class="form-label">Notes</label>
                                    <textarea name="notes" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            
                            
                            <!-- Submit Button -->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Book Appointment</button>
                                    <button type="submit" class="btn btn-primary">Book & Continue to Vital Recording</button>
                                </div>
                            </div><!-- end col -->
                        </form>
                    </div> <!-- end modal body -->
                </div> <!-- end modal content -->
            </div>
        </div>
        {{-- end: book appointment --}}
        
        
        
    </div> <!-- container-fluid -->
    
</div>

<script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("appointment_date").setAttribute('min', today);
</script>
@endsection
