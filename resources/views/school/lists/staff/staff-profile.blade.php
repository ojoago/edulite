@extends('layout.mainlayout')
@section('title','Staff Profile')
@section('content')
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div id="profileImage"></div>
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

                    {{-- <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#role" type="button">Roles</button>
                    </li> --}}

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
                        <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="staffClassTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th>Class</th>
                                    <th>Session</th>
                                    <th>Term</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="session" class="form-label">Session</label>
                                <select type="text" name="session" class="form-control" id="formSubjectSessionSelect2">
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="term" class="form-label">Term</label>
                                <select type="text" name="term" class="form-control" id="formSubjectTermSelect2">

                                </select>
                            </div>
                        </div>
                        <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="staffSubjectTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th>Class Subject</th>
                                    <th>Session</th>
                                    <th>Term</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
        // class 
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
                    $('#profileImage').html(data.image)
                    $('#profileDetail').html(data.info)
                    $('.overlay').hide();
                },
                error: function() {
                    $('#profileDetail').html('')
                    $('.overlay').hide();
                }
            });
        }

        loadClasses(pid)
        // on change term 
        $('#formTermSelect2').change(function() {
            let term = $(this).val();
            let session = $('#formSessionSelect2').val();
            loadClasses(pid, session, term)
        });
        //  on change session 
        $('#formSessionSelect2').change(function() {
            let session = $(this).val();
            let term = $('#formTermSelect2').val();
            loadClasses(pid, session, term)
        });

        function loadClasses(pid = null, session = null, term = null) { //cls class
            $('#staffClassTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.staff.classes')}}",
                    data: {
                        pid: pid,
                        session: session,
                        term: term,
                        _token: "{{csrf_token()}}",
                    },
                    type: "post",
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "arm"
                    },
                    {
                        "data": "session"
                    },
                    {
                        "data": "term"
                    },
                    {
                        "data": "date"
                    },

                ],
            });
        }


        FormMultiSelect2('#formSubjectTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#formSubjectSessionSelect2', 'session', 'Select Session', session)

        // load staff subject 
        loadStaffSubject(pid)
        // staff subjects 
        function loadStaffSubject(pid = null, session = null, term = null) { //cls class
            $('#staffSubjectTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.staff.subjects')}}",
                    data: {
                        pid: pid,
                        session: session,
                        term: term,
                        _token: "{{csrf_token()}}",
                    },
                    type: "post",
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "staff_subject"
                    },
                    {
                        "data": "session"
                    },
                    {
                        "data": "term"
                    },
                    {
                        "data": "date"
                    },

                ],
            });
        }

    });
</script>
@endsection