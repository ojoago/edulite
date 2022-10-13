@extends('layout.mainlayout')
@section('title','Parent/Guardian Profile')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center text-info">Parent/Guardian Profile</h5>

        <div class="row p-4">
            <div class="col-md-6">
                <div class="text-center">
                    <img src="{{asset('/files/images/'.$data->passport.'')}}" class="img img-responsive img-circle" style="width:100%;height:auto">
                </div>
            </div>
            <div class="col-md-6">
                <div class="">
                    Name: <span> {{$data->title }} </span> {{ $data->fullname}}
                    <hr>
                    Username: {{ $data->username }}
                    <hr>
                    Email: {{ $data->email }}
                    <hr>
                    Students : {{ $data->wardCount() }}
                    <a href="{{route('school.parent.child',['id'=>base64Encode($data->pid)])}}">View Wards</a>
                    <hr>
                    Date of Birth: {{ $data->dob }}
                    <hr>
                    Gender: {{ matchGender($data->gender) }}
                    <hr>
                    Religion: {{ matchReligion($data->religion) }}
                    <hr>
                    Address: {{ $data->address }}
                    <hr>
                    Status: {{ matchAccountStatus($data->status) }}

                </div>

            </div>
        </div>
        '

    </div><!-- End Default Tabs -->

</div>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

@endsection