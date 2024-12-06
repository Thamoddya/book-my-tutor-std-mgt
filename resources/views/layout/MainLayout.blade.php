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

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        © Book My Tutor by <a href="https://thamoddya.me/" target="blank" class="text-primary">Thamoddya
                            Rashmitha</a>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="text-md-end footer-links d-none d-md-block"
                        >
                            <a href="javascript: void(0);">About</a>
                            <a href="javascript: void(0);">Support</a>
                            <a href="javascript: void(0);"
                            >Contact Us</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

@include('components.core.Foot')
@yield('script')
</body>

</html>
