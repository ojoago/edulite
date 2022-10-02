@extends('layout.mainlayout')
@section('title','eror 419')
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
            <p class="text-center text-warning">Page Expired due to inactivity</p>
            <img src="{{asset('files/edulite/svg/refreshing-amico.svg')}}" style="width:100%" alt="hero image" />
            <p class="text-center"><a href="{{route('logout')}}"> <button class="btn btnsm btn-primary">Refresh</button> </a> </p>
        </div>
    </div>
</div>

@endsection