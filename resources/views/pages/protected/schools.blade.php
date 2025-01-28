@extends('layout.MainLayout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">#BookMyTutor</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Main</a></li>
                        <li class="breadcrumb-item active">Schools</li>
                    </ol>
                </div>
                <h4 class="page-title">Schools Management</h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h4 class="fs-16">All Schools</h4>
                <p class="text-muted fs-14">All Schools are listed here. You can add new school, edit or delete existing school.</p>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                    Add New School
                </button>

                <table id="schoolsTable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add School Modal -->
    <div class="modal fade" id="addSchoolModal" tabindex="-1" aria-labelledby="addSchoolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addSchoolForm" action="{{ route('schools.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSchoolModalLabel">Add New School</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="schoolName" class="form-label">School Name</label>
                            <input type="text" class="form-control" id="schoolName" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Initialize DataTable with server-side processing
            $('#schoolsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('schools.index') }}",
                    type: "GET",
                    dataSrc: function (json) {
                        console.log("Data received from server:", json); // Log the data received
                        return json.data; // Return the data for the table
                    },
                    error: function (xhr, error, thrown) {
                        console.log("Error while loading data:", xhr.responseJSON); // Log error response
                        console.log("Full Error Object:", xhr); // Log the full error object
                        console.error("Error Details:", error, thrown); // Log additional error details
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
                order: [[0, 'asc']],
                responsive: true,
            });


            // Add school form submission
            $('#addSchoolForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.post($(this).attr('action'), formData, function (response) {
                    alert(response.success);
                    $('#addSchoolModal').modal('hide');
                    $('#schoolsTable').DataTable().ajax.reload();
                }).fail(function (xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                });
            });
        });

        // Delete school
        function deleteSchool(id) {
            if (confirm('Are you sure you want to delete this school?')) {
                $.ajax({
                    url: `/schools/${id}`,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function (response) {
                        alert(response.success);
                        $('#schoolsTable').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        }
    </script>
@endsection
