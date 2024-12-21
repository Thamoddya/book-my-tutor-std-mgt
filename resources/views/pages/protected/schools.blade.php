@extends('layout.MainLayout')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">
                                #BookMyTutor
                            </a></li>
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

                <h4 class="fs-16">
                    All Schools
                </h4>
                <p class="text-muted fs-14">
                    All Schools are listed here. You can add new school, edit or delete existing school.
                </p>
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                    Add New School
                </button>

                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th> Name</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($schools as $school)
                            <tr>
                                <td>{{ $school->id }}</td>
                                <td>{{ $school->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-school-btn" data-id="{{ $school->id }}"
                                        data-name="{{ $school->name }}">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- end card -->
        </div><!-- end col-->
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


    <!-- Edit School Modal -->
    <div class="modal fade" id="editSchoolModal" tabindex="-1" aria-labelledby="editSchoolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editSchoolForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSchoolModalLabel">Edit School</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editSchoolName" class="form-label">School Name</label>
                            <input type="text" class="form-control" id="editSchoolName" name="name" required>
                            <input type="hidden" id="editSchoolId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const addSchoolForm = document.getElementById("addSchoolForm");
        addSchoolForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const formData = new FormData(addSchoolForm);

            fetch(addSchoolForm.action, { // Use the form's action attribute
                    method: "POST", // Ensure it matches the route method
                    body: formData,
                    headers: {
                        'Accept': 'application/json', // Ensure response is JSON
                    },
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to add school: " + response.statusText);
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        alert(data.success);
                        location.reload();
                    } else {
                        alert("An error occurred while adding the school.");
                    }
                })
                .catch((error) => console.error("Error:", error));
        });

        // Handle Edit Button Click
        document.querySelectorAll(".edit-school-btn").forEach((button) => {
            button.addEventListener("click", () => {
                const schoolId = button.getAttribute("data-id");
                const schoolName = button.getAttribute("data-name");

                document.getElementById("editSchoolId").value = schoolId;
                document.getElementById("editSchoolName").value = schoolName;

                new bootstrap.Modal(document.getElementById("editSchoolModal")).show();
            });
        });

        // Handle Edit School Form
        const editSchoolForm = document.getElementById("editSchoolForm");
        editSchoolForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const schoolId = document.getElementById("editSchoolId").value;
        const formData = new FormData(editSchoolForm);

        fetch(`/schools/${schoolId}`, {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                alert(data.success);
                location.reload();
            })
            .catch((error) => console.error("Error:", error));
        });
        });
    </script>
@endsection
