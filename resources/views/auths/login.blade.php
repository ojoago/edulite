@extends('layout.mainlayout')
@section('title','login')
@section('content')
    <div class="container">
        <section class="section register min-vh-50 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
                                <img src="{{asset('themes/img/logo.png')}}" alt="">
                                <span class="d-none d-lg-block">EuLite</span>
                            </a>
                        </div><!-- End Logo -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                    <p class="text-center small">Enter your username & password to login</p>
                                </div>
                                <form class="row g-3 needs-validation" method="post">
                                    {!! (flashMessage())!!}
                                    @csrf
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Email address</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="email" class="form-control" id="email" name="email" value=" {{@old('email')}} " placeholder="Email">
                                            @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text bi bi-shield-lock-fill" id="inputGroupPrepend"></span>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                            @error('password')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Don't have account? <a href="{{route('sign.up')}}">Create an account</a></p>
                                    </div>
                                    <a class="pointer" data-bs-toggle="modal" data-bs-target="#forgetPwd">Forget Password</a>
                                </form>

                            </div>
                        </div>

                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                        </div>

                    </div>
                </div>
        </section>
    </div>
<!-- End #main -->
@endsection
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