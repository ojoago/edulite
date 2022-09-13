@extends('layout.mainlayout')
@section('title','My Wards')
@section('content')

<div class="card">
    <div class="card-body shadow">
        @if(!$data->isEmpty())
        
        <h5 class="card-title text-success">Parent/Guardian Ward(s)</h5>
        <a class="text-center h4" href="{{route('school.parent.profile',['id'=>base64Encode($data[0]->parent_pid)])}}">Parent/Guardian Profile</a>
        <div class="row">
            @foreach($data as $row)
            <div class="col-md-4 ">
                <div class="card shadow p-4" style="height: 600px;">
                    <a href="http://" target="_blank" rel="noopener noreferrer">
                        <div class="text-center" style="height:150px;">
                            <img src="{{asset('/files/images/'.$row->passport.'')}}" class="img img-responsive img-circle" style="width:auto;height:100%">
                        </div>
                        <h3 class="card-title text-center"> {{$row->fullname}}</h3>
                    </a>
                    <hr>
                    REG: {{$row->reg_number}}
                    <hr>
                    Class: {{$row->arm}} | {{$row->session}} | {{matchStudentStatus($row->status)}}
                    <hr>
                    Username: {{$row->username}}
                    <hr>
                    Date of Birth: {{$row->dob}}
                    <hr>
                    Gender: {{matchGender($row->gender)}}
                    <hr>
                    Religion: {{matchReligion($row->religion)}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <h5 class="card-title text-center text-info">NO Child/Ward Associated with Acoount</h5>

    @endif
</div>
</div>

@endsection