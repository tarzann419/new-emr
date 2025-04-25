<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="utf-8" />
    <title>EMR System | @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured EMR system"/>
    <meta name="author" content="Dan"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    
    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    
    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    
    <script src="{{ asset('assets/js/head.js') }}"></script>
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    
    {{-- select2 --}}
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <style>
        .select2-container .select2-selection--single {
            height: 38px !important; /* Match Bootstrap's default input height */
            border: 1px solid #ced4da !important; /* Match form-control border */
            border-radius: 4px !important; /* Match Bootstrap */
            padding: 6px 12px !important; /* Adjust padding */
        }
        
        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
        }
        
        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 36px !important; /* Match input height */
        }
    </style>
    
    
    
    
</head>

<!-- body start -->
<body data-menu-color="light" data-sidebar="default">
    
    <!-- Begin page -->
    <div id="app-layout">
        
        <!-- Topbar Start -->
        @include('backend.partials.header')
        <!-- end Topbar -->
        
        <!-- Left Sidebar Start -->
        @include('backend.partials.sidebar')
        <!-- Left Sidebar End -->
        
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        
        <div class="content-page">
            {{-- content --}}
            @yield('content')
            <!-- content -->
            
            <!-- Footer Start -->
            @include('backend.partials.footer')
            <!-- end Footer -->
            
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
        
    </div>
    <!-- END wrapper -->
    
    
    
    <!-- Vendor -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    
    <!-- Apexcharts JS -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    
    <!-- Widgets Init Js -->
    <script src="{{ asset('assets/js/pages/crm-dashboard.init.js') }}"></script>
    
    <!-- App js-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Your custom script -->
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    
</body>

</html>