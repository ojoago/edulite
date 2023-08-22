@extends('layout.mainlayout')
@section('title','Sign Up')
@section('content')
<section class="section register min-vh-50 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12d-flex flex-column align-items-center justify-content-center">
            <div class="card mb-3 ">
                <div class="card-body">
                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Qiuck Sign Up</h5>
                        <p class="text-center small">Enter your email, username & password to sign up</p>
                    </div>
                    <form class="row g-3 needs-validation" method="post">
                        {!! (flashMessage())!!}
                        @csrf
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label for="email" class="form-label">Email address *</label>
                                <input type="email" class="form-control form-control-sm" id="email" value="{{@old('email')}}" name="email" placeholder="Email Address">
                                @error('email')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="email" class="form-label">Phone Number *</label>
                                <input type="text" class="form-control form-control-sm" id="gsm" value="{{@old('gsm')}}" maxlength="11" name="gsm" placeholder="Phone Number">
                                @error('gsm')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="name" class="form-label">Username *</label>
                                <input type="text" class="form-control form-control-sm" id="name" value="{{@old('username')}}" name="username" placeholder="enter your Username">
                                @error('username')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label for="firstname" class="form-label">First Name *</label>
                                <input type="text" class="form-control form-control-sm" id="firstname" value="{{@old('firstname')}}" name="firstname" placeholder="enter your firstname  here">
                                @error('firstname')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="email" class="form-label">Last Name *</label>
                                <input type="text" class="form-control form-control-sm" id="lastname" value="{{@old('lastname')}}" name="lastname" placeholder="enter last name here">
                                @error('lastname')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="name" class="form-label">Other Name</label>
                                <input type="text" class="form-control form-control-sm" id="name" value="{{@old('othername')}}" name="othername" placeholder="Other Name">
                                @error('othername')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label for="name" class="form-label">Address </label>
                                <textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Enter your address here">{{@old('address')}}</textarea>
                                @error('address')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password">
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="comfirm_password" class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                @error('comfirmed')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            Register
                        </button>
                        <div class="col-12">
                            <p class="small mb-0">Already have an account? <a href="{{route('login')}}"> Login</a></p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @endsection