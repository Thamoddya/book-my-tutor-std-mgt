@extends('layout.MainLayout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">
                                #BookMyTutor
                            </a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Main</a></li>
                        <li class="breadcrumb-item active">Payments</li>
                    </ol>
                </div>
                <h4 class="page-title">Payment Management</h4>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h4 class="fs-16">
                    All Payments
                </h4>
                <p class="text-muted fs-14">
                    All payments made by students are listed here.
                </p>

                <button class="btn btn-primary mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    Add Payment
                </button>

                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>INV NO</th>
                            <th>STD ID</th>
                            <th>Month</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Receipt PIC</th>
                            @role('Super_Admin')
                                <th>Actions</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->invoice_number }}</td>
                                <td>{{ $payment->student->reg_no }}</td>
                                <td>{{ ucfirst($payment->paid_month) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $payment->status === 'Paid' ? 'success' : ($payment->status === 'due' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->amount }}</td>
                                <td>
                                    @if ($payment->receipt_picture)
                                        <a href="{{ route('receipt.view', ['filename' => basename($payment->receipt_picture)]) }}"
                                            target="_blank" class="">View</a>
                                    @else
                                        No Receipt
                                    @endif
                                </td>

                                <td>
                                    @role('Super_Admin')
                                        <button class="btn btn-sm btn-warning " onclick="viewPayment('{{ $payment->id }}')">
                                            View Payment
                                        </button>
                                        <button class="btn btn-sm btn-secondary" onclick="editPayment('{{ $payment->id }}')">
                                            Edit Payment
                                        </button>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="paymentForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control">
                                @foreach (App\Models\Payment::paymentMethods() as $method)
                                    <option value="{{ $method }}">{{ ucfirst($method) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="payment_methodError"></div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="created_at">Created At (Optional)</label>
                            <input type="datetime-local" name="created_at" id="created_at" class="form-control">
                            <div class="invalid-feedback" id="created_atError"></div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="paid_month">Paid Month</label>
                            <select name="paid_month" id="paid_month" class="form-control">
                                @foreach (App\Models\Payment::months() as $month)
                                    <option value="{{ $month }}"
                                        {{ strtolower($month) == strtolower(now()->format('F')) ? 'selected' : '' }}>
                                        {{ ucfirst($month) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="paid_year">Paid Year</label>
                            <select name="paid_year" id="paid_year" class="form-control">
                                @foreach (App\Models\Payment::years() as $year)
                                    <option value="{{ $year }}"
                                        {{ $year == now()->format('Y') ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                            <div class="invalid-feedback" id="amountError"></div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="student_id">Student ID</label>
                            <input type="text" name="student_id" id="student_id" class="form-control" required>
                            <div class="invalid-feedback" id="student_idError"></div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="payment_status">Status</label>
                            <select name="payment_status" id="payment_status" class="form-control d-flex">
                                @foreach (App\Models\Payment::statuses() as $status)
                                    <option value="{{ $status }}" {{ $status == 'paid' ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="payment_statusError"></div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="receipt_picture">Receipt Picture</label>
                            <input type="file" name="receipt_picture" id="receipt_picture" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    View Payment Modal --}}
    <div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPaymentModalLabel">View Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="viewPaymentMethod" class="form-label fw-bold">Payment Method</label>
                                <input type="text" id="viewPaymentMethod" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="viewPaidMonth" class="form-label fw-bold">Paid Month</label>
                                <input type="text" id="viewPaidMonth" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="viewPaidYear" class="form-label fw-bold">Paid Year</label>
                                <input type="text" id="viewPaidYear" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="viewAmount" class="form-label fw-bold">Amount</label>
                                <input type="text" id="viewAmount" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="viewStudentId" class="form-label fw-bold">Student ID</label>
                                <input type="text" id="viewStudentId" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="viewStudentName" class="form-label fw-bold">Student Name</label>
                                <input type="text" id="viewStudentName" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="viewPaymentStatus" class="form-label fw-bold">Status</label>
                                <input type="text" id="viewPaymentStatus" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="viewReceiptPicture" class="form-label fw-bold">Receipt Picture</label>
                                <a id="viewReceiptPicture" class="form-control" target="_blank">View Receipt</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Payment Modal --}}
    <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPaymentForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="edit_payment_method">Payment Method</label>
                            <select name="payment_method" id="edit_payment_method" class="form-control">
                                @foreach (App\Models\Payment::paymentMethods() as $method)
                                    <option value="{{ $method }}">{{ ucfirst($method) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="edit_payment_methodError"></div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="edit_paid_month">Paid Month</label>
                            <select name="paid_month" id="edit_paid_month" class="form-control">
                                @foreach (App\Models\Payment::months() as $month)
                                    <option value="{{ $month }}">{{ ucfirst($month) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="edit_paid_year">Paid Year</label>
                            <select name="paid_year" id="edit_paid_year" class="form-control">
                                @foreach (App\Models\Payment::years() as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="edit_amount">Amount</label>
                            <input type="number" name="amount" id="edit_amount" class="form-control" required>
                            <div class="invalid-feedback" id="edit_amountError"></div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="edit_payment_status">Status</label>
                            <select name="status" id="edit_payment_status" class="form-control">
                                @foreach (App\Models\Payment::statuses() as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="edit_payment_statusError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#paymentForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('payments.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Success feedback
                        $('#paymentModal').modal('hide');
                        $('#paymentForm')[0].reset();
                        alert(response.message);
                        window.location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            let errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                const fieldElement = $(`#${field}`);
                                const errorElement = $(`#${field}Error`);

                                if (fieldElement.length && errorElement.length) {
                                    // Highlight the field and show the error message
                                    fieldElement.addClass('is-invalid');
                                    errorElement.text(errors[field][0]);
                                }
                            }
                        } else if (xhr.status === 404) {
                            // Handle not found error
                            alert('Student not found. Please check the registration number.');
                        } else {
                            // General error feedback
                            alert('Something went wrong. Please try again.');
                        }
                    },
                });
            });
        });

        function viewPayment(paymentId) {

            // Clear previous errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            // Clear previous data
            $('#viewPaymentMethod').val('');
            $('#viewPaidMonth').val('');
            $('#viewPaidYear').val('');
            $('#viewAmount').val('');
            $('#viewStudentId').val('');
            $('#viewPaymentStatus').val('');
            $('#viewReceiptPicture').attr('href', '');


            $.ajax({
                url: `/payments/${paymentId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#viewPaymentMethod').val(response.payment.payment_method);
                    $('#viewPaidMonth').val(response.payment.paid_month);
                    $('#viewPaidYear').val(response.payment.paid_year);
                    $('#viewAmount').val(response.payment.amount);
                    $('#viewStudentId').val(response.student.reg_no);
                    $('#viewStudentName').val(response.student.name);
                    $('#viewPaymentStatus').val(response.payment.status);
                    $('#viewReceiptPicture').attr('href', `storage/${response.payment.receipt_picture}`);
                    $('#viewPaymentModal').modal('show');
                },
                error: function(xhr) {
                    alert('Something went wrong. Please try again.');
                }
            });
        }

        function editPayment(paymentId) {
            // Clear errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            // Fetch payment details
            $.ajax({
                url: `/payments/${paymentId}/edit`,
                method: 'GET',
                success: function(response) {
                    // Populate the edit form with fetched data
                    $('#edit_payment_method').val(response.payment.payment_method);
                    $('#edit_paid_month').val(response.payment.paid_month);
                    $('#edit_paid_year').val(response.payment.paid_year);
                    $('#edit_amount').val(response.payment.amount);
                    $('#edit_payment_status').val(response.payment.status);

                    // Show the modal
                    $('#editPaymentModal').modal('show');

                    // Set form action dynamically
                    $('#editPaymentForm').off('submit').on('submit', function(e) {
                        e.preventDefault();
                        updatePayment(paymentId);
                    });
                },
                error: function() {
                    alert('Failed to fetch payment details.');
                },
            });
        }

        function updatePayment(paymentId) {
            let formData = $('#editPaymentForm').serialize();

            $.ajax({
                url: `/payments/${paymentId}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editPaymentModal').modal('hide');
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            $(`#edit_${field}`).addClass('is-invalid');
                            $(`#edit_${field}Error`).text(errors[field][0]);
                        }
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },
            });
        }
    </script>
@endsection
