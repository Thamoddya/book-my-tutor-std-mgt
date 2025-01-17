@extends('layout.MainLayout')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">Add New Class
                </button>
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

    {{-- Manage Students Modal --}}
    <div class="modal fade" id="manageStudentsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Students</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        @csrf
                        <div class="mb-3">
                            <label for="studentRegNo" class="form-label">Student Registration Number</label>
                            <input type="text" id="studentRegNo" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </form>
                    <hr>
                    <table class="table table-bordered" id="studentsDatatable">
                        <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Student Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const routes = {
            getStudents: "{{ route('classes.get.students', ':id') }}",
            addStudent: "{{ route('classes.add.student', ':id') }}",
            removeStudent: "{{ route('classes.remove.student', [':class_id', ':student_id']) }}"
        };

        $(document).ready(function () {
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
                        render: function (data, type, row) {
                            return `
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary edit-class" data-id="${row.id}" data-name="${row.name}" data-description="${row.description}" data-teacher="${row.teacher}">Edit</button>
                            <button class="btn btn-sm btn-secondary manage-students" data-id="${row.id}" data-class-name="${row.name}">Students</button>
                            <button class="btn btn-sm btn-danger delete-class" data-id="${row.id}">Delete</button>
                        </div>
                    `;
                        }
                    }
                ]
            });

            //Add Class
            $('#addClassForm').on('submit', function (e) {
                e.preventDefault();

                const formData = {
                    _token: "{{ csrf_token() }}",
                    name: $('#className').val(),
                    description: $('#classDescription').val(),
                    teacher: $('#classTeacher').val()
                };

                $.ajax({
                    url: "{{ route('classes.store.ajax') }}",
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response.message);
                        $('#addClassModal').modal('hide');
                        $('#classesDatatable').DataTable().ajax.reload(null, false); // Reload the table
                        window.location.reload();
                    },
                    error: function (xhr) {
                        alert('Error adding class: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Open Manage Students Modal
            $('#classesDatatable').on('click', '.manage-students', function () {
                const classId = $(this).data('id');
                const className = $(this).data('class-name');

                $('#manageStudentsModal .modal-title').text(`Manage Students for ${className}`);
                $('#manageStudentsModal').modal('show');

                const getStudentsUrl = routes.getStudents.replace(':id', classId);
                const addStudentUrl = routes.addStudent.replace(':id', classId);

                // Destroy and reinitialize DataTable for students
                const studentsTable = $('#studentsDatatable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "destroy": true, // Reinitialize the table for each class
                    "ajax": getStudentsUrl,
                    "columns": [{
                        data: 'name',
                        title: 'Student Name'
                    },
                        {
                            data: 'email',
                            title: 'Student Email'
                        },
                        {
                            data: 'id',
                            title: 'Actions',
                            render: function (data) {
                                return `<button class="btn btn-danger btn-sm remove-student" data-id="${data}" data-class-id="${classId}">Remove</button>`;
                            }
                        }
                    ]
                });

                // Add Student to Class
                $('#addStudentForm').off('submit').on('submit', function (e) {
                    e.preventDefault();

                    const regNo = $('#studentRegNo').val();

                    $.ajax({
                        url: addStudentUrl,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            reg_no: regNo
                        },
                        success: function (response) {
                            $('#studentRegNo').val('');
                            studentsTable.ajax.reload(null,
                                false); // Reload the students table
                            table.ajax.reload(null,
                                false); // Reload the main classes table
                            alert(response.message);
                        },
                        error: function (response) {
                            alert('Error adding student: ' + response.responseJSON
                                .message);
                        }
                    });
                });

                // Remove Student from Class
                $('#studentsDatatable').off('click', '.remove-student').on('click', '.remove-student',
                    function () {
                        const studentId = $(this).data('id');
                        const removeUrl = routes.removeStudent.replace(':class_id', classId).replace(
                            ':student_id', studentId);

                        if (confirm('Are you sure you want to remove this student?')) {
                            $.ajax({
                                url: removeUrl,
                                method: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function (response) {
                                    studentsTable.ajax.reload(null,
                                        false); // Reload the students table
                                    table.ajax.reload(null,
                                        false); // Reload the main classes table
                                    alert(response.message);
                                },
                                error: function (response) {
                                    alert('Error removing student: ' + response.responseJSON
                                        .message);
                                }
                            });
                        }
                    });
            });

            // Open Edit Class Modal
            $('#classesDatatable').on('click', '.edit-class', function () {
                const classId = $(this).data('id');
                const className = $(this).data('name');
                const classDescription = $(this).data('description');
                const classTeacher = $(this).data('teacher');

                $('#editClassId').val(classId);
                $('#editClassName').val(className);
                $('#editClassDescription').val(classDescription);
                $('#editClassTeacher').val(classTeacher);

                $('#editClassModal').modal('show');
            });

            $('#editClassForm').on('submit', function (e) {
                e.preventDefault();

                const classId = $('#editClassId').val();
                const url = "{{ route('classes.update.ajax', ':id') }}".replace(':id', classId);

                const formData = {
                    _token: "{{ csrf_token() }}",
                    name: $('#editClassName').val(),
                    description: $('#editClassDescription').val(),
                    teacher: $('#editClassTeacher').val()
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response.message);
                        $('#editClassModal').modal('hide');
                        $('#classesDatatable').DataTable().ajax.reload(null, false); // Reload the table
                    },
                    error: function (xhr) {
                        alert('Error updating class: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Delete Class
            $('#classesDatatable').on('click', '.delete-class', function () {

                //Get Confirmation
                if (confirm('Are you sure you want to delete this class?')) {
                    const classId = $(this).data('id');
                    const url = "{{ route('classes.destroy', ':id') }}".replace(':id', classId);

                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            alert(response.message);
                            $('#classesDatatable').DataTable().ajax.reload(null, false); // Reload the table
                        },
                        error: function (xhr) {
                            alert('Error deleting class: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });

        });
    </script>
@endsection
