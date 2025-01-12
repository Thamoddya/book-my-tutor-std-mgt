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
                <h4 class="page-title">Class Schedule</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Class Schedule</h4>
                    <p class="text-muted font-13 mb-4">
                        This is the list of all classes and their schedules.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

    </div>


    {{-- Add Class Schedule --}}
    
@endsection
