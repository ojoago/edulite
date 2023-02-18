@extends('layout.mainlayout')
@section('title','Hiring School')
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
        margin-left: auto;
        margin-right: auto;
    }
</style>
<div class="container">
    <div class="row">
        <div class="card shadow-inner">
            <div class="card-header text-center">Click to any to Apply </div>
            <div class="card-body p-1">
                <div class="row">
                    @foreach($data as $row)
                    <div class="col-md-4 col-lg-3">
                        <a href="{{route('apply.school.job',[base64Encode($row->pid)])}}"> <!-- the pid here is job pid -->

                            <div class="card info-card ">
                                <div class="card-header text-center ellipsis-text"> {{$row->school_name}}</div>
                                <div class="card-body">
                                    <div class="shadow school-card">
                                        <img src="{{$row->school_logo ? asset('/files/logo/'.$row->school_logo) : asset('/files/thumbnail/teacher.jpeg')}}" alt="" class="school-image">
                                    </div>
                                    <div class="p-2">

                                        <h5 class="text-center text-uppercase h6">Subjects Area</h5>{{$row->subjects}}
                                        <br><small>Job Description: {{$row->note}}</small>
                                        <hr>
                                        <h6 class="h6 text-uppercase">
                                            <h5 class="text-uppercase h6">qualification: <small>{{$row->qualification ?? 'not required'}}</small> </h5>
                                            <hr>
                                            <h5 class="text-uppercase h6">experience: <small>{{$row->years ?? 'not required'}}</small></h5>
                                            <hr>
                                            <h5 class="text-uppercase h6">Field of study: <small>{{$row->course ?? 'not required'}}</small></h5>
                                        </h6>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <h6>Address: <small>{{$row->school_address}}</small> </h6>
                                    <hr>
                                    <h6>LGA: <small>{{$row->lga}}</small> </h6>
                                    <hr>
                                    <h6>State: <small>{{$row->state}}</small> </h6>
                                    <hr>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div><!-- End Sales Card -->
        </div>
    </div>
</div>



<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

@endsection