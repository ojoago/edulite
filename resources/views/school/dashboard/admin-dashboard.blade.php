@extends('layout.mainlayout')
@section('title','admin dashboard')
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Admin Dashboard</li>
            <li class="bg-danger p-2 text-white m-1"> You are runnig {{activeTermName() ?? 'Active Term not set'}} | {{activeSessionName() ?? 'Active Session not Set'}} Remember!!!</li>
        </ol>
    </nav>
</div>
<div class="row">

    <!-- Sales Card -->
    <div class="col-md-3">
        <div class="card info-card sales-card">
            <a href="{{ route('school.staff.list') }}" data-bs-toggle="tooltip" title="View Staff Details">
                <div class="card-body">
                    <h5 class="card-title">Active <span>| Staff</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{$data['staff']}}</h6>
                            <!-- <span class="text-success small pt-1 fw-bold">Active</span> -->
                            <!-- <span class="text-muted small pt-2 ps-1">increase</span> -->

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div><!-- End Sales Card -->

    <!-- Revenue Card -->
    <div class="col-md-3">
        <div class="card info-card">
            <a href="{{route('school.student.list')}}" data-bs-toggle="tooltip" title="View Student Details">
                <div class="card-body">
                    <h5 class="card-title">Active <span>Student</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{$data['students']}}</h6>
                            <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div><!-- End Revenue Card -->

    <!-- Customers Card -->
    <div class="col-md-3">
        <div class="card info-card">
            <a href="{{route('school.parent.list')}}" data-bs-toggle="tooltip" title="View Parent Details">
                <div class="card-body">
                    <h5 class="card-title">Active <span>| Parent</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{$data['parents']}}</h6>
                            <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                        </div>
                    </div>

                </div>
            </a>
        </div>

    </div>
    <div class="col-md-3">
        <div class="card info-card">
            <a href="{{route('school.rider.list')}}" data-bs-toggle="tooltip" title="View Details">
                <div class="card-body">
                    <h5 class="card-title">Active <span>| Care/Rider</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-bicycle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{$data['riders']}}</h6>
                            <span class="text-danger small pt-1 bi:x-lg">
                                <!-- 12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                        </div>
                    </div>

                </div>
            </a>
        </div>

    </div>


</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

@endsection

<!-- <h1>education is light hence EduLite</h1> -->