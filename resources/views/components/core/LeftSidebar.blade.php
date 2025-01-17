<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">
    <!-- Brand Logo Light -->
    <a href="{{ route('index') }}" class="logo logo-light">
        <span class="logo-lg">
            <img style="width: 150px;height: 150px" src="{{ asset('assets/images/logo.png') }}" alt="logo" />
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="{{ route('index') }}" class="logo logo-dark">
        <span class="logo-lg">
            <img style="width: 150px;height: 150px" src="{{ asset('assets/images/logo-dark.png') }}" alt="dark logo" />
        </span>
    </a>
    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container">
        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-title">Main</li>

            <li class="side-nav-item ">
                <a href="{{ route('index') }}" class="side-nav-link">
                    <i class="ri-dashboard-2-fill"></i>
                    <span> Home </span>
                </a>
            </li>
            @role('Super_Admin')
                <li class="side-nav-item active">
                    <a href="{{ route('management') }}" class="side-nav-link">
                        <i class="ri-briefcase-fill"></i>
                        <span> Management </span>
                    </a>
                </li>
            @endrole
            <li class="side-nav-item active">
                <a href="{{ route('batch') }}" class="side-nav-link">
                    <i class="ri-user-star-fill"></i>
                    <span> Batch </span>
                </a>
            </li>
            <li class="side-nav-item active">
                <a href="{{ route('classes') }}" class="side-nav-link">
                    <i class="ri-file-list-3-fill"></i>
                    <span> Classes </span>
                </a>
            </li>
            <li class="side-nav-item active">
                <a href="{{ route('class-schedule') }}" class="side-nav-link">
                    <i class="ri-file-list-3-fill"></i>
                    <span> Class Schedule </span>
                </a>
            </li>
            <li class="side-nav-item active">
                <a href="{{ route('students') }}" class="side-nav-link">
                    <i class="ri-user-2-fill"></i>
                    <span> Students </span>
                </a>
            </li>
            <li class="side-nav-item active">
                <a href="{{ route('schools') }}" class="side-nav-link">
                    <i class="ri-briefcase-fill"></i>
                    <span> schools </span>
                </a>
            </li>
            <li class="side-nav-item active">
                <a href="{{ route('payments') }}" class="side-nav-link">
                    <i class="ri-money-cny-box-fill"></i>
                    <span> Payments </span>
                </a>
            </li>

            @role('Super_Admin')
                <li class="side-nav-title">Reports</li>

                <li class="side-nav-item">
                    <a href="{{ route('studentReports') }}" class="side-nav-link">
                        <i class="ri-file-list-3-fill"></i>
                        <span> Student Reports </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('PaymentReports') }}" class="side-nav-link">
                        <i class="ri-file-chart-2-line"></i>
                        <span> Payment Reports </span>
                    </a>
                </li>
            @endrole


            <li class="side-nav-title">Settings</li>
            @role('Super_Admin')
                <li class="side-nav-item">
                    <a href="{{ route('systemLog') }}" class="side-nav-link">
                        <i class="ri-file-list-3-fill"></i>
                        <span> System Log </span>
                    </a>
                </li>
            @endrole
            <li class="side-nav-item">
                <a href="{{ route('profile') }}" class="side-nav-link">
                    <i class="ri-settings-3-fill"></i>
                    <span> Profile </span>
                </a>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
