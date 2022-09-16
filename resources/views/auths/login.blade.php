@extends('layout.mainlayout')
@section('title','login')
@section('content')

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


<!-- End #main -->

<div class="modal fade" id="forgetPwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content panel panel-default">
            <div class="modal-header panel-heading">
                <h5 class="modal-title" id="exampleModalLabel">Forget Password </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" id="forgetPwdForm">
                <div id="updatePwdMsg"></div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        @csrf
                        <input type="email" name="email" placeholder="Enter Registered Email address" class="form-control input-sm" id='pwd' required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary pull-left btn-sm" id="resetPwdBtn"><i class="fa fa-envelope"></i> Submit</button>
                    <button type="button" class="btn btn-danger btn-xs btn-sm" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#resetPwdBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('reset')}}",
                type: "POST",
                data: new FormData($('#forgetPwdForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#' + formId).find('p.text-danger').text('');
                    $('#' + btnId).prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#' + btnId).prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 1) {
                        successClearForm(formId, data.message)
                        alert_toast(data.message, 'success');
                        $('#' + formId)[0].reset();

                    } else {
                        alert_toast(data.message, 'error');
                    }
                },
                error: function(data) {
                    $('#' + btnId).prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });

        });



    })
</script>
@endsection