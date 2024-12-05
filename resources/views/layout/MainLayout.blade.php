<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.core.Head')
</head>

<body>

    <div class="wrapper">
        @include('components.core.Topbar')
        @include('components.core.LeftSidebar')

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('components.core.Foot')
    @yield('script')
</body>

</html>
