@extends('layout.mainlayout')
@section('title','Reset Password')
@section('content')
<section class="section register min-vh-50 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                    </div>
                    <form class="row g-3 needs-validation" method="post" action="{{route('reset.password')}}">
                        {!! (flashMessage())!!}
                        @csrf
                        <div class="col-12">
                            <label for="yourUsername" class="form-label">New Password</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text bi bi-lock"></span>
                                <input type="password" class="form-control" id="password" name="password" value="{{@old('password')}}" placeholder="password">
                            </div>
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Confirm Password</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text bi bi-shield-lock-fill" id="inputGroupPrepend"></span>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="password confirmation">
                            </div>
                                @error('confirm')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                        </div>


                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Reset</button>
                        </div>
                        <div class="col-12">
                            <p class="small mb-0">Already have an account? <a href="{{route('login')}}"> Login</a></p>
                        </div>
                    </form>

                </div>
            </div>



            <!-- End #main -->

            @endsection