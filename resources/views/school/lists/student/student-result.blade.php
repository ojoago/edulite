@extends('layout.mainlayout')
@section('title','Student Profile')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Results</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">

            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link active w-100" id="results-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab">Result</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-tab" data-bs-toggle="tab" data-bs-target="#class" type="button" role="tab">Classes</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="award-tab" data-bs-toggle="tab" data-bs-target="#award" type="button" role="tab">Award</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade active show" id="results" role="tabpanel">
                <div class="row m-2">
                    <div class="col-md-6">
                        <select name="session_pid" id="resultSessionSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="term_pid" id="resultTermSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
                <table class="table table-hover table-striped table-bordered cardTable" width="100%" id="resultDataTable">
                    <thead>
                        <tr>

                            <th width="5%">S/N</th>
                            <th>Class</th>
                            {{-- <th>Position</th> --}}
                            <th>Total</th>
                            <th>Term</th>
                            <th>Session</th>
                            <th>view</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>


            <div class="tab-pane fade" id="class" role="tabpanel">
                <table class="table table-hover table-striped table-bordered cardTable" width="100%" id="classDataTable">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Session</th>
                            <!-- <th>Date</th> -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="award" role="tabpanel">
                <table class="table table-hover table-striped table-bordered cardTable" width="100%" id="classDataTable">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Session</th>
                            <!-- <th>Date</th> -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<script>
    $(document).ready(function() {


        FormMultiSelect2('#resultTermSelect2', 'term', 'Select Term');
        FormMultiSelect2('#resultSessionSelect2', 'session', 'Select Session');


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
                    //{
                    //  "data": "date"
                    //},
                ],
            });
        });

        function result() {
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
                        "data": "arm"
                    },
                    // {
                    //     "data": "position"
                    // },
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
                    "targets": 1
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(1, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="6"><b>' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }

        result()
        $('#results-tab').click(function() {
            result()
        });


        // load page content  
        $('#timetable-tab').click(function() {
            loadTimetable();
        })


        $('#timetableTermSelect2').change(function() {
            let term = $(this).val();
            let session = $('#timetableSessionSelect2').val();
            if (session != null) {
                loadTimetable(session, term);
            } else {
                loadTimetable(null, term);
            }
        })
        // load school timetable
        function loadTimetable(session = null, term = null) {
            $('#timetableDatatable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('load.student.timetable')}}",
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: session,
                        term_pid: term,
                        pid: "{{studentPid()}}",
                    },
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    // {
                    //     "data": "arm"
                    // },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "exam_date"
                    },
                    {
                        "data": "exam_time",
                    },
                    {
                        "data": "date"
                    },
                ],
                // drawCallback: function(settings) {
                //     var api = this.api();
                //     var rows = api.rows({
                //         page: 'current'
                //     }).nodes();
                //     var last = null;

                //     api.column(4, {
                //         page: 'current'
                //     }).data().each(function(group, i) {

                //         if (last !== group) {

                //             $(rows).eq(i).before(
                //                 '<tr class="group"><td colspan="8">' + 'GRUPO ....' + group + '</td></tr>'
                //             );

                //             last = group;
                //         }
                //     });
                // }
            });
        }



    });
</script>


@endsection