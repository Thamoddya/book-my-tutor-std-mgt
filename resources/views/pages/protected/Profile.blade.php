@extends('layout.MainLayout')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">#BookMyTutor</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Main</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile Management</h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Profile</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Image -->
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" id="profile_image" class="form-control">
                            @if(auth()->user()->profile_image)
                                <div class="mt-3">
                                    <img src="{{ asset('profile/' . auth()->user()->profile_image) }}"
                                         alt="Profile Image" class="img-thumbnail" width="150">
                                </div>
                            @endif
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ auth()->user()->name }}" required>
                        </div>

                        <!-- Email (Read-only) -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ auth()->user()->email }}" readonly>
                        </div>

                        <!-- NIC (Read-only) -->
                        <div class="mb-3">
                            <label for="nic" class="form-label">NIC</label>
                            <input type="text" name="nic" id="nic" class="form-control"
                                   value="{{ auth()->user()->nic }}" readonly>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                   value="{{ auth()->user()->phone }}" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3"
                                      required>{{ auth()->user()->address }}</textarea>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Leave blank if not changing">
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
