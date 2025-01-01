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
                        <li class="breadcrumb-item active">Classes</li>
                    </ol>
                </div>
                <h4 class="page-title">Class Management</h4>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                                            <th>Class Description </th>
                                            <th>Class Teacher</th>
                                            <th>Class Students</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($classes as $class)
                                            <tr>
                                                <td>{{ $class->name }}</td>
                                                <td>{{ $class->code }}</td>
                                                <td>{{ $class->description }}</td>
                                                <td>{{ $class->teacher->name }}</td>
                                                <td>{{ $class->students->count() }}</td>
                                                <td>
                                                    <a href="{{ route('classes.edit', $class->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <a href="{{ route('classes.show', $class->id) }}"
                                                        class="btn btn-info">View</a>
                                                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
