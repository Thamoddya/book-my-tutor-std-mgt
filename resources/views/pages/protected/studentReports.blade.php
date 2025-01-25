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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                        <li class="breadcrumb-item active">Student</li>
                    </ol>
                </div>
                <h4 class="page-title">Student Reports</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-0">Student Reports</h4>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Batch</th>
                                    <th>Contact No</th>
                                    <th>Added By</th>
                                    <th>Registered Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($students as $student)
                                    <tr>
                                        <td>{{$student->reg_no}}</td>
                                        <td>{{$student->name}}</td>
                                        <td>{{$student->batch->name}}</td>
                                        <td>{{$student->call_no}}</td>
                                        <td>{{$student->user->name}}</td>
                                        <td>{{\Carbon\Carbon::parse($student->created_at)->format("d-M-Y")}}</td>
                                        <td>
                                            @if($student->status == 1)
                                                <span class="btn btn-primary">Active</span>
                                            @else
                                                <span class="btn btn-danger">Inactive</span>
                                            @endif
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

@endsection
@section('script')

@endsection
