@extends('layout.MainLayout')
@section('content')
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">#BookMyTutor</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Main</a></li>
                        <li class="breadcrumb-item active">Batch</li>
                    </ol>
                </div>
                <h4 class="page-title">Batch Management Dashboard</h4>
            </div>
        </div>
    </div>

    <!-- Donut Chart Section -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Students in Each Batch</h5>
                </div>
                <div class="card-body">
                    <canvas id="batchDonutChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Batch Overview</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Manage all batches below. Add, edit, or deactivate batches as needed.</p>
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#addBatchModal">Add New Batch
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Batches Table -->
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Batch ID</th>
                        <th>Batch Name</th>
                        <th>Batch Created Date :</th>
                        <th>Batch Updated Date :</th>
                        <th>Batch Status :</th>
                        <th>Batch Students Count :</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($batches as $batch)
                        <tr>
                            <td>{{ $batch->id }}</td>
                            <td>{{ $batch->name }}</td>
                            <td>{{$batch->created_at->format('d M, Y')    }}</td>
                            <td>{{$batch->updated_at->format('d M, Y')    }}</td>
                            <td>
                                @if($batch->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $batch->students->count() }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                   onclick="openEditBatchModal({{ $batch->id }}, '{{ $batch->name }}')">Edit</a>
                                @if($batch->status == 1)
                                    <a class="btn btn-danger btn-sm"
                                       onclick="confirmDeactivateBatch({{ $batch->id }})"
                                    >Deactivate</a>
                                @else
                                    <a class="btn btn-success btn-sm"
                                       onclick="confirmActivateBatch({{ $batch->id }})">Activate batch</a>
                                @endif

                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>

            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
    {{-- Add Batch Modal --}}
    <div id="addBatchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addBatchModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="addBatchModalLabel">
                        Create New Batch
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="batchName" class="form-label">Batch Name</label>
                        <input type="text" id="batchName" class="form-control">
                        <div class="invalid-feedback" id="batchNameError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addBatchProcess()">
                        Store Batch
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Batch Modal --}}
    <div id="editBatchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editBatchModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-warning">
                    <h4 class="modal-title" id="editBatchModalLabel">
                        Edit Batch
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editBatchId">
                    <div class="mb-3">
                        <label for="editBatchName" class="form-label">Batch Name</label>
                        <input type="text" id="editBatchName" class="form-control">
                        <div class="invalid-feedback" id="editBatchNameError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" onclick="updateBatchProcess()">
                        Update Batch
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data for Donut Chart
        const chartData = @json($chartData);

        const batchNames = chartData.map(batch => batch.name);
        const studentsCounts = chartData.map(batch => batch.students_count);

        // Render Donut Chart
        const ctx = document.getElementById('batchDonutChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: batchNames,
                datasets: [{
                    data: studentsCounts,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>
    <script>
        function addBatchProcess() {
            const batchName = $("#batchName").val();
            const batchNameError = $("#batchNameError");

            batchNameError.text("");
            batchNameError.removeClass("d-block");

            $.ajax({
                url: "{{ route('store-batch-process') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: {
                    name: batchName
                },
                success: function (response) {
                    alert("Batch created successfully: " + response.batch.name);
                    $("#addBatchModal").modal("hide");
                    location.reload();
                },
                error: function (xhr) {
                    console.log(xhr);
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors && errors.name) {
                            batchNameError.text(errors.name[0]);
                            batchNameError.addClass("d-block");
                        }
                    } else {
                        alert("An error occurred: " + xhr.responseJSON.message);
                    }
                }
            });
        }

        function openEditBatchModal(batchId, batchName) {
            $("#editBatchId").val(batchId);
            $("#editBatchName").val(batchName);
            $("#editBatchModal").modal("show");
        }

        function updateBatchProcess() {
            const batchId = $("#editBatchId").val();
            const batchName = $("#editBatchName").val();
            const batchNameError = $("#editBatchNameError");

            batchNameError.text("");
            batchNameError.removeClass("d-block");

            $.ajax({
                url: `/batches/${batchId}`,
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                data: {
                    name: batchName
                },
                success: function (response) {
                    // Success response
                    alert("Batch updated successfully: " + response.batch.name);
                    $("#editBatchModal").modal("hide"); // Close the modal
                    location.reload(); // Optionally refresh the page
                },
                error: function (xhr) {
                    console.log(xhr);
                    // Handle validation errors
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors && errors.name) {
                            batchNameError.text(errors.name[0]);
                            batchNameError.addClass("d-block");
                        }
                    } else {
                        // Handle other errors
                        alert("An error occurred: " + xhr.responseJSON.message);
                    }
                }
            });
        }

        function confirmDeactivateBatch(batchId) {
            if (confirm("Are you sure you want to deactivate this batch?")) {
                deactivateBatch(batchId);
            }
        }

        function deactivateBatch(batchId) {
            $.ajax({
                url: `/batches/${batchId}/deactivate`, // Update the URL if necessary
                method: "PATCH",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    alert("Batch deactivated successfully.");
                    location.reload(); // Reload to reflect changes
                },
                error: function (xhr) {
                    alert("An error occurred: " + xhr.responseJSON.message);
                },
            });
        }

        function confirmActivateBatch(batchId) {
            if (confirm("Are you sure you want to activate this batch?")) {
                activateBatch(batchId);
            }
        }

        function activateBatch(batchId) {
            $.ajax({
                url: `/batches/${batchId}/activate`, // Update the URL if necessary
                method: "PATCH",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    alert("Batch activated successfully.");
                    location.reload(); // Reload to reflect changes
                },
                error: function (xhr) {
                    alert("An error occurred: " + xhr.responseJSON.message);
                },
            });
        }
    </script>
@endsection
