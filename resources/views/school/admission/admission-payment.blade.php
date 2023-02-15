@extends('layout.mainlayout')
@section('title','Student Admission Payment')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="pull-right"><a href="{{route('school.admission')}}">New Application</a></div>
        <h5 class="card-title text-center">{{activeSessionName()}} Applicant Admission
        </h5>
        <!-- Multi Columns Form -->
        <div class="section  min-vh-50 d-flex flex-column align-items-center justify-content-center py-4">

            @if(!empty($data))
            <div class="card-body shadow">
                <div class="text-center">
                    <img src="{{ asset('/files/images/' . $data->passport)}}" class="img img-responsive">
                </div>
                <h3 class="card-title">Name: {{$data->fullname}}</h3>
                <hr>
                Admission No.: {{$data->admission_number}}
                @if($data->status ==1 || $data->status ==0)
                <a href="{{route('edit.admission',['id'=>base64Encode($data->pid)])}}"><button class="btn btn-sm btn-warning text-center text-white" title="Edit Admission" data-bs-toggle="tooltip"><i class="bi bi-pencil-fill"></i> Edit</button></a>
                @endif
                <hr>
                Status: <b>{{matchSchoolAdmissionStatus($data->status)}}</b>
                <hr>
                Admission Fee: {{number_format($data->amount)}}
                @if($data->status ==0)
                @if($data->amount>0)
                <button class="btn btn-sm btn-info text-center text-white" title="Pay Admission Fee" data-bs-toggle="tooltip"><i class="bi bi-credit-card-fill"></i> Pay</button>
                @endif
                @endif
                <hr>
                Date of Birth: {{$data->dob}}
                <hr>
                Gender: {{matchGender($data->gender)}}
                <hr>
                Religion: {{ matchReligion($data->religion)}}
                <hr>
                Contact Person: {{$data->contact_person}}
                <hr>
                Contact GSM: {{$data->contact_gsm}}
                <hr>
                Contact Email: {{$data->contact_email}}
            </div>
            @else
            <div class="card-body shadow">
                <div class="text-center">
                    Data not loaded correctly
                </div>

            </div>
            @endif()

        </div>

        <!-- End Multi Columns Form -->
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

    });
</script>
@endsection