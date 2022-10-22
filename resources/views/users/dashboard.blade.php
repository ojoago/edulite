@extends('layout.mainlayout')
@section('title','User Dashboard')
@section('content')
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
    <a href="{{route('create.school')}}">create School</a><br>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-inner">
                <div class="card-header">School You Work</div>
                <div class="card-body p-1">
                    <div class="row">
                        @foreach($data as $row)
                        <div class="col-md-6">
                            <a href="{{route('login.school',[base64Encode($row->pid)])}}">
                                <div class="card info-card sales-card">
                                    <div class="card-body shadow">
                                        <h5 class="card-title">Click to login </span></h5>
                                        <div class="d-flex align-items-center">
                                            {{$row->school_name}}
                                            </span>
                                        </div>
                            </a>
                        </div>
                    </div>
                </div><!-- End Sales Card -->
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card shadow">
        <div class="card-header">
            School You Created --- Config
        </div>
        <div class="card-body shadow p-1">
            <div class="row">
                @foreach($data as $row)
                <div class="col-md-6">
                    <a href="{{route('login.school',[base64Encode($row->pid)])}}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Click to login</h5>
                                <div class="d-flex align-items-center">
                                    {{$row->school_name}}
                                    </span>
                                </div>
                    </a>
                </div>
            </div>
        </div><!-- End Sales Card -->
        @endforeach
    </div>
</div>
</div>
</div>
</div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

@endsection