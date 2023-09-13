@extends('layout.mainlayout')
@section('title','Student Attendance')
@section('content')
<link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">
<div class="row">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Student Attendance</h5>

            <!-- Default Tabs -->
            <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab">Monthly</button>
                </li>

                <!-- <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="count-tab" data-bs-toggle="tab" data-bs-target="#count" type="button" role="tab">count </button>
                </li>
                 -->
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">History</button>
                </li>
            </ul>
            <div class="tab-content pt-2" id="myTabjustifiedContent">
                <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="activeStudent-tab">
                    <h4>Attendance Record</h4>
                    <div class="response"></div>
                    <div id='calendar'></div>
                </div>
                <!-- <div class="tab-pane fade" id="count" role="tabpanel">

                </div> -->
                <div class="tab-pane fade" id="history" role="tabpanel">
                    <table class="table table-bordered border-primary cardTable" id="attendanceTable">
                        <thead>
                            <tr>
                                <!-- <th scope="col">Reg-Number</th>
                                <th scope="col">Names</th> -->
                                <th> Date </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div><!-- End Default Tabs -->

        </div>
    </div>

</div>


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

        $('#history-tab').click(function() {
            loadAttendanceHistory()
        })

        function loadAttendanceHistory(arm = null, term = null, session = null, date = null) {
            $('#attendanceTable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('student.attendance.history')}}",
                    data: {

                        _token: "{{csrf_token()}}",
                        term_pid: term,
                        session_pid: session,
                        arm_pid: arm,
                        date: date,
                        pid: "{{studentPid()}}",
                    },
                },

                "columns": [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    // },
                    // {
                    //     "data": "reg_number"
                    // },
                    // {
                    //     "data": "fullname"
                    // },

                    {
                        "data": "start"
                    },
                    {
                        "data": "title"
                    },
                ],
            });
        }


    });
</script>

<script>
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: {
            url: "{{route('student.attendance')}}",
            type: "post",
            data: {
                pid: "{{studentPid()}}",
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