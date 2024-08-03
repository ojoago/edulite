@extends('layout.mainlayout')
@section('title','School Events')
@section('content')
<link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Events</h5>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPublicEventModal">
                    Add Event
                </button>
                <div class="response"></div>
                <div id='calendar'></div>
        <!-- Default Tabs -->

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

<div class="modal fade" id="eventDetailModal" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="eventDate">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id = "eventDetails"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->

<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // add more title 
       
        $('#createEventBtn').click(function() {
            submitFormAjax('createEventForm', 'createEventBtn', "{{route('create.school.notification')}}");
        });
        // load page content  
       
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
        eventClick: function(event) {
            if(event.data){
                event.data.forEach(el => {
                    $('#eventDate').text(event.date)
                    $('#eventDetails').append(`<h4> ${el.title} -- <small class="small text-success"> ${el.role} </small> </h4> <hr>`)
                });
                $('#eventDetailModal').modal('show')
            }
            // var deleteMsg = confirm("Do you really want to delete?");
            // // eventDetails
            // if (deleteMsg) {
            //     $.ajax({
            //         type: "POST",
            //         url: "delete-event.php",
            //         data: "&id=" + event.id,
            //         success: function(response) {
            //             if (parseInt(response) > 0) {
            //                 $('#calendar').fullCalendar('removeEvents', event.id);
            //                 displayMessage("Deleted Successfully");
            //             }
            //         }
            //     });
            // }
        }

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->