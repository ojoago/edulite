@extends('layout.mainlayout')
@section('title','School Notifications')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Notifications</h5>
        <!-- Default Tabs -->
         <div class="table-responsive mt-3">
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
       
      
    </div>
</div>

<!-- modals  -->
<!-- create school category modal  -->
<div class="modal fade" id="createNotificationModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Event</h5>
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


<script>
    $(document).ready(function() {
        // add more title 
        // create school class arm
        $('#createNotificationBtn').click(function() {
            submitFormAjax('createNotificationForm', 'createNotificationBtn', "{{route('create.school.notification')}}");
        });
       
        // load page content  
        loadNotification();
        // load school Notification
        function loadNotification(session = null, term = null) {
            $('#notificationTable').DataTable({
                "processing": true,
                "serverSide": true,
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


@endsection

<!-- <h1>education is light hence EduLite</h1> -->