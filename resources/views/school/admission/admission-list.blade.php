@extends('layout.mainlayout')
@section('title','Student Admission List')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Admission List</h5>
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="request-tab" data-bs-toggle="tab" data-bs-target="#request" type="button" role="tab">Current Admission</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="denied-tab" data-bs-toggle="tab" data-bs-target="#denied" type="button" role="tab">Denied Admission</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">Admission History</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="request" role="tabpanel" aria-labelledby="home-tab">
                <div class="row m-3">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <select name="session_pid" id="timetableSessionSelect2" class="form-control form-control-sm">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="term_pid" id="timetableTermSelect2" class="form-control form-control-sm">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="activeAdmission">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Names</th>
                            <th>Admission Number</th>
                            <th>Phone Number</th>
                            <th>Contacts</th>
                            <th>Class</th>
                            <th>Arm</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="denied" role="tabpanel" aria-labelledby="in-active-staff-tab">
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="activedataTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Names</th>
                            <th>Username</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Primary Role</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="admin-tab">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered cardTable" id="admin-list-dataTable">

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#activeAdmission').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.admission')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    // orderable: false,
                    // searchable: false
                },

                {
                    "data": "fullname"
                },
                {
                    "data": "admission_number"
                },
                {
                    "data": "gsm"
                },
                {
                    "data": "contact_gsm"
                },
                {
                    "data": "class"
                },
                {
                    "data": "arm"
                },
                {
                    "data": "date"
                },
                {
                    "data": "action"
                },
            ],
        });
        $(document).on('click', '.approveAdmission', function() {
            let pid = $(this).attr('pid');
            if (confirm('Are you Sure you want to grant this admission')) {
                $.ajax({
                    url: "{{route('grant.admission')}}",
                    type: "post",
                    data: {
                        pid: pid,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data) {
                        if ($data.status === 1) {
                            alert_toast(data.message, 'success');
                            return;
                        }
                        alert_toast(data.message, 'error');
                    }
                });
            }
        });
        $(document).on('click', '.denyAdmission', function() {
            let pid = $(this).attr('pid');
            if (confirm('Are you Sure you want deny this admission')) {
                $.ajax({
                    url: "{{route('deny.admission')}}",
                    type: "post",
                    data: {
                        pid: pid,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data) {
                        if (data.status === 1) {
                            alert_toast(data.message, 'success');
                            return;
                        }
                        alert_toast(data.message, 'error');
                    }
                });
            }
        });
    });
</script>
@endsection