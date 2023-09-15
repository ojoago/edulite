@extends('layout.mainlayout')
@section('title','Student Profile')
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div id="profileImage"></div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Student Profile</h5>

                <!-- Default Tabs -->
                <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
                    </li>
                    
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="class-tab" data-bs-toggle="tab" data-bs-target="#class" type="button" role="tab">Classes</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="rider-tab" data-bs-toggle="tab" data-bs-target="#rider" type="button" role="tab">Rider/Care</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="myTabjustifiedContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="activeStudent-tab">
                        <div id="profileDetail"></div>
                    </div>
                    <div class="tab-pane fade" id="class" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered cardTable" id="classDataTable">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Session</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="rider" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered cardTable" id="riderDataTable">
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

<script>
    $(document).ready(function() {

        loadProfile()

        function loadProfile() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('load.student.profile')}}",
                type: "post",
                data: {
                    pid: "{{studentPid()}}",
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

                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.student.class')}}",
                    data: {
                        pid: "{{studentPid()}}",
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
                   
                ],
            });
        });
       

        $('#results-tab').click(function() {
            $('#resultDataTable').DataTable({
                "processing": true,
                "serverSide": true,

                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.student.result')}}",
                    data: {
                        pid: "{{studentPid()}}",
                        _token: "{{csrf_token()}}"
                    },
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "position"
                    },
                    {
                        "data": "total"
                    },
                    {
                        "data": "term"
                    },
                    {
                        "data": "session"
                    },
                    {
                        "data": "action"
                    },
                ],
                "columnDefs": [{
                    "visible": false,
                    "targets": 4
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(4, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="5"><b>' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        });

        // load student riders 
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
                        pid: "{{studentPid()}}",
                        _token: "{{csrf_token()}}"
                    },
                },

                "columns": [{
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