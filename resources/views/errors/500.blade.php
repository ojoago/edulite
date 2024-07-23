@extends('layout.mainlayout')
@section('title','error 500')
@section('content')
<style>
    .section {
        width: 50%;
    }
</style>
<div class="row justify-content-center">
    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
        <div class="section">
            <h5 class="card-title text-center pb-0 fs-4"></h5>
            <p class="text-center text-error">Something Went Wrong</p>
            <p class="text-center"><a href="{{route('logout')}}"> <button class="btn btnsm btn-danger">Logout</button> </a> </p>
            <img src="{{asset('files/edulite/svg/500 Internal Server Error-pana.svg')}}" style="width:100%" alt="hero image" />
        </div>
    </div>
</div>

@endsection