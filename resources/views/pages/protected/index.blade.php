@extends('layout.MainLayout')
@section('content')
    <div class="row">
        <div class="col-12">

            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="dash-daterange"/>
                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="ri-calendar-todo-fill fs-13"></i>
                            </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="ri-refresh-line"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>

        <div class="col-xl-6 ">
            <div class="card">
                <canvas id="paymentBarChart"></canvas>
            </div>
        </div>
        <div class="col-xl-6 ">
            <div class="card">
                <canvas id="studentBarChart"></canvas>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">
                                Students Registered (This Month)
                            </h5>
                            <h3 class="my-1 py-1">
                                {{ $registeredStudentsInThisMonth }}
                            </h3>

                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="campaign-sent-chart" data-colors="#1CBD77"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="New Leads">
                                Total Payments (This Month)
                            </h5>
                            <h3 class="my-1 py-1">{{ App\Models\Payment::getNowMonthTotal() }}</h3>
                            {{--                            <p class="mb-0 text-muted"> --}}
                            {{--                                <span class="text-success me-2">Rs.5200.00</span> --}}
                            {{--                            </p> --}}
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="new-leads-chart" data-colors="#87bf8a"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Deals">
                                Batch Count
                            </h5>
                            <h3 class="my-1 py-1">{{ $batchCountThisMonth }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">{{ $batchCount }} Total</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="deals-chart" data-colors="#e7607b"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-sm-6 col-xxl-3">
            <div class="card text-bg-primary border-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-white text-opacity-75 fw-normal mt-0 text-truncate" title="Booked Revenue">
                                Total Revenue (This Month)
                            </h5>
                            <h3 class="my-1 py-1">Rs.{{ App\Models\Payment::getTotalPaymentsTotalInThisMonth() }}
                                .00</h3>
                            <p class="mb-0 text-muted">
                                <span
                                    class="text-white text-opacity-75 me-2">Rs.{{ App\Models\Payment::getNowYearTotal() }}.00
                                    /yr</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="booked-revenue-chart" data-colors="#d89e70"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>

    {{-- end row --}}

    <div class="row">

        <div class="col-xl-6">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">
                        Latest Payments
                    </h4>
                    <a href="javascript:void(0);" class="btn btn-sm btn-info">Export<i
                            class="ri-download-line ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                            <thead class="border-top border-bottom bg-light-subtle border-light">
                            <tr>
                                <th class="py-1">
                                    INV #
                                </th>
                                <th class="py-1">
                                    Price
                                </th>
                                <th class="py-1">
                                    Student Name
                                </th>
                                <th class="py-1">
                                    Month
                                </th>
                                <th class="py-1">
                                    Status
                                </th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($lastTenPayments as $payment)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);"
                                           class="text-body fw-bold">#INV-{{ $payment->id }}</a>
                                    </td>
                                    <td>
                                        Rs. {{ $payment->amount }}.00
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           class="text-body fw-bold">{{ $payment->student->name }}</a>
                                    </td>
                                    <td>
                                            <span class="badge bg-soft-success text-success text-capitalize">
                                                FOR - {{ $payment->paid_month }}
                                            </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-success text-success">Paid</span>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('payments') }}"
                           class="text-primary text-decoration-underline fw-bold btn mb-2">View All</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">
                        Latest Students
                    </h4>
                    <a href="javascript:void(0);" class="btn btn-sm btn-info">Export<i
                            class="ri-download-line ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                            <thead class="border-top border-bottom bg-light-subtle border-light">
                            <tr>
                                <th class="py-1">
                                    Reg ID
                                </th>
                                <th class="py-1">
                                    Price
                                </th>
                                <th class="py-1">
                                    Student Name
                                </th>
                                <th>
                                    Created At
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($lastRegisteredStudents as $student)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);"
                                           class="text-body fw-bold">#REG-{{ $student->id }}</a>
                                    </td>
                                    <td>
                                        Rs. {{ $student->price }}.00
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           class="text-body fw-bold">{{ $student->name }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);"
                                           class="text-body fw-bold">{{ \Carbon\Carbon::parse($student->created_at)->format('d-m-Y') }}</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('students') }}"
                           class="text-primary text-decoration-underline fw-bold btn mb-2">View All</a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- end row -->


    <!-- end row -->
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Payment Bar Chart
            const paymentCtx = document.getElementById('paymentBarChart').getContext('2d');
            const paymentData = @json($paymentsLastFiveMonths);
            const paymentLabels = paymentData.map(item => item.month_name);
            const paymentAmounts = paymentData.map(item => item.total);

            new Chart(paymentCtx, {
                type: 'bar',
                data: {
                    labels: paymentLabels,
                    datasets: [{
                        label: 'Payment Amount (Last 5 Months)',
                        data: paymentAmounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rs.' + value;
                                }
                            }
                        }
                    }
                }
            });

            // Student Count Bar Chart
            const studentCtx = document.getElementById('studentBarChart').getContext('2d');
            const studentData = @json($studentCountLastFiveMonths);
            const studentLabels = studentData.map(item => item.month_name);
            const studentCounts = studentData.map(item => item.total);

            new Chart(studentCtx, {
                type: 'bar',
                data: {
                    labels: studentLabels,
                    datasets: [{
                        label: 'Student Count (Last 5 Months)',
                        data: studentCounts,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
