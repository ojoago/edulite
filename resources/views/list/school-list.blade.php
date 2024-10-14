
@extends('layout.mainlayout')
@section('title','List of School')
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
    <a href="{{route('users.list')}}">Users</a><br>
    <div class="card shadow-inner">
        <div class="card-header">List of Schools</div>
        <div class="card-body p-1">
            <div class="row">
                @foreach($data as $row)
                <div class="col-md-6">
                    {{-- {{route('login.school',[base64Encode($row->pid)])}} --}}
                    <a href="#">
                        <div class="card info-card sales-card">
                            <div class="card-body shadow">
                                {{-- <h5 class="card-title">Click to login </h5> --}}

                                <div class="d-flex align-items-center">
                                    {{$row->school_name}}
                                </div>

                                <p class="bg-info p-2 text-white">Status:<small>{{SETUP_STATUS[$row->status]}}</small></p>
                                <p><small>{{$row->school_email}}</small></p>
                                <p><small>{{$row->school_contact}}</small></p>
                                <p><small>{{$row->school_address}}</small></p>
                            </div>
                    </a>
                </div>
            </div>
            @endforeach
            <div class="d-flex justify-content-center">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
</div>

</div>
</div>
</div>
</div>

@endsection
