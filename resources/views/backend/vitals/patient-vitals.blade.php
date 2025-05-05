@section('title') Patient's Vitals @endsection
@extends('backend.admin_dashboard')
@section('content')



<div class="content">
    
    <!-- Start Content-->
    <div class="container-fluid">
        
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Patient Vitals for: <strong>{{ $patient->first_name }}</strong></h4>
            </div>
            
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patient Vitals</li>
                </ol>
            </div>
        </div>
        
        
        <div class="row">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Striped Rows -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Vitals Record Management</h5>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#recordVital" class="btn btn-success">New</button>
                    </div><!-- end card header -->
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">date/time</th>
                                        <th style="text-align: center;">cm</th>
                                        <th style="text-align: center;">kg</th>
                                        <th style="text-align: center;">systolic/diastolic</th>
                                        <th style="text-align: center;">°C</th>
                                        <th style="text-align: center;">bpm</th>
                                        <th style="text-align: center;">breaths/min</th>
                                        <th style="text-align: center;">%</th>
                                        <th style="text-align: center;">kg/m²</th>
                                        <th style="text-align: center;"></th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="table-info">
                                        <th style="text-align: center;">Recorded At</th>
                                        <th style="text-align: center;">Height</th>
                                        <th style="text-align: center;">Weight</th>
                                        <th style="text-align: center;">Blood Pressure</th>
                                        <th style="text-align: center;">Temperature</th>
                                        <th style="text-align: center;">Pulse/Heart Rate</th>
                                        <th style="text-align: center;">Respiratory Rate</th>
                                        <th style="text-align: center;">Oxygen Saturation</th>
                                        <th style="text-align: center;">BMI</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vitals as $vital)
                                    <tr>
                                        <td><span class="badge bg-dark">{{ $vital->created_at->format('d-m-Y H:i:s') }}</span></td>
                                        <td>{{ $vital->height }}</td>
                                        <td>{{ $vital->weight }}</td>
                                        <td>{{ $vital->blood_pressure }}</td>
                                        <td>{{ $vital->temperature }}</td>
                                        <td>{{ $vital->heart_rate }}</td>
                                        <td>{{ $vital->respiratory_rate ?? '' }}</td>
                                        <td>{{ $vital->oxygen_saturation ?? '' }}</td>
                                        <td>{{ $vital->bmi ?? '' }}</td>
                                        <th scope="row">
                                            {{-- button group --}}
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" data-bs-toggle="modal"  class="btn btn-sm btn-primary">Reshedule Appointment</button>
                                                <form action="{{ route('destroy.vitals.patient', $vital->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE') 
                                                    
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </th>
                                    </tr>
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        
        {{-- reschedule appointment --}}
        <div class="modal fade" data-bs-backdrop="static" id="recordVital" tabindex="-1" aria-labelledby="recordVitalLabel">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recordVitalLabel">Reschedule Patient's Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('store.vitals.patient') }}" method="POST" id="vitalForm">
                            @csrf
                            <div class="row g-3 mb-3">
                                <!-- Height -->
                                <div class="col-md-4">
                                    <label for="height" class="form-label">Height</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="height" name="height" min="0" step="0.1" required>
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                                
                                <!-- Weight -->
                                <div class="col-md-4">
                                    <label for="weight" class="form-label">Weight</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="weight" name="weight" min="0" step="0.1" required>
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <!-- Blood Pressure -->
                                <div class="col-md-4">
                                    <label for="bloodPressure" class="form-label">Blood Pressure <span class="text-warning">(mandatory)</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="bloodPressure" name="blood_pressure" placeholder="e.g., 120/80" required>
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                </div>
                                
                                <!-- Temperature -->
                                <div class="col-md-4">
                                    <label for="temperature" class="form-label">Temperature <span class="text-warning">(mandatory)</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="temperature" name="temperature" min="30" max="45" step="0.1" required>
                                        <span class="input-group-text">°C</span>
                                    </div>
                                </div>
                                
                                <!-- Pulse / Heart Rate -->
                                <div class="col-md-4">
                                    <label for="pulse" class="form-label">Pulse / Heart Rate <span class="text-warning">(mandatory)</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="heart_rate" name="heart_rate" min="30" max="200" required>
                                        <span class="input-group-text">bpm</span>
                                    </div>
                                </div>
                                
                                <!-- Respiratory Rate -->
                                <div class="col-md-4">
                                    <label for="respiratoryRate" class="form-label">Respiratory Rate</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="respiratoryRate" name="respiratory_rate" min="5" max="60" required>
                                        <span class="input-group-text">breaths/min</span>
                                    </div>
                                </div>
                                
                                <!-- Oxygen Saturation -->
                                <div class="col-md-4">
                                    <label for="oxygenSaturation" class="form-label">Oxygen Saturation</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="oxygenSaturation" name="oxygen_saturation" min="50" max="100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                
                                <!-- BMI -->
                                <div class="col-md-4">
                                    <label for="bmi" class="form-label">BMI</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="bmi" name="bmi" min="10" max="60" step="0.1" readonly>
                                        <span class="input-group-text">kg/m²</span>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <!-- Actions -->
                            <div class="col-lg-12">
                                <input type="hidden" name="patient_id" value="{{ $patient->id ?? '' }}">
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id ?? '' }}">
                                <input type="hidden" name="nurse_id" value="{{ nurse_id() }}">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Vitals</button>
                                </div>
                            </div><!-- end col -->
                        </form>
                    </div> <!-- end modal body -->
                </div> <!-- end modal content -->
            </div>
        </div>
        {{-- end: reschedule appointment --}}
        
        
    </div>
</div>







@endsection