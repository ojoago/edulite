@extends('layout.mainlayout')
@section('title','Student List')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div id="profileImage"></div>
        </div>
    </div>
    <div class="col-md-8">
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
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="rider-tab" data-bs-toggle="tab" data-bs-target="#rider" type="button" role="tab">Rider/Care</button>
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
                        <table class="table table-hover table-striped table-bordered" id="classDataTable">
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
                        <table class="table table-hover table-striped table-bordered" id="resultDataTable">
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
                    <div class="tab-pane fade" id="rider" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered" id="riderDataTable">
                            <thead>
                                <tr>

                                    <th>S/N</th>
                                    <th>fullname</th>
                                    <th>gsm</th>
                                    <th>username</th>
                                    <th>address</th>
                                    <th>status</th>
                                    <th>date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div><!-- End Default Tabs -->

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

        loadProfile()

        function loadProfile() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('load.student.profile')}}",
                type: "post",
                data: {
                    pid: "{{$pid}}",
                    _token: "{{csrf_token()}}"
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

        $('#class-tab').click(function() {
            $('#classDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.student.class')}}",
                    data: {
                        pid: "{{$pid}}",
                        _token: "{{csrf_token()}}"
                    },
                },

                "columns": [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    // },
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

        $('#rider-tab').click(function() {
            $('#riderDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.student.riders')}}",
                    data: {
                        pid: "{{$pid}}",
                        _token: "{{csrf_token()}}"
                    },
                },

                "columns": [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "fullname"
                    },
                    {
                        "data": "gsm"
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "address"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "date"
                    },
                ],
            });
        });

    });
</script>
@endsection