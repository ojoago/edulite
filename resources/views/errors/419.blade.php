@extends('layout.mainlayout')
@section('title','Page Expired')
@section('content')
<style>
    .section {
        width: 60%;
    }
</style>
<div class="row justify-content-center">
    <div class="col-sm-12 col-md-8 d-flex flex-column align-items-center justify-content-center">
        <p class="text-center h5 mt-4 text-uppercase">Page Expired due to inactivity</p>
        <div class="section ">
            <!-- <h5 class="card-title text-center pb-0 fs-4"></h5> -->
            <p class="text-center"><a href="{{route('logout')}}"> <button class="btn btnsm btn-primary">Back to login</button> </a> </p>
            <img src="{{asset('files/edulite/svg/refreshing-amico.svg')}}" style="width:100%" alt="hero image" />
        </div>
    </div>
</div>

@endsection