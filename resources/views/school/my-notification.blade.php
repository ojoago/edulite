@extends('layout.mainlayout')
@section('title','Notifications')
@section('content')

<section class="section d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Notification</h5>
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="teacherCommentTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Message</th>
                            <th>When (Time)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notification as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->message}}</td>
                            <td>{{$row->created_at->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</section>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

@endsection