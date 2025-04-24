<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            
            <div class="logo-box">
                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>
            
            <ul id="side-menu">
                @role('admin')
                @include('backend.partials.sidebar.admin')
                @endrole

                @role('nurse')
                @include('backend.partials.sidebar.nurse')
                @endrole


                @role('doctor')
                @include('backend.partials.sidebar.doctor')
                @endrole
                
            </ul>
            
        </div>
        <!-- End Sidebar -->
        
        <div class="clearfix"></div>
        
    </div>
</div>