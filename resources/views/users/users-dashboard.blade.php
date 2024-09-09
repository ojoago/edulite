@extends('layout.mainlayout')
@section('title','User Dashboard')
@section('content')

<style>
    .school-card {
        /* background:url("{{asset('/files/thumbnail/teacher.jpeg')}}");
        background-size: cover;
        background-repeat: no-repeat; */
        height: 200px;
        width: auto;
        padding-left: auto;
        padding-right: auto;
    }

    .school-image {
        height: 100%;
        display: block;
        width: auto;
        max-width: 99%;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<div class="container">
    <div class="pagetitle">
        <!-- <h1>Dashboard</h1> -->
        <nav>
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="index.html">Home</a></li> -->
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <!-- <a href="{{route('create.organisation')}}">create organisation</a><br> -->
    <h4 class="text-danger p-3">Click on the button below to create a school</h4>
    <a href="{{route('create.school')}}"> <button class="btn btn-success btn-sm">Create School</button></a>
    <h5>How to create a school <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#createSchoolVideoModal">Watch Video</button></h5>
    @if($data->isNotEmpty())
    <div class="row">
        <div class="card shadow-inner">
            <div class="card-header">Click to any school name to login </div>
            <div class="card-body p-1">
                <div class="row">
                    @foreach($data as $row)
                    <div class="col-md-3">
                        <a href="{{route('login.school',[base64Encode($row->pid),'role'=>$row->role])}}">
                            <div class="card-header text-center ellipsis-text small">Login as {{STAFF_ROLE[$row->role]}}</div>
                            <div class="card info-card ">
                                <div class="card-header text-center ellipsis-text"> {{$row->school_name}}</div>
                                <div class="card-body shadow school-card">
                                    <img src="{{$row->school_logo ? asset('/files/logo/'.$row->school_logo) : asset('/files/thumbnail/teacher.jpeg')}}" alt="" class="school-image">
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div><!-- End Sales Card -->
        </div>
    </div>
    @else
    <h3>Welcome to {{env('APP_NAME', APP_NAME)}},</h3>
    <p>The most simple, smart and easy to use school management software as service in Nigeria</p>
    {{-- <!-- <p class="text-danger"> Please click on the green button above to create your school </p> --> --}}
    @endif
</div>

</div>
</div>
</div>
</div>


<div class="modal fade" id="createSchoolVideoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info">How to create school</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe width="420" height="315" src="https://www.youtube.com/embed/FykOy8vwBkI">
                </iframe>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection