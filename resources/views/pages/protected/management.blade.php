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
                        <li class="breadcrumb-item active">Managers</li>
                    </ol>
                </div>
                <h4 class="page-title">Page Management</h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h4 class="fs-16">
                    All Management Officers
                </h4>
                <p class="text-muted fs-14">
                    List of all management officers in the system.
                </p>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
                    Register New Management Officer
                </button>

                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($managementOfficers as $manager)
                        <tr>
                            <td>{{ $manager->id }}</td>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->email }}</td>
                            <td>{{ $manager->nic }}</td>
                            <td>{{ $manager->phone }}</td>
                            <td>
                            <span
                                class="badge {{ $manager->status ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">
                                {{ $manager->status ? 'Active' : 'Inactive' }}
                            </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm"
                                        onclick="openUpdateModal({{ $manager }})">
                                    Edit
                                </button>
                                @if($manager->status)
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="openDeactivateModal({{ $manager->id }})">
                                        Deactivate
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="openActivateModal({{ $manager->id }})">
                                        Activate
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="addUserModalLabel">
                        Register New Management Officer
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="officerName" class="form-label">Officer Name</label>
                        <input type="text" id="officerName" class="form-control">
                        <div class="invalid-feedback" id="officerNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="officerEmail" class="form-label ">Officer Email</label>
                        <input type="email" id="officerEmail" class="form-control">
                        <div class="invalid-feedback" id="officerEmailError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="officerAddress" class="form-label ">Officer Address</label>
                        <input type="text" id="officerAddress" class="form-control">
                        <div class="invalid-feedback" id="officerAddressError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="officerNIC" class="form-label ">Officer NIC</label>
                        <input type="text" id="officerNIC" class="form-control">
                        <div class="invalid-feedback" id="officerNICError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="officerPhone" class="form-label ">Officer Phone</label>
                        <input type="text" id="officerPhone" class="form-control">
                        <div class="invalid-feedback" id="officerPhoneError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="officerPassword" class="form-label ">Officer Password</label>
                        <input type="password" id="officerPassword" class="form-control">
                        <div class="invalid-feedback" id="officerPasswordError"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addUserProcess()">
                        Submit Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div id="updateUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-warning">
                    <h4 class="modal-title" id="updateUserModalLabel">Update Management Officer</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateUserId">
                    <div class="mb-3">
                        <label for="updateOfficerName" class="form-label">Name</label>
                        <input type="text" id="updateOfficerName" class="form-control">
                        <div class="invalid-feedback" id="updateOfficerNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfficerEmail" class="form-label">Email</label>
                        <input type="email" id="updateOfficerEmail" class="form-control">
                        <div class="invalid-feedback" id="updateOfficerEmailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfficerNIC" class="form-label">NIC</label>
                        <input type="text" id="updateOfficerNIC" class="form-control">
                        <div class="invalid-feedback" id="updateOfficerNICError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfficerPhone" class="form-label">Phone</label>
                        <input type="text" id="updateOfficerPhone" class="form-control">
                        <div class="invalid-feedback" id="updateOfficerPhoneError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfficerAddress" class="form-label">Address</label>
                        <input type="text" id="updateOfficerAddress" class="form-control">
                        <div class="invalid-feedback" id="updateOfficerAddressError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="updateOfficerPassword" class="form-label">New Password (Optional)</label>
                        <input type="password" id="updateOfficerPassword" class="form-control">
                        <div class="invalid-feedback" id="updateOfficerPasswordError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" onclick="updateUserProcess()">Update</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Deactivate Confirmation Modal -->
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deactivateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <h4 class="modal-title" id="deactivateModalLabel">Deactivate Management Officer</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to deactivate this management officer?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="deactivateUserId">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deactivateUserProcess()">Deactivate</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Confirmation Modal -->

    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="activateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success">
                    <h4 class="modal-title" id="activateModalLabel">Activate Management Officer</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <p>Are you sure you want to activate this management officer?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="deactivateUserId">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="activateUserProcess()">Activate</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function addUserProcess() {
            // Collect data from the form inputs
            const officerName = $("#officerName").val();
            const officerEmail = $("#officerEmail").val();
            const officerNIC = $("#officerNIC").val();
            const officerPhone = $("#officerPhone").val();
            const officerPassword = $("#officerPassword").val();
            const officerAddress = $("#officerAddress").val();

            // Clear previous error messages
            $(".invalid-feedback").text("").removeClass("d-block");

            // Send AJAX POST request
            $.ajax({
                url: "{{ route('store-management-officer-process') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    name: officerName,
                    email: officerEmail,
                    nic: officerNIC,
                    phone: officerPhone,
                    password: officerPassword,
                    address: officerAddress,
                },
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    $("#addUserModal").modal("hide");
                    location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $("#officerNameError").text(errors.name[0]).addClass("d-block");
                        }
                        if (errors.email) {
                            $("#officerEmailError").text(errors.email[0]).addClass("d-block");
                        }
                        if (errors.nic) {
                            $("#officerNICError").text(errors.nic[0]).addClass("d-block");
                        }
                        if (errors.phone) {
                            $("#officerPhoneError").text(errors.phone[0]).addClass("d-block");
                        }
                        if (errors.password) {
                            $("#officerPasswordError").text(errors.password[0]).addClass("d-block");
                        }
                        if (errors.address) {
                            $("#officerAddressError").text(errors.address[0]).addClass("d-block");
                        }
                    } else {
                        alert("An unexpected error occurred. Please try again.");
                    }
                },
            });
        }

        function openUpdateModal(manager) {
            $("#updateUserId").val(manager.id);
            $("#updateOfficerName").val(manager.name);
            $("#updateOfficerEmail").val(manager.email);
            $("#updateOfficerNIC").val(manager.nic);
            $("#updateOfficerPhone").val(manager.phone);
            $("#updateOfficerAddress").val(manager.address);

            $("#updateUserModal").modal("show");
        }

        function updateUserProcess() {
            const id = $("#updateUserId").val();
            const name = $("#updateOfficerName").val();
            const email = $("#updateOfficerEmail").val();
            const nic = $("#updateOfficerNIC").val();
            const phone = $("#updateOfficerPhone").val();
            const address = $("#updateOfficerAddress").val();
            const password = $("#updateOfficerPassword").val();

            $(".invalid-feedback").text("").removeClass("d-block");

            $.ajax({
                url: `/management-officers/${id}/update`,
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {name, email, nic, phone, address, password},
                success: function (response) {
                    alert(response.message);
                    $("#updateUserModal").modal("hide");
                    location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.name) $("#updateOfficerNameError").text(errors.name[0]).addClass("d-block");
                        if (errors.nic) $("#updateOfficerNICError").text(errors.nic[0]).addClass("d-block");
                        if (errors.email) $("#updateOfficerEmailError").text(errors.email[0]).addClass("d-block");
                        if (errors.phone) $("#updateOfficerPhoneError").text(errors.phone[0]).addClass("d-block");
                        if (errors.address) $("#updateOfficerAddressError").text(errors.address[0]).addClass("d-block");
                        if (errors.password) $("#updateOfficerPasswordError").text(errors.password[0]).addClass("d-block");
                    } else {
                        alert("Unexpected error. Please try again.");
                    }
                },
            });
        }

        // Open Deactivate Modal
        function openDeactivateModal(userId) {
            $("#deactivateUserId").val(userId);
            $("#deactivateModal").modal("show");
        }

        // Deactivate User Process
        function deactivateUserProcess() {
            const id = $("#deactivateUserId").val();

            $.ajax({
                url: `/management-officers/${id}/deactivate`,
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    alert(response.message);
                    $("#deactivateModal").modal("hide");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Unexpected error. Please try again.");
                },
            });
        }

        // Open Activate Modal
        function openActivateModal(userId) {
            $("#deactivateUserId").val(userId);
            $("#activateModal").modal("show");
        }

        function activateUserProcess() {
            const id = $("#deactivateUserId").val();

            $.ajax({
                url: `/management-officers/${id}/activate`,
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    alert(response.message);
                    $("#deactivateModal").modal("hide");
                    location.reload();
                },
                error: function (xhr) {
                    console.log(xhr);
                    alert("Unexpected error. Please try again.");
                },
            });
        }
    </script>

@endsection
