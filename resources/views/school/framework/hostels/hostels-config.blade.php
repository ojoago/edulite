@extends('layout.mainlayout')
@section('title','Hostels config')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Hostels </h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="hostel-config-tab" data-bs-toggle="tab" data-bs-target="#hostel-config" type="button" role="tab">Hostels</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="hostel-tab" data-bs-toggle="tab" data-bs-target="#hostel-student" type="button" role="tab">Hostel Portal</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="ex-tab" data-bs-toggle="tab" data-bs-target="#hostelStudent" type="button" role="tab">Hostel Student</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="hostel-config" role="tabpanel">
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createHostelModal">
                    Create Hostel
                </button>
                <table class="table table-hover table-striped table-bordered cardTable" id="hostelDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Date Created</th>
                            <th>Created By</th>
                            <th><i class="bi bi-tools"></i> </th>

                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tab-pane fade" id="hostel-student" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-hover table-striped table-bordered cardTable" id="hostelPortalDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Hostel</th>
                            <th>Portal</th>
                            <th>Session</th>
                            <th>Term</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="tab-pane fade" id="hostelStudent" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-md-4">
                        <select name="session_pid" id="hostelStudentSessionSelect2" placeholder="select" class="form-control form-control-sm">
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select name="hostel_pid" id="hostelStudentHostelSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
                <table class="table table-hover table-striped table-bordered cardTable" id="studentDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Reg. No</th>
                            <th>Class</th>
                            <th>Session</th>
                            <th>Hostel</th>
                            <th>Assigned Date</th>
                            <th>Assigned By</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create psycho modal  -->
<div class="modal fade" id="createHostelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Hostel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createHostelForm">
                    @csrf
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Hostel Name">
                    <p class="text-danger name_error"></p>
                    <input type="number" name="capacity" class="form-control form-control-sm" placeholder="Capacity" required>
                    <p class="text-danger capacity_error"></p>
                    <textarea type="text" name="location" class="form-control form-control-sm" placeholder="Location" required></textarea>
                    <p class="text-danger location_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createHostelBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Psychomotro Modal-->



<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {

        // hostels
        $('#createHostelBtn').click(function() {
            var route = "{{route('create.hostel')}}";
            submitFormAjax('createHostelForm', 'createHostelBtn', route);
        });

        $('#hostelDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.hostels')}}",
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "capacity"
                },
                {
                    "data": "location"
                },
                {
                    "data": "date"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "action"
                },
            ],
        });
        $('#hostelPortalDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.hostel.portals')}}",
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "session"
                },
                {
                    "data": "term"
                },
                {
                    "data": "date"
                },


            ],
        });
        loadHostelStudent();

        function loadHostelStudent(session = null, hostel = null) {
            $('#studentDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.hostel.students')}}",
                    type: "post",
                    data: {
                        session: session,
                        hostel: hostel,
                        _token: "{{csrf_token()}}",
                    }
                },
                "columns": [{
                        "data": "fullname"
                    },
                    {
                        "data": "reg_number"
                    },
                    {
                        "data": "arm"
                    },
                    {
                        "data": "session"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "creator"
                    },
                ],
            });

        }
        FormMultiSelect2('#hostelStudentSessionSelect2', 'session', 'Select Session');
        FormMultiSelect2('#hostelStudentHostelSelect2', 'hostels', 'Select Hostel');
        $('#hostelStudentSessionSelect2').change(function() {
            let session = $(this).val();
            let hostel = $('#hostelStudentHostelSelect2').val();
            loadHostelStudent(session, hostel)
        });
        $('#hostelStudentHostelSelect2').change(function() {
            let hostel = $(this).val();
            let session = $('#hostelStudentSessionSelect2').val();
            loadHostelStudent(session, hostel)
        });



    });
</script>
@endsection