@extends('layout.mainlayout')
@section('title','Sign Up')
@section('content')

<div class="card mb-3 ">
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Qiuck Sign Up</h5>
            <p class="text-center small">Enter your email, username & password to sign up</p>
        </div>
        <form class="row g-3 needs-validation" method="post">
            {!! (flashMessage())!!}
            @csrf
            <div class="mb-2">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" value="{{@old('email')}}" name="email" placeholder="Email Address">
                @error('email')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" value="{{@old('username')}}" name="username" placeholder="Username">
                @error('username')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="comfirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                @error('comfirmed')
                <p class="text-danger">{{$message}}</p>
                @enderror
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
@endsection