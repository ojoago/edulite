@extends('layout.mainlayout')
@section('title','500 error')
@section('content')
<h1>500</h1>
<div class="col-12">
    <p class="small mb-0"><a href="{{route('login')}}">Refresh</a></p>
</div>
@endsection