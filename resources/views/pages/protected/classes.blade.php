@extends('layout.MainLayout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">#BookMyTutor</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Main</a></li>
                        <li class="breadcrumb-item active">Classes</li>
                    </ol>
                </div>
                <h4 class="page-title">Class Management</h4>
            </div>
        </div>
    </div>

    <!-- Add Class Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addClassForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="className" class="form-label">Class Name</label>
                            <input type="text" name="name" id="className" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="classDescription" class="form-label">Description</label>
                            <textarea name="description" id="classDescription" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="classTeacher" class="form-label">Teacher Name</label>
                            <input type="text" name="teacher" id="classTeacher" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Classes Table -->
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">Add New
                    Class</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Classes</div>
                    <div class="card-body">
                        <table class="table table-bordered w-full responsive" id="datatable-buttons">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Class Code</th>
                                    <th>Description</th>
                                    <th>Teacher</th>
                                    <th>Students</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            //Load data to table , datatable already initialized in MainLayout
            $.ajax({
                url: "{{ route('classes.load.data') }}",
                method: 'GET',
                success: function(response) {
                    console.log(response);

                    response.forEach(function(data) {
                        $('#datatable-buttons').DataTable().row.add([
                            data.name,
                            data.code,
                            data.description,
                            data.teacher,
                            data.students,
                            `<button class="btn btn-danger delete-class" data-id="${data.id}">Delete</button>`
                        ]).draw(false);
                    });
                },
                error: function(response) {
                    alert('Failed to load classes.');
                }
            });


            // Add Class
            $('#addClassForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('classes.store.ajax') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addClassModal').modal('hide');
                        $('#addClassForm')[0].reset();
                        table.ajax.reload(null, false); // Reload table without reinitializing
                        alert(response.message);
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            });

            // Delete Class
            $('#datatable-buttons').on('click', '.delete-class', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this class?')) {
                    $.ajax({
                        url: `classes/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            table.ajax.reload(null,
                                false); // Reload table without reinitializing
                            alert('Class deleted successfully!');
                        },
                        error: function() {
                            alert('Failed to delete class.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
