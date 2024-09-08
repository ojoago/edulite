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

    <div class="col-md-6">
        <div class="card info-card sales-card">
            <a data-bs-toggle="tooltip" _title="View Staff Details">
                <div class="card-body">
                    <h5 class="card-title">Classes 
                            <i class="bi bi-house-fill"></i>

                    </h5>

                    <div class="d-flex align-items-center">
                       
                        <div class="ps-3"  style="height: 150px; overflow-y:scroll;width:100%">
                            @foreach ($data['class'] as $item)
                                <h6>{{$item->arm}}</h6>
                            @endforeach

                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="card info-card sales-card">
            <a data-bs-toggle="tooltip" _title="View Staff Details">
                <div class="card-body">
                    <h5 class="card-title">Subjects <i class="bi bi-book-half"></i></h5>

                    <div class="d-flex align-items-center">
                        <div class="ps-3"  style="height: 150px; overflow-y:scroll; width:100%">
                            @foreach ($data['subjects'] as $item)
                                <h6>{{$item->subject}} - {{$item->arm}}</h6>
                            @endforeach

                        </div>
                    </div>
                </div>
            </a>
        </div>

      

    </div>
    <!-- Customers Card -->
    <div class="col-md-6">
        <div class="card info-card">
           
            
            Todo
            <input name="" class="form-control form-control-sm" >
            <button class="btn btn-primary btn-sm" >Add</button>
        </div>

        <div class="row">
             <!-- Revenue Card -->
            <div class="col-md-6">
                <div class="card info-card">
                    <a href="{{route('school.student.list')}}" data-bs-toggle="tooltip" title="View Student Details">
                        <div class="card-body">
                            <h5 class="card-title">Assignments</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-house-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>0</h6>

                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div><!-- End Revenue Card -->
            <div class="col-md-6">

                {{-- <div class="card info-card sales-card">
                    <a data-bs-toggle="tooltip" title="View Staff Details">
                        <div class="card-body">
                            <h5 class="card-title">Sum </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>0</h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div> --}}

            </div><!-- End Sales Card -->
        </div>

    </div>
    


</div>


@endsection

<!-- <h1>education is light hence EduLite</h1> -->