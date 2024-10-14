@extends('layout.mainlayout')
@section('title','User Dashboard')
@section('content')
<div class="container">
    <div class="pagetitle">
        <!-- <h1>Dashboard</h1> -->
        <nav>
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="index.html">Home</a></li> -->
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">User</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>GSM</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->username}}</td>
                            <td>{{$row->gsm}}</td>
                            <td>{{ACCOUNT_STATUS[$row->account_status]}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->code}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection