<meta charset="utf-8" />
<meta name="theme-color" content="#22cc9d" />
<title>
    Book My Tutor | Student Management System
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta content="Student Management System" name="description" />
<meta content="Book My Tutor" name="Thamoddya Rashmitha" />

<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

<!-- Daterangepicker css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}" />

@if (Route::currentRouteName() == 'index')
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" />
@endif

@if (in_array(Route::currentRouteName(), [
        'batch',
        'management',
        'students',
        'payments',
        'studentReports',
        'PaymentReports',
        'systemLog',
        'schools',
    ]))
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}'"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}'"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}'" rel="stylesheet"
        type="text/css" />
@endif

<link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Theme Config Js -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- App css -->
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons css -->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
