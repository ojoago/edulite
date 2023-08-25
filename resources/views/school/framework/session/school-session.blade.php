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
                    Create Session
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


<!-- End Basic Modal-->


<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // validate signup form on keyup and submit
        

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

        

    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->