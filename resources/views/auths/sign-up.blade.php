<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            {{flashMessage()}}
            <form class="auth_form" method="post">
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
                <button type="submit" class="btn action_btn">
                    Register
                </button>
            </form>
        </div>
    </div>
</div>
@EuLite We celebrate champion