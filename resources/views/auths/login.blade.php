<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <form class="auth_form" method="post">
                {!! (flashMessage())!!}
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value=" {{@old('email')}} " placeholder="Email">
                    @error('email')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    @error('password')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" action="" class="btn action_btn">
                    Login
                </button>
                <a class="pointer" data-bs-toggle="modal" data-bs-target="#forgetPwd">Forget Password</a>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="forgetPwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content panel panel-default">
            <div class="modal-header panel-heading">
                <h5 class="modal-title" id="exampleModalLabel">Forget Password </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" id="updatePwdForm">
                <div id="updatePwdMsg"></div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        @csrf
                        <input type="email" name="email" placeholder="Enter Registered Email address" class="form-control input-sm" id='pwd' required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary pull-left btn-sm" id="rsetPwdBtn"><i class="fa fa-envelope"></i> Submit</button>
                    <button type="button" class="btn btn-danger btn-xs btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>

        </div>
    </div>
</div>