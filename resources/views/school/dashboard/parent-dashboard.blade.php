@extends('layout.mainlayout')
@section('title','Parent dashboard')
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Parent Dashboard</li>
        </ol>
    </nav>
</div>
<div class="container">
    @if(isNotEmpty())
    <div class="row">
        @foreach($data as $row)
        <div class="col-md-4 ">
            <a href="http://" target="_blank" rel="noopener noreferrer">
                <div class="card shadow p-4" style="height: 420px;">
                    <div class="text-center" style="height:150px;">
                        <img src="{{asset('/files/images/'.$row->passport.'')}}" class="img img-responsive img-circle" style="width:auto;height:100%">
                    </div>
                    <h3 class="card-title text-center"> {{$row->fullname}}</h3>
                    REG: {{$row->reg_number}}
                    <hr>
                    Class: {{$row->arm}} | {{matchStudentStatus($row->status)}}
                    <hr>
                    {{$row->session}}

                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <h3 class="bg-info">No Student is linked you Currently, please contact the school to link your ward(s)/child(ren)... </h3>
    @endif
</div>
@endsection