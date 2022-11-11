@extends('layout.mainlayout')
@section('title','Set Session')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Session</h5>
        <!-- Bordered Tabs Justified -->
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <!-- <a href="#session-tab"> -->
                <button class="nav-link w-100 active" data-bs-toggle="tab" data-bs-target="#session-tab" type="button" role="tab" aria-controls="session" aria-selected="true">Session</button>
                <!-- </a> -->
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <!-- <a href="#active-tab"> -->
                <button class="nav-link w-100" id="active-tab" data-bs-toggle="tab" data-bs-target="#set-active-tab" type="button" role="tab" aria-controls="active" aria-selected="false">Active Session</button>
                <!-- </a> -->
            </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="session-tab" role="tabpanel" aria-labelledby="session-tab">
                <!-- Create Session -->
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createSessionModal">
                    New Session
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table table-bordered table-striped table-hover mt-3 cardTable" id="dataTable">
                    <thead>
                        <tr>
                            <!-- <th>SN</th> -->
                            <th>Session</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

            <div class=" tab-pane fade" id="set-active-tab" role="tabpanel" aria-labelledby="set-active-tab">

                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#setActiveSessionModal">
                    Set Active Session
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="active-session-table">
                    <thead>
                        <tr>
                            <!-- <th>SN</th> -->
                            <th>Active Session</th>
                            <th>Date</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

        </div><!-- End Bordered Tabs Justified -->

    </div>
</div>
<!-- create school session modal  -->
<div class="modal fade" id="createSessionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Academic Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createSessionForm">
                    @csrf
                    <input type="text" name="session" autocomplete="off" class="form-control" placeholder="lite session e.g 2021/2022" required>
                    <p class="text-danger session_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createSessionBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End school session Modal-->

<!-- set active session modal  -->
<div class=" modal fade" id="setActiveSessionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Active Academic Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="setActiveSessionForm">
                    @csrf
                    <select class="form-control select2-container" style="width: 100%;" id="sessionSelect2" name="active_session">
                    </select>
                    <span class="text-danger active_session_error"></span>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="setActiveSessionBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->


<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // validate signup form on keyup and submit
        $('#createSessionBtn').click(function() {
            submitFormAjax('createSessionForm', 'createSessionBtn', "{{route('school.session')}}");
        });

        // update session 
        $(document).on('click', '.createSessionBtn', function() {
            let pid = $(this).attr('pid');
            let formId = 'sessionForm' + pid;
            let btnId = 'id' + pid;
            submitFormAjax(formId, btnId, "{{route('school.session')}}");
        })
        // load school session
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('load.school.session')}}",
            "columns": [{
                    "data": "session"
                },
                {
                    "data": "date"
                },
                {
                    "data": "action"
                },
            ],
        });

        // load active session 
        $('#active-session-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('load.school.active.session')}}",
            "columns": [{
                    "data": "session"
                },
                {
                    "data": "created_at"
                },
            ],
        });

        multiSelect2('#sessionSelect2', 'setActiveSessionModal', 'session', 'Select Session');

        // set active session 
        $('#setActiveSessionBtn').click(function() {
            submitFormAjax('setActiveSessionForm', 'setActiveSessionBtn', "{{route('school.session.active')}}");
        });

    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->