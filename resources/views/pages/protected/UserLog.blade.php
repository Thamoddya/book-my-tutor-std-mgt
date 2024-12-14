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
                        <li class="breadcrumb-item active">Log</li>
                    </ol>
                </div>
                <h4 class="page-title">System Log</h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">

                <h4 class="fs-16">
                    System Log
                </h4>
                <p class="text-muted fs-14">
                    This page shows the system log of the system. This page is only accessible to the admin.
                </p>

                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Log ID</th>
                        <th>User ID</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Log Message</th>
                        <th>Log Type</th>
                        <th>Log Date</th>
                        <th>Status Code</th>
                        <th>Route</th>

                    </tr>
                    </thead>

                    <tbody>

                    @foreach($logs as $log)
                        <tr>
                            <td>{{$log->id}}</td>
                            <td>{{$log->user_id}}</td>
                            <td>{{$log->ip_address}}</td>
                            <td>{{$log->user_agent}}</td>
                            <td>{{$log->response_message}}</td>
                            <td>{{$log->action}}</td>
                            <td>{{\Carbon\Carbon::parse($log->created_at)->format("d-M-Y")}}</td>
                            <td>{{$log->status_code}}</td>
                            <td>{{$log->route}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

@endsection
