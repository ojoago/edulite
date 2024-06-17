@extends('layout.mainlayout')
@section('title','eror 404')
@section('content')
<style>
    .section{
        width:50%;
    }
</style>
<div class="row justify-content-center">
    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
        <div class="section">
            <h5 class="card-title text-center pb-0 fs-4"></h5>
            <p class="text-center text-danger h5">You Hit the Wrong Spot</p>
            <p class="text-center">Follow the back door <a href="{{route('logout')}}"> <button class="btn btnsm btn-danger">Logout</button> </a> </p>
            <img src="{{asset('files/edulite/svg/monster 404 Error-amico.svg')}}" style="width:100%" alt="hero image" />
        </div>
    </div>
</div>

@endsection