@extends('layout.MainLayout')
@section('content')
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">
                                #BookMyTutor
                            </a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                        <li class="breadcrumb-item active">Payments</li>
                    </ol>
                </div>
                <h4 class="page-title">Payments Reports</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12 text-center">
                        <h4 class="mb-3">Monthly Payment Totals</h4>
                    </div>
                    <div class="row">
                        @foreach ($monthlyTotals as $monthlyTotal)
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $monthlyTotal['month'] }}</h5>
                                        <p class="card-text fs-5 fw-bold">Total:
                                            Rs.{{ number_format($monthlyTotal['total'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-0">Payment Reports</h4>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Payment Method</th>
                                        <th>Paid For</th>
                                        <th>Student Name</th>
                                        <th>Processed By</th>
                                        <th>Amount</th>
                                        <th>Added Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->invoice_number }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>
                                                {{ $payment->paid_month . ' ' . $payment->paid_year }}
                                            </td>
                                            <td>{{ $payment->student->name }}</td>
                                            <td>{{ $payment->user->name }}</td>
                                            <td>{{ $payment->amount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d-M-Y') }}</td>
                                            <td>
                                                <span class="btn btn-primary">{{ $payment->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
