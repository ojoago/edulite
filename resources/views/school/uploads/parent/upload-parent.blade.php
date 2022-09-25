@extends('layout.mainlayout')
@section('title','Upload Parents')
@section('content')
<div class="section min-vh-50 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="card justify-content-center shadow">
        <form class="row g-3 p-4" method="post">
            @csrf
            <div class="col-12">
                <p>Click on the button below to download template</p>
                <a href="{{asset('files/excel-template/parent-template.xlsx')}}"> <button class="btn btn-sm btn-success">download</button> </a>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">File</label>
                <input type="file" class="form-control form-control-sm" name="file">
                <p class="text-danger file_error"></p>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection