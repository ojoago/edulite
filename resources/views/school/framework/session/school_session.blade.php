@extends('layout.mainlayout')
@section('title','lite')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Lite Session</h5>
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
                <table class="table table-bordered table-striped table-hover mt-3" id="dataTable">
                    <thead>
                        <tr>
                            <!-- <th>SN</th> -->
                            <th>Session</th>
                            <th>Date</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

            <div class=" tab-pane fade" id="set-active-tab" role="tabpanel" aria-labelledby="set-active-tab">

                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#setActiveSessionModal">
                    Set Active active
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table table-bordered table-striped table-hover mt-3" width="100%" id="active-session-table">
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

<!-- create active Modal -->
<div class="modal fade" id="createactiveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create active</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <input type="text" name="active" class="form-control" placeholder="school active" required><br>
                    @error('active')
                    <p class="text-danger">{{$message}}</p>
                    @enderror

                    <!-- <input type="text" name="reg_number"><br> -->
                    <button type="submit">Create</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

<!-- set active active Modal -->
<div class="modal fade" id="createactiveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Active active</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <input type="text" name="active" class="form-control" placeholder="school active" required><br>
                    @error('active')
                    <p class="text-danger">{{$message}}</p>
                    @enderror

                    <!-- <input type="text" name="reg_number"><br> -->
                    <!-- <button type="submit">Create</button> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // validate signup form on keyup and submit
        $('#createSessionBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('school.session')}}",
                type: "POST",
                data: new FormData($('#createSessionForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createSessionForm').find('p.text-danger').text('');
                    $('#createSessionBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#createSessionBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill the form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('p.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createSessionForm')[0].reset();
                    }
                },
                error: function(data) {
                    $('#createSessionBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });

        // load school session
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('load.school.session')}}",
            "columns": [{
                    "data": "session"
                },
                {
                    "data": "created_at"
                },
                // {
                //     "data": "action"
                // },
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

        $('#sessionSelect2').select2({
            placeholder: 'Select an Option',
            dropdownParent: $('#setActiveSessionModal'),
            ajax: {
                url: "{{route('load.available.session')}}",
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        // set active session 
        $('#setActiveSessionBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('school.session.active')}}",
                type: "POST",
                data: new FormData($('#setActiveSessionForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#setActiveSessionForm').find('span.text-danger').text('');
                    $('#setActiveSessionBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#setActiveSessionBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Select Session', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#setActiveSessionForm')[0].reset();
                    }
                },
                error: function(data) {
                    $('#setActiveSessionBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->