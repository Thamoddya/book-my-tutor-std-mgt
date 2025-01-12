@extends('layout.MainLayout')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">Add New Class</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Classes</div>
                    <div class="card-body">
                        <table class="table table-bordered" id="classesDatatable">
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
                        </table>
                    </div>
                </div>
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

    <!-- Edit Class Modal -->
    <div class="modal fade" id="editClassModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editClassForm">
                    @csrf
                    <input type="hidden" id="editClassId">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editClassName" class="form-label">Class Name</label>
                            <input type="text" name="name" id="editClassName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editClassDescription" class="form-label">Description</label>
                            <textarea name="description" id="editClassDescription" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editClassTeacher" class="form-label">Teacher Name</label>
                            <input type="text" name="teacher" id="editClassTeacher" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const table = $('#classesDatatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('classes.load.data') }}",
                    dataSrc: "data"
                },
                "columns": [{
                        data: 'name',
                        title: 'Class Name'
                    },
                    {
                        data: 'code',
                        title: 'Class Code'
                    },
                    {
                        data: 'description',
                        title: 'Description'
                    },
                    {
                        data: 'teacher',
                        title: 'Teacher'
                    },
                    {
                        data: 'students',
                        title: 'Students'
                    },
                    {
                        data: 'id',
                        title: 'Actions',
                        render: function(data, type, row) {
                            return `<button class="btn btn-warning edit-class" data-id="${data}"
                                data-name="${row.name}"
                                data-description="${row.description}"
                                data-teacher="${row.teacher}">Edit</button>`;
                        }
                    }
                ]
            });

            // Open Edit Modal
            $('#classesDatatable').on('click', '.edit-class', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const description = $(this).data('description');
                const teacher = $(this).data('teacher');

                $('#editClassId').val(id);
                $('#editClassName').val(name);
                $('#editClassDescription').val(description);
                $('#editClassTeacher').val(teacher);

                $('#editClassModal').modal('show');
            });

            // Update Class
            $('#editClassForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#editClassId').val(); // Ensure this has the class ID
                const formData = {
                    _token: "{{ csrf_token() }}",
                    name: $('#editClassName').val(),
                    description: $('#editClassDescription').val(),
                    teacher: $('#editClassTeacher').val()
                };

                // Use Laravel's URL pattern manually and append the ID
                const updateUrl = `/classes/update/${id}`; // Adjusted to directly include the ID in the URL

                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#editClassModal').modal('hide');
                        table.ajax.reload(null, false);
                        alert(response.message);
                    },
                    error: function(response) {
                        alert('Error updating class: ' + response.responseJSON.message);
                    }
                });
            });

        });
    </script>
@endsection
