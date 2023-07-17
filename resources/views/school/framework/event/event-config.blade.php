@extends('layout.mainlayout')
@section('title','School Events')
@section('content')
<link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Events</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab">Notification</button>
            </li>
            <!-- <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab">Notification History</button>
            </li> -->
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-arm-tab" data-bs-toggle="tab" data-bs-target="#class-arm" type="button" role="tab">Event</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createNotificationModal">
                    Create Notification
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="notificationTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Message</th>
                            <th>type</th>
                            <th>start date</th>
                            <th>end date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="Table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="class-arm" role="tabpanel" aria-labelledby="class-arm-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPublicEventModal">
                    Add Event
                </button>
                <div class="response"></div>
                <div id='calendar'></div>
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- modals  -->
<!-- create school category modal  -->
<div class="modal fade" id="createNotificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createNotificationForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Begin Date</label>
                            <input type="date" name="begin" class="form-control form-control-sm" required>
                            <p class="text-danger begin_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="">End Date</label>
                            <input type="date" name="end" class="form-control form-control-sm" required>
                            <p class="text-danger end_error"></p>
                        </div>
                    </div>
                    <label for="">Message</label>
                    <textarea type="text" name="message" class="form-control form-control-sm" placeholder="message" required></textarea>
                    <p class="text-danger message_error"></p>
                    <label for="">Audience</label>
                    <select name="type" id="type" class="form-control form-control-sm">
                        <option disabled selected>Select Audience</option>
                        <option value="1">Notice Board</option>
                        <option value="2">Parents</option>
                        <option value="3">Rider/Care</option>
                        <option value="4">General</option>
                        <option value="5">Students</option>
                        <option value="6">All Staff</option>
                        <!-- <option value="7">Academic Staff</option>
                        <option value="8">Non-Academic Staff</option> -->
                    </select>
                    <p class="text-danger type_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createNotificationBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createPublicEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createEventForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Begin Date</label>
                            <input type="date" name="begin" class="form-control form-control-sm" required>
                            <p class="text-danger begin_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="">End Date</label>
                            <input type="date" name="end" class="form-control form-control-sm" required>
                            <p class="text-danger end_error"></p>
                        </div>
                    </div>
                    <label for="">Message</label>
                    <textarea type="text" name="message" class="form-control form-control-sm" placeholder="message" required></textarea>
                    <p class="text-danger message_error"></p>
                    <label for="">Audience</label>
                    <select name="type" id="type" class="form-control form-control-sm">
                        <option disabled selected>Select Audience</option>
                        <option value="1">Notice Board</option>
                        <option value="4">General</option>
                    </select>
                    <p class="text-danger type_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createEventBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // add more title 

        // load dropdown on 

        // filter class subject 
        // FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        // FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        // create school class arm
        // $('#createClassArmBtn').click(function() {
        //     submitFormAjax('createClassArmForm', 'createClassArmBtn', "{{route('create.school.class.arm')}}");
        // });


        // create school class arm
        $('#createNotificationBtn').click(function() {
            submitFormAjax('createNotificationForm', 'createNotificationBtn', "{{route('create.school.notification')}}");
        });
        $('#createEventBtn').click(function() {
            submitFormAjax('createEventForm', 'createEventBtn', "{{route('create.school.notification')}}");
        });
        // load page content  
        loadNotification();
        // load school Notification
        function loadNotification(session = null, term = null) {
            $('#notificationTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('load.school.notification')}}",
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: session,
                        term_pid: term,
                    },
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "message"
                    },
                    {
                        "data": "type"
                    },
                    {
                        "data": "begin"
                    },
                    {
                        "data": "end",
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
            url: "{{route('load.events')}}",
            // type: "post",
            // data: {
            //     _token: "{{csrf_token()}}"
            // },
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
        eventDrop: function(event, delta) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            $.ajax({
                url: 'edit-event.php',
                data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                type: "POST",
                success: function(response) {
                    displayMessage("Updated Successfully");
                }
            });
        },
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

<!-- <h1>education is light hence EduLite</h1> -->