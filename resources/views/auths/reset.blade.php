@extends('layout.mainlayout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <form class="auth_form" action="{{route('reset')}}" method="post">
                {!! (flashMessage())!!}
                @csrf
                <div class="form-group mb-2">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group">
                        <i class=" fas fa-lock-open bg-danger text-light p-2 input-group-append"></i>
                        <input type="password" name="password" placeholder="new password" class="form-control input-sm" id='pwd' required>
                    </div>
                    @error('password')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <i class=" fas fa-keyboard bg-danger text-light p-2 input-group-append"></i>
                        <input type="password" name="password_confirmation" placeholder="confirm password" class="form-control input-sm" id='pwd' required>
                    </div>
                    @error('password_confirmation')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" action="" class="btn action_btn">
                    <i class="fa fa-edit"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection