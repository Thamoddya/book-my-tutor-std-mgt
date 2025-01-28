@extends('layout.MainLayout')

@section('content')
    <div class="container">


        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <h4>Payments by Class (Last 6 Months)</h4>
                    <canvas id="paymentBarChart"></canvas>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">Add Schedule
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered" id="schedulesTable">
                            <thead>
                            <tr>
                                <th>Class Name</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Tutor</th>
                                <th>Mode</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Schedule Modal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addScheduleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="day" class="form-label">Date</label>
                            <input type="date" id="day" name="day" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tutor" class="form-label">Tutor</label>
                            <input type="text" id="tutor" name="tutor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="mode" class="form-label">Mode</label>
                            <select id="mode" name="mode" class="form-control" required>
                                <option value="online">Online</option>
                                <option value="physical">Physical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Link (if online)</label>
                            <input type="url" id="link" name="link" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="any_material_url" class="form-label">Material URL</label>
                            <input type="url" id="any_material_url" name="any_material_url" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea id="note" name="note" class="form-control"></textarea>
                        </div>

                        {{-- Errors Alert --}}
                        <div class="alert alert-danger" id="errors" style="display: none"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editScheduleForm">
                    @csrf
                    @method('PUT') <!-- For PUT method -->
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_schedule_id" name="id">
                        <div class="mb-3">
                            <label for="edit_class_id" class="form-label">Class</label>
                            <select name="class_id" id="edit_class_id" class="form-control" required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_day" class="form-label">Date</label>
                            <input type="date" id="edit_day" name="day" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_start_time" class="form-label">Start Time</label>
                            <input type="time" id="edit_start_time" name="start_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_end_time" class="form-label">End Time</label>
                            <input type="time" id="edit_end_time" name="end_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tutor" class="form-label">Tutor</label>
                            <input type="text" id="edit_tutor" name="tutor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_mode" class="form-label">Mode</label>
                            <select id="edit_mode" name="mode" class="form-control" required>
                                <option value="online">Online</option>
                                <option value="physical">Physical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_link" class="form-label">Link (if online)</label>
                            <input type="url" id="edit_link" name="link" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="edit_any_material_url" class="form-label">Material URL</label>
                            <input type="url" id="edit_any_material_url" name="any_material_url"
                                   class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="edit_note" class="form-label">Note</label>
                            <textarea id="edit_note" name="note" class="form-control"></textarea>
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
        $(document).ready(function () {
            const table = $('#schedulesTable').DataTable({
                "processing": true,
                "serverSide": false,
                "order": [],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ajax": {
                    url: "{{ route('class-schedules.load') }}",
                    type: "GET",
                    dataSrc: function (json) {
                        return json.data;
                    },
                    error: function (xhr, status, error) {
                        console.error('DataTables Error:', error);
                    }
                },
                "columns": [{
                    data: 'class_name',
                    title: 'Class Name'
                },
                    {
                        data: 'day',
                        title: 'Day'
                    },
                    {
                        data: 'start_time',
                        title: 'Start Time'
                    },
                    {
                        data: 'end_time',
                        title: 'End Time'
                    },
                    {
                        data: 'tutor',
                        title: 'Tutor'
                    },
                    {
                        data: 'mode',
                        title: 'Mode'
                    },
                    {
                        data: 'id',
                        title: 'Actions',
                        render: function (data) {
                            return `
                    <button class="btn btn-sm btn-warning edit-schedule" data-id="${data}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-schedule" data-id="${data}">Delete</button>
                `;
                        }
                    }
                ]
            });

            // Add Schedule
            $('#addScheduleForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('class-schedules.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#addScheduleModal').modal('hide');
                        $('#addScheduleForm')[0].reset();
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function (response) {
                        alert('Error adding schedule');
                        console.log(response);

                        // Display errors
                        $('#errors').html('');
                        $('#errors').show();
                        $.each(response.responseJSON.errors, function (key, value) {
                            $('#errors').append(`<p>${value}</p>`);
                        });


                    }
                });
            });

            // Delete Schedule
            $('#schedulesTable').on('click', '.delete-schedule', function () {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this schedule?')) {
                    $.ajax({
                        url: `/class-schedules/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            table.ajax.reload();
                            alert(response.message);
                        },
                        error: function (response) {
                            alert('Error deleting schedule');
                        }
                    });
                }
            });

            // Open Edit Modal
            $('#schedulesTable').on('click', '.edit-schedule', function () {
                const scheduleId = $(this).data('id');
                $.ajax({
                    url: `/class-schedules/${scheduleId}`,
                    method: "GET",
                    success: function (response) {
                        // Populate the form with the schedule data
                        $('#edit_schedule_id').val(response.id);
                        $('#edit_class_id').val(response.class_id);
                        $('#edit_day').val(response.day);
                        $('#edit_start_time').val(response.start_time);
                        $('#edit_end_time').val(response.end_time);
                        $('#edit_tutor').val(response.tutor);
                        $('#edit_mode').val(response.mode);
                        $('#edit_link').val(response.link);
                        $('#edit_any_material_url').val(response.any_material_url);
                        $('#edit_note').val(response.note);

                        // Show the modal
                        $('#editScheduleModal').modal('show');
                    },
                    error: function (response) {
                        alert('Error fetching schedule data');
                        console.log(response);
                    }
                });
            });

            // Update Schedule
            $('#editScheduleForm').on('submit', function (e) {
                e.preventDefault();

                const scheduleId = $('#edit_schedule_id').val();
                const formData = $(this).serialize();

                $.ajax({
                    url: `/class-schedules/${scheduleId}`,
                    method: "PUT",
                    data: formData,
                    success: function (response) {
                        $('#editScheduleModal').modal('hide');
                        $('#editScheduleForm')[0].reset();
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function (response) {
                        alert('Error updating schedule');
                        console.error('Error Response:', response);
                        if (response.responseJSON && response.responseJSON.errors) {
                            console.log('Validation Errors:', response.responseJSON.errors);
                        }
                    }
                });
            });
        });


    </script>
@endsection
