@extends('layout.mainlayout')
@section('title','Staff Profile')
@section('content')
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                <h2>Kevin Anderson</h2>
                <h3>Web Designer</h3>
                <div class="social-links mt-2">
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body pt-3">
                <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
                    </li>

                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#classes" type="button" role="tab">Classes</button>
                    </li>

                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#subject" type="button" role="tab">Subjects</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#role" type="button">Roles</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="myTabjustifiedContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile">
                        <div id="profileDetail"></div>
                    </div>
                    <div class="tab-pane fade" id="classes" role="tabpanel" aria-labelledby="classes">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="session" class="form-label">Session</label>
                                <select type="text" name="session" class="form-control" id="formSessionSelect2">
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="term" class="form-label">Term</label>
                                <select type="text" name="term" class="form-control" id="formTermSelect2">

                                </select>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="session" class="form-label">Session</label>
                                <select type="text" name="session" class="form-control" id="formSessionSelect2">
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="term" class="form-label">Term</label>
                                <select type="text" name="term" class="form-control" id="formTermSelect2">

                                </select>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="role">
                        R
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        let term = "{{activeTerm()}}"
        let session = "{{activeSession()}}"
        FormMultiSelect2('#formTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#formSessionSelect2', 'session', 'Select Session', session)

        let pid = "{{$pid}}"
        loadProfile(pid)

        function loadProfile(pid) {
            let token = "{{csrf_token()}}"
            $('.overlay').show();
            $.ajax({
                url: "{{route('load.staff.profile')}}",
                type: "post",
                data: {
                    pid: pid,
                    _token: token
                },
                success: function(data) {
                    $('#profileDetail').html(data)
                    $('.overlay').hide();
                },
                error: function() {
                    $('#profileDetail').html('')
                    $('.overlay').hide();
                }
            });
        }

    });
</script>
@endsection