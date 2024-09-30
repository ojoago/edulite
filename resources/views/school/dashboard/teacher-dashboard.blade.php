@extends('layout.mainlayout')
@section('title','principal dashboard')
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Teacher Dashboard</li>
            
        </ol>
    </nav>
</div>
<div class="row">
<a class="nav-link " href="{{route('self.attendance')}}">
              <i class="bi bi-grid"></i>
              <span>Take Attendance</span>
            </a>

    <div class="col-md-6">
        <div class="row">
            <!-- Sales Card -->
            <div class="col-md-6">
                <div class="card info-card sales-card">
                    <a data-bs-toggle="tooltip" title="View Staff Details">
                        <div class="card-body">
                            <h5 class="card-title">Subjects </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$data['staff']}}</h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            {{-- <div class="col-md-6">
                <div class="card info-card">
                    <a href="#" data-bs-toggle="tooltip" title="View Student Details">
                        <div class="card-body">
                            <h5 class="card-title">Classe Class</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-house-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$data['students']}}</h6>

                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div><!-- End Revenue Card --> --}}

            {{-- <div class="col-md-6">
                <div class="card info-card sales-card">
                    <a data-bs-toggle="tooltip" title="View Staff Details">
                        <div class="card-body">
                            <h5 class="card-title">Assignments </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div class="ps-3">
                                     <h6>3</h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div><!-- End Sales Card --> --}}

            <!-- Revenue Card -->
            <div class="col-md-6">
                <div class="card info-card">
                    <a href="#" data-bs-toggle="tooltip" title="View Student Details">
                        <div class="card-body">
                            <h5 class="card-title">Assignments</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-house-fill"></i>
                                </div>
                                <div class="ps-3">
                                    {{-- <h6>13</h6> --}}

                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div><!-- End Revenue Card -->
        </div>
    </div>
    <!-- Customers Card -->
    <div class="col-md-6">
        <div class="card info-card">
           
            
            Todo
            <input name="" class="form-control form-control-sm" >
            <button class="btn btn-primary btn-sm" >Add</button>
        </div>

    </div>
    


</div>


@endsection

<!-- <h1>education is light hence EduLite</h1> -->