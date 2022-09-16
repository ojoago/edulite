@extends('layout.mainlayout')
@section('title','login')
@section('content')
<div class="album text-muted">
    <div class="container">
        <div class="row">
            <h1>This is a demo text</h1>
            <p>Dear parent, it is your duty to give your children the best education they deserve.</p>
        </div>
        <div class="col-12">
            <p class="small mb-0">Already have an account? <a href="{{route('login')}}">Create an account</a></p>
        </div>
    </div>
</div>
@endsection