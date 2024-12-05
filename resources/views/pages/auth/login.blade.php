<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.core.Head')
</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-lg-5">
                    <div class="position-relative rounded-3 overflow-hidden" style="">
                        <div class="card bg-transparent mb-0">

                            <div class="card-body p-4">
                                <div class="w-50">
                                    <h4 class="pb-0 fw-bold">Sign In</h4>
                                    <p class="fw-semibold mb-4">Enter your NIC and password to access admin
                                        panel.</p>
                                </div>

                                <form action="#">

                                    <div class="mb-3">
                                        <label for="nic" class="form-label">Nic Number</label>
                                        <input class="form-control" type="text" id="nic" required=""
                                            placeholder="Enter your nic">
                                    </div>

                                    <div class="mb-3">
                                        {{-- <a href="auth-recoverpw.html" class="float-end fs-12">Forgot your password?</a> --}}
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control"
                                                placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-signin"
                                                checked>
                                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 mb-0 text-center">
                                        <button class="btn btn-primary w-100" type="submit"> Log In </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt fw-medium">
        <span class="bg-body">
            <script>
                document.write(new Date().getFullYear())
            </script> © Book My Tutor by <a href="https://thamoddya.me/" target="blank"
                class="text-primary">Thamoddya
                Rashmitha</a>
        </span>
    </footer>

    @include('components.core.Foot')

</body>

</html>
