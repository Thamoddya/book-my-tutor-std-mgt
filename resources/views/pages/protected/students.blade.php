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
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </div>
                <h4 class="page-title">Student Management</h4>
            </div>
        </div>
    </div>


    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h4 class="fs-16">
                    All Students
                </h4>
                <p class="text-muted fs-14">
                    List of all students registered in the system.
                </p>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal"
                    data-bs-target="#addStudentModal">
                    Add New Student
                </button>

                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>STD ID</th>
                            <th>Full Name :</th>
                            <th>Call No :</th>
                            <th>Whatsapp No :</th>
                            <th>Email :</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->reg_no }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->call_no }}</td>
                                <td>{{ $student->wtp_no }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" onclick="openEditModal({{ $student->id }})">Edit</a>
                                    <a class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter Full Name">
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="callNo" class="form-label">Call No</label>
                            <input type="number" maxlength="10" class="form-control" id="callNo"
                                placeholder="Enter Call No">
                            <div class="invalid-feedback" id="call_noError"></div>
                            <div class="form-check form-checkbox-success mt-1">
                                <input type="checkbox" class="form-check-input" id="markCallNoAsWhatsappNo"
                                    onclick="setWhatsappNo()">
                                <label class="form-check-label" for="markCallNoAsWhatsappNo">
                                    Same as Call No
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="whatsappNo" class="form-label">WhatsApp No</label>
                            <input type="number" class="form-control" id="whatsappNo" placeholder="Enter WhatsApp No">
                            <div class="invalid-feedback" id="wtp_noError"></div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="created_at">Created At (Optional)</label>
                            <input type="datetime-local" name="created_at" id="created_at" class="form-control">
                            <div class="invalid-feedback" id="created_atError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="schoolSearch" class="form-label">Search School</label>
                            <input type="text" id="schoolSearch" class="form-control"
                                placeholder="Type to search school">
                            <input type="hidden" id="schoolId">
                            <ul id="schoolSuggestions" class="list-group"
                                style="position: absolute; z-index: 1050; display: none;"></ul>
                            <div class="invalid-feedback" id="school_idError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="batch" class="form-label select2">Batch</label>
                            <select class="form-select select2" id="batch" data-toggle="select2">
                                <option selected>Select Batch</option>
                                @foreach ($batches as $batch)
                                    <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="batch_idError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Email">
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address">
                            <div class="invalid-feedback" id="addressError"></div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" onclick="addNewStudentProcess()">Add Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <input type="hidden" id="editStudentId">
                        <div class="mb-3">
                            <label for="editFullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editFullName">
                            <div class="invalid-feedback" id="editNameError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editCallNo" class="form-label select2">Call No</label>
                            <input type="number" class="form-control" id="editCallNo">
                            <div class="invalid-feedback" id="editCallNoError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editWhatsappNo" class="form-label select2">WhatsApp No</label>
                            <input type="number" class="form-control" id="editWhatsappNo">
                            <div class="invalid-feedback" id="editWhatsappNoError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editSchoolSearch" class="form-label">Search New School</label>
                            <input type="text" id="editSchoolSearch" class="form-control"
                                placeholder="Type to search school">
                            <input type="hidden" id="editSchoolId">
                            <ul id="editSchoolSuggestions" class="list-group"
                                style="position: absolute; z-index: 1050; display: none;"></ul>
                            <div class="invalid-feedback" id="editSchool_idError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editSchool" class="form-label select2">School</label>
                            <input type="hidden" id="editSchoolId">
                            <select class="form-select select2" id="editSchool">
                                <!-- School options will be populated dynamically -->
                            </select>
                            <div class="invalid-feedback" id="editSchool_idError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editBatch" class="form-label select2">Batch</label>
                            <select class="form-select select2" id="editBatch">
                                <option selected>Select Batch</option>
                                @foreach ($batches as $batch)
                                    <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="editBatch_idError"></div>
                        </div>
                        {{-- Edit Created at --}}
                        <div class="form-group mt-2">
                            <label for="editCreatedAt">Created At (Optional)</label>
                            <input type="datetime-local" name="created_at" id="editCreatedAt" class="form-control">
                            <div class="invalid-feedback" id="editCreatedAtError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail">
                            <div class="invalid-feedback" id="editEmailError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress">
                            <div class="invalid-feedback" id="editAddressError"></div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" onclick="updateStudentProcess()">Update
                                Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const schoolSearchInput = $('#schoolSearch');
            const schoolSuggestions = $('#schoolSuggestions');
            const schoolIdInput = $('#schoolId');

            schoolSearchInput.on('input', function() {
                const query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: '/api/schools',
                        method: 'GET',
                        data: {
                            search: query
                        },
                        success: function(response) {
                            schoolSuggestions.empty().show();
                            if (response.length > 0) {
                                response.forEach(school => {
                                    schoolSuggestions.append(`
                                <li class="list-group-item list-group-item-action"
                                    data-id="${school.id}"
                                    data-name="${school.name}">
                                    ${school.name}
                                </li>
                            `);
                                });
                            } else {
                                schoolSuggestions.append(
                                    `<li class="list-group-item">No results found</li>`);
                            }
                        },
                        error: function() {
                            schoolSuggestions.hide();
                        }
                    });
                } else {
                    schoolSuggestions.hide();
                }
            });

            // Handle click on suggestion
            schoolSuggestions.on('click', 'li', function() {
                const schoolName = $(this).data('name');
                const schoolId = $(this).data('id');

                schoolSearchInput.val(schoolName);
                schoolIdInput.val(schoolId); // Save the selected school's ID
                schoolSuggestions.hide();
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#schoolSearch, #schoolSuggestions').length) {
                    schoolSuggestions.hide();
                }
            });

            // Ensure WhatsApp No is updated if Call No is edited and checkbox is checked
            $('#callNo').on('input', function() {
                const checkbox = $('#markCallNoAsWhatsappNo');
                const whatsappNoField = $('#whatsappNo');

                if (checkbox.is(':checked')) {
                    whatsappNoField.val($(this).val());
                }
            });
        });

        $(document).ready(function() {
            const editSchoolSearchInput = $('#editSchoolSearch');
            const editSchoolSuggestions = $('#editSchoolSuggestions');
            const editSchoolIdInput = $('#editSchoolId');

            editSchoolSearchInput.on('input', function() {
                const query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: '/api/schools',
                        method: 'GET',
                        data: {
                            search: query
                        },
                        success: function(response) {
                            editSchoolSuggestions.empty().show();
                            if (response.length > 0) {
                                response.forEach(school => {
                                    editSchoolSuggestions.append(`
                                <li class="list-group-item list-group-item-action"
                                    data-id="${school.id}"
                                    data-name="${school.name}">
                                    ${school.name}
                                </li>
                            `);
                                });
                            } else {
                                editSchoolSuggestions.append(
                                    `<li class="list-group-item">No results found</li>`);
                            }
                        },
                        error: function() {
                            editSchoolSuggestions.hide();
                        }
                    });
                } else {
                    editSchoolSuggestions.hide();
                }
            });

            editSchoolSuggestions.on('click', 'li', function() {
                const schoolName = $(this).data('name');
                const schoolId = $(this).data('id');

                editSchoolSearchInput.val(schoolName);
                editSchoolIdInput.val(schoolId); // Save the selected school's ID
                editSchoolSuggestions.hide();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#editSchoolSearch, #editSchoolSuggestions').length) {
                    editSchoolSuggestions.hide();
                }
            });
        });


        function addNewStudentProcess() {
            const formData = {
                name: $('#fullName').val().trim(),
                call_no: $('#callNo').val().trim(),
                wtp_no: $('#whatsappNo').val().trim(),
                school_id: $('#schoolId').val().trim(),
                batch_id: $('#batch').val(),
                email: $('#email').val().trim(),
                address: $('#address').val().trim(),
                created_at: $('#created_at').val(),
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
            };

            // Clear all previous errors
            $('.invalid-feedback').text('').hide();
            $('.form-control, .form-select').removeClass('is-invalid');

            // Send data to the server using AJAX
            $.ajax({
                url: '/students', // Adjust this URL to match your store route
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Reload the page or reset the form
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors from Laravel
                        const errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            // Map server-side errors to form fields
                            let errorField = $(`#${field}`);
                            errorField.addClass('is-invalid'); // Highlight the field
                            $(`#${field}Error`).text(errors[field][0]).show(); // Show the error message
                        }
                    } else {
                        console.log(xhr);
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        }

        function setWhatsappNo() {
            const checkbox = $('#markCallNoAsWhatsappNo');
            const callNoField = $('#callNo');
            const whatsappNoField = $('#whatsappNo');
            const callNoError = $('#callNoError');

            // Validation for Call No length
            if (callNoField.val().length !== 10) {
                callNoError.text("Call No must be 10 digits").show();
                return;
            } else {
                callNoError.hide();
            }

            // Synchronize WhatsApp No based on checkbox status
            if (checkbox.is(':checked')) {
                whatsappNoField.val(callNoField.val());
                whatsappNoField.prop('readonly', true);
            } else {
                whatsappNoField.prop('readonly', false);
                whatsappNoField.val('');
            }
        }

        function openEditModal(id) {
            $.ajax({
                url: `/students/${id}`,
                method: 'GET',
                success: function(response) {
                    // Populate the fields with the student data
                    $('#editStudentId').val(response.student.id);
                    $('#editFullName').val(response.student.name);
                    $('#editCallNo').val(response.student.call_no);
                    $('#editWhatsappNo').val(response.student.wtp_no);
                    $('#editEmail').val(response.student.email);
                    $('#editAddress').val(response.student.address);
                    $('#editSchoolId').val(response.student.school_id);

                    // Fetch and display the school name
                    $.ajax({
                        url: `/api/schools/${response.student.school_id}`, // Assuming this endpoint returns school details by ID
                        method: 'GET',
                        success: function(schoolResponse) {
                            $('#editSchool').html(`
                        <option value="${schoolResponse.id}" selected>${schoolResponse.name}</option>
                    `);
                        },
                        error: function() {
                            alert('Failed to fetch school details.');
                        }
                    });

                    // Pre-select the batch in the dropdown
                    $('#editBatch').val(response.student.batch_id);

                    // Format and set the created_at value
                    if (response.student.created_at) {
                        const createdAt = new Date(response.student.created_at);
                        const formattedCreatedAt = createdAt.toISOString().slice(0,
                            16); // Format for datetime-local
                        $('#editCreatedAt').val(formattedCreatedAt);
                    } else {
                        $('#editCreatedAt').val(''); // Clear if no value
                    }

                    // Show the edit modal
                    $('#editStudentModal').modal('show');
                },
                error: function() {
                    alert('An error occurred while fetching student details.');
                }
            });
        }



        function updateStudentProcess() {
            const id = $('#editStudentId').val();
            const formData = {
                name: $('#editFullName').val(),
                call_no: $('#editCallNo').val(),
                wtp_no: $('#editWhatsappNo').val(),
                school_id: $('#editSchoolId').val(),
                batch_id: $('#editBatch').val(),
                email: $('#editEmail').val(),
                created_at: $('#editCreatedAt').val(),
                address: $('#editAddress').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: `/students/${id}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Reload the page
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 422) {
                        // Handle validation errors
                        const errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            $(`#edit${field.charAt(0).toUpperCase() + field.slice(1)}Error`).text(errors[field][
                                0
                            ]).show();
                        }
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        }
    </script>
@endsection
