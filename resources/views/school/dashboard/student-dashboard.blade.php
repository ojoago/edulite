@extends('layout.mainlayout')
@section('title','Student Dashboard')
@section('content')
<div class="container">
    <div class="pagetitle">
        <h1>Dashboard</h1> 
        <nav>
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="index.html">Home</a></li> -->
                {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Attendance</div>
                <div class="card-body p-1">
                        <small class="h6">Present: {{$attendance->present}}</small> <br>
                        <div class="d-flex align-items-center">
                            <small class="h6">Absent: {{$attendance->absent}}</small> &nbsp; 
                            <small class="h6">Excused: {{$attendance->excused}}</small>

                            </span>
                        </div>
                </div>
            </div>
        </div>
       
       
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Result</div>
                <div class="card-body p-1">
                    <a href="#">
                        <h5 class="card-title"> {{$result}}</span></h5>
                        <div class="d-flex align-items-center">
                            
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
       
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Invoice</div>
                <div class="card-body p-1">
                    <a href="#">
                        <h5 class="card-title">{{$invoices}}</span></h5>
                        <div class="d-flex align-items-center">

                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
       
    </div>

</div>
</div>

@endsection
