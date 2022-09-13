@extends('layout.mainlayout')
@section('title','Staff Profile')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Staff Profile</h5>

        <!-- Default Tabs -->
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

</div><!-- End Default Tabs -->

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