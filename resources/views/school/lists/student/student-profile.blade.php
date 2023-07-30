@extends('layout.mainlayout')
@section('title','Student Profile')
@section('content')
<link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">
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
                        <button class="nav-link w-100" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">Attendance</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="assignment-tab" data-bs-toggle="tab" data-bs-target="#assignment" type="button" role="tab">Assignment</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="fees-tab" data-bs-toggle="tab" data-bs-target="#fees" type="button" role="tab">Fees</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="timetable-tab" data-bs-toggle="tab" data-bs-target="#timetable" type="button" role="tab">Timetable</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="results-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab">Result</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="class-tab" data-bs-toggle="tab" data-bs-target="#class" type="button" role="tab">Classes</button>
                    </li>

                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="reciept-tab" data-bs-toggle="tab" data-bs-target="#reciepts" type="button" role="tab">Reciept</button>
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
                        <h4>Attendance Record</h4>
                        <div class="response"></div>
                        <div id='calendar'></div>
                    </div>
                    <div class="tab-pane fade" id="assignment" role="tabpanel">
                        <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="assignmentTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th>Subject</th>
                                    <th>TItle</th>
                                    <th width="10%">Deadline</th>
                                    <th width="10%">Date</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="fees" role="tabpanel">
                        <!--  -->
                        <button class="btn btn-primary btn-sm m-2" id="payWardFee">Pay Fee</button>
                        List of unpaid fees
                        <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="unPaidInvoiceTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th>Class</th>
                                    <th>Fee</th>
                                    <th align="right">{!!NAIRA_UNIT!!} Amount</th>
                                    <th>Term</th>
                                    <th>Session</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th colspan="5"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="timetable" role="tabpanel">
                        <!--  -->

                        <div class="row mb-3">

                            <div class="col-md-3">
                                <select name="session_pid" id="timetableSessionSelect2" class="form-control form-control-sm">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="term_pid" id="timetableTermSelect2" class="form-control form-control-sm">
                                </select>
                            </div>
                        </div>
                        <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="timetableDatatable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <!-- <th>Class</th> -->
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="class" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered cardTable" id="classDataTable">
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
                    <div class="tab-pane fade" id="reciepts" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered cardTable" id="recieptDataTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th>Invoice Number</th>
                                    <th align="right">{!!NAIRA_UNIT!!} Total</th>
                                    <th align="right">{!!NAIRA_UNIT!!} Amount paid</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <td colspan="2"></td>
                                <th></th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="results" role="tabpanel">
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

                                    <th>S/N</th>
                                    <th>Position</th>
                                    <th>Total</th>
                                    <th>Term</th>
                                    <th>Session</th>
                                    <th>view</th>
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


<!-- student invoice payment -->
<div class="modal fade" id="processStudentInvoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="processStudentInvoiceForm">
                    @csrf
                    <input type="hidden" name="student_pid" id="wardStudentSelect2">
                    <div id="studentUnPaidInvoices"></div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" type="button" id="acceptPaymentBtn" style="display: none;">Submit</button>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script>
    $(document).ready(function() {

        let term = "{{activeTerm()}}"
        let session = "{{activeSession()}}"
        FormMultiSelect2('#formTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#formSessionSelect2', 'session', 'Select Session', session)


        FormMultiSelect2('#timetableTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#timetableSessionSelect2', 'session', 'Select Session', session)

        FormMultiSelect2('#resultTermSelect2', 'term', 'Select Term');
        FormMultiSelect2('#resultSessionSelect2', 'session', 'Select Session');
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
        $('#reciept-tab').click(function() {
            $('#recieptDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.particular.student.payment')}}",
                    data: {
                        pid: "{{$pid}}",
                        _token: "{{csrf_token()}}"
                    },
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "invoice_number"
                    },
                    {
                        "data": "total"
                    },
                    {
                        "data": "paid"
                    },
                    {
                        "data": "date"
                    },
                ],
                "footerCallback": function() {
                    var api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // computing column Total of the complete result 
                    var total = api
                        .column(2)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var paid = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column(0).footer()).html('Total');
                    $(api.column(2).footer()).html(numberFormat(total));
                    $(api.column(3).footer()).html(numberFormat(paid));
                }
            });
        });

        $('#results-tab').click(function() {
            $('#resultDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.student.result')}}",
                    data: {
                        pid: "{{$pid}}",
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

        $('#assignment-tab').click(function() {
            $('#assignmentTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": "{{route('load.assignment.for.student',['id'=>$pid])}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "end_date"
                    },


                    {
                        "data": "created_at"
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
                                '<tr class="group"><td colspan="5"><b>' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        })

        function unPaidInvoice(term = null, session = null) {
            $('#unPaidInvoiceTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.particular.student.invoice')}}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: session,
                        term_pid: term,
                        pid: "{{$pid}}",
                    }
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "arm"
                    },

                    {
                        "data": "fee_name"
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "term"
                    },
                    {
                        "data": "session"
                    },

                    {
                        "data": "type",
                    },

                    {
                        "data": "date",
                    },
                ],
                "footerCallback": function() {
                    var api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // computing column Total of the complete result 
                    var total = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column(0).footer()).html('Total');
                    $(api.column(3).footer()).html(numberFormat(total));
                }
            });

        }
        $('#fees-tab').click(function() {
            unPaidInvoice()
        })
        $('#payWardFee').click(async function() {
            let pid = "{{base64Decode($pid)}}"
            if (pid) {
                await loadStudentInvoiceById(pid) // this function is inside mainjs.blade.php
                $('#wardStudentSelect2').val(pid); // 
                $('#processStudentInvoiceModal').modal('show');
            }
        })
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
                        pid: "{{$pid}}",
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
                        pid: "{{$pid}}",
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

<script>
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: {
            url: "{{route('student.attendance')}}",
            type: "post",
            data: {
                pid: "{{$pid}}",
                _token: "{{csrf_token()}}"
            },
        },
        displayEventTime: false,
        eventRender: function(event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        // selectable: true,
        // selectHelper: true,
        // select: function(start, end, allDay) {
        //     var title = prompt('Event Title:');

        //     if (title) {
        //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
        //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

        //         $.ajax({
        //             url: 'add-event.php',
        //             data: 'title=' + title + '&start=' + start + '&end=' + end,
        //             type: "POST",
        //             success: function(data) {
        //                 displayMessage("Added Successfully");
        //             }
        //         });
        //         calendar.fullCalendar('renderEvent', {
        //                 title: title,
        //                 start: start,
        //                 end: end,
        //                 allDay: allDay
        //             },
        //             true
        //         );
        //     }
        //     calendar.fullCalendar('unselect');
        // },

        editable: false,
        // eventDrop: function(event, delta) {
        //     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        //     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        //     $.ajax({
        //         url: 'edit-event.php',
        //         data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
        //         type: "POST",
        //         success: function(response) {
        //             displayMessage("Updated Successfully");
        //         }
        //     });
        // },
        // eventClick: function(event) {
        //     var deleteMsg = confirm("Do you really want to delete?");
        //     if (deleteMsg) {
        //         $.ajax({
        //             type: "POST",
        //             url: "delete-event.php",
        //             data: "&id=" + event.id,
        //             success: function(response) {
        //                 if (parseInt(response) > 0) {
        //                     $('#calendar').fullCalendar('removeEvents', event.id);
        //                     displayMessage("Deleted Successfully");
        //                 }
        //             }
        //         });
        //     }
        // }

    });
</script>
@endsection