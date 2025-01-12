<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

@if (in_array(Route::currentRouteName(), [
        'batch',
        'management',
        'students',
        'payments',
        'studentReports',
        'PaymentReports',
        'systemLog',
        'schools',
        'index',
        'classes',
    ]))
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
@endif

<!-- Daterangepicker js -->
<script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

@if (Route::currentRouteName() == ['index'])
    <!-- Apex Charts js -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Dashboard App js -->
    <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
@endif

<script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#schoolSelector').select2({
            placeholder: "Search for a school",
            allowClear: true,
            width: 'resolve',
        });
    });
</script>


<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script
    src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/cr-2.0.4/date-1.5.5/fc-5.0.4/fh-4.0.1/r-3.0.3/sc-2.4.3/datatables.min.js">
</script>
