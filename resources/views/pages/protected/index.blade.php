@extends('layout.MainLayout')
@section('content')
    <div class="row">
        <div class="col-12">

            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="dash-daterange" />
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
                        <div class="col-12">
                            <h5 class="text-muted fw-normal mt-0 w-full" title="Campaign Sent">
                                Students Registered ({{ \Carbon\Carbon::now()->format('F') }})
                            </h5>
                            <h3 class="my-1 py-1">
                                {{ $registeredStudentsInThisMonth }}
                            </h3>

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
                        <div class="col-12">
                            <h5 class="text-muted fw-normal mt-0" title="New Leads">
                                Total Payments ({{ \Carbon\Carbon::now()->format('F') }})
                            </h5>
                            <h3 class="my-1 py-1">{{ App\Models\Payment::getNowMonthTotal() }}</h3>
                            {{--                            <p class="mb-0 text-muted"> --}}
                            {{--                                <span class="text-success me-2">Rs.5200.00</span> --}}
                            {{--                            </p> --}}
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
                        <div class="col-12">
                            <h5 class="text-muted fw-normal mt-0" title="Deals">
                                Batch Count
                            </h5>
                            <h3 class="my-1 py-1">{{ $batchCountThisMonth }}</h3>

                        </div>

                    </div>
                    <!-- end row-->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>

        <div class="col-sm-6 col-xxl-3">
            <div class="card text-bg-primary border-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h5 class=" text-white fw-normal mt-0" title="Deals">
                                Total Revenue ({{ \Carbon\Carbon::now()->format('F') }})
                            </h5>
                            <h3 class="my-1 py-1">Rs.{{ App\Models\Payment::getTotalPaymentsTotalInThisMonth() }}.00</h3>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>

    </div>



    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Payment Bar Chart
            const paymentCtx = document.getElementById('paymentBarChart').getContext('2d');
            const paymentData = @json($paymentsLastSixMonths);
            const paymentLabels = paymentData.map(item => item.month_name);
            const paymentAmounts = paymentData.map(item => item.total);

            new Chart(paymentCtx, {
                type: 'bar',
                data: {
                    labels: paymentLabels,
                    datasets: [{
                        label: 'Payment Amount (Last 6 Months)',
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
                                callback: function(value) {
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
