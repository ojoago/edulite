@extends('layout.mainlayout')
@section('title','Student List')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Profile</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">Attendance</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-tab" data-bs-toggle="tab" data-bs-target="#class" type="button" role="tab">Classes</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="results-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab">Result</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="activeStudent-tab">
                <div id="profileDetail"></div>
            </div>
            <div class="tab-pane fade" id="attendance" role="tabpanel">
                <input type="date" name="" class="form-control form-control-sm" onkeydown="return false" id="">
            </div>
            <div class="tab-pane fade" id="class" role="tabpanel">
                <table class="table table-hover table-responsive table-striped table-bordered" id="classDataTable">
                    <thead>
                        <tr>

                            <th>Class</th>
                            <th>Session</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="results" role="tabpanel">
                <table class="table table-hover table-responsive table-striped table-bordered" id="resultDataTable">
                    <thead>
                        <tr>

                            <th>S/N</th>
                            <th>Position</th>
                            <th>Total</th>
                            <th>Average</th>
                            <th>Subjects</th>
                            <th>view</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
        let token = "{{csrf_token()}}"

        loadProfile(pid)

        function loadProfile(pid) {
            $('.overlay').show();
            $.ajax({
                url: "{{route('load.student.profile')}}",
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

        $('#classDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": {
                method: "POST",
                url: "{{route('load.student.class')}}",
                data: {
                    pid: pid,
                    _token: token
                },
            },

            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    "data": "arm"
                },
                {
                    "data": "session"
                },
                {
                    "data": "date"
                },
            ],
        });


    });
</script>
@endsection