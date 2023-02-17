@extends('layout.mainlayout')
@section('title','Hire')
@section('content')
<link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Hire</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="hire-tab" data-bs-toggle="tab" data-bs-target="#hire-home" type="button" role="tab">Notification</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="applicant-tab" data-bs-toggle="tab" data-bs-target="#applicant" type="button" role="tab">Notification History</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="available-tab" data-bs-toggle="tab" data-bs-target="#available" type="button" role="tab">Event</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="hire-home" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#hieConfigModal">
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
            <div class="tab-pane fade" id="applicant" role="tabpanel" aria-labelledby="profile-tab">
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
            <div class="tab-pane fade" id="available" role="tabpanel">
                <div class="row mb-3">

                    <div class="col-md-4">
                        <select name="class_pid" id="timetableClassSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="arm_pid" id="timetableArmSelect2" class="classSelect2 form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="session_pid" id="timetableSessionSelect2" class="form-control form-control-sm">
                        </select>
                    </div>

                </div>
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="availableHire">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Names</th>
                            <th>Contact</th>
                            <th>Qualification</th>
                            <th>Field</th>
                            <th>Expirence</th>
                            <th>About</th>
                            <th>Subjects</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- modals  -->
<!-- create school category modal  -->
<div class="modal fade" id="hieConfigModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="hireApplicantForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Qualification</label>
                            <input type="text" class="form-control form-control-sm" name="qualification" id="qualification" placeholder="COE">
                            <p class="text-danger qualification_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Course of Study</label>
                            <input type="text" class="form-control form-control-sm" name="course" id="course" placeholder="e.g Economic Social Studies">
                            <p class="text-danger course_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Years of Expirence</label>
                            <input type="number" class="form-control form-control-sm" name="years" id="years" placeholder="e.g 2">
                            <p class="text-danger years_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Open?</label><br>
                            <input type="checkbox" class="checkbox" name="status" id="status" value="1">
                            <p class="text-danger status_error"></p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Subjects</label>
                            <select name="subject[]" id="hireSubjectSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger subject_error"></p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Note</label>
                            <textarea name="note" id="hireNote" class="form-control form-control-sm"> </textarea>
                            <p class="text-danger note_error"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createRecruitmentBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // add more title 

        // load dropdown on 
        multiSelect2('#hireSubjectSelect2', 'hieConfigModal', 'all-school-subject', 'Select Subject');

        // filter class subject 
        // FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        // FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        // create school class arm
        // $('#createClassArmBtn').click(function() {
        //     submitFormAjax('createClassArmForm', 'createClassArmBtn', "{{route('create.school.class.arm')}}");
        // });

        // availableHire
        $('#available-tab').click(function() {
            loadAvaibleForHire()
        })

        // create school class arm
        $('#createRecruitmentBtn').click(function() {
            submitFormAjax('hireApplicantForm', 'createRecruitmentBtn', "{{route('create.school.notification')}}");
        });
        // create school class arm
        $('#createNotificationBtn').click(function() {
            submitFormAjax('hireApplicantForm', 'createNotificationBtn', "{{route('create.school.notification')}}");
        });

        function loadAvaibleForHire() {

            $('#availableHire').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('hire.hire.able')}}",
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: null,
                        term_pid: null,
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
                        "data": "qualification"
                    },
                    {
                        "data": "course"
                    },
                    {
                        "data": "years"
                    },
                    {
                        "data": "about"
                    },
                    {
                        "data": "subjects"
                    },


                ],
            });
        }
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

@endsection

<!-- <h1>education is light hence EduLite</h1> -->