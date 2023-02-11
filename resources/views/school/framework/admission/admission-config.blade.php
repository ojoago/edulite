@extends('layout.mainlayout')
@section('title','Admission Config')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Admission Config</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab">Admission Items</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="setup-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab">Admissions Fee</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="admission-session-tab" data-bs-toggle="tab" data-bs-target="#admission-session" type="button" role="tab">Admission Session</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#createAdmissionModal">
                    Create
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="admissionNameTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Class</th>
                            <th>Session</th>
                            <th>Commence</th>
                            <th>End</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <!-- <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#AdmissionConfigModal">
                    Admission Config
                </button> -->
                <!--  -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="admissionFeeTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Class</th>
                            <th>Session</th>
                            <th>Commence</th>
                            <th>End</th>
                            <th>Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="admission-session" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <!-- <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#AdmissionConfigModal">
                    Admission Config
                </button> -->
                <!--  -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="admissionSessionTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Class</th>
                            <th>Session</th>
                            <th>Commence</th>
                            <th>End</th>
                            <th>Fee</th>
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
<div class="modal fade" id="createAdmissionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Admission Setup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createAdmissionForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Start Date</label>
                            <input type="date" name="from" class="form-control form-control-sm">
                            <p class="text-danger from_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="">Close Date</label>
                            <input type="date" name="to" class="form-control form-control-sm">
                            <p class="text-danger to_error"></p>
                        </div>
                    </div>
                    <label for="">Admission Session</label>
                    <select name="session_pid" class="form-control form-control-sm" id="sessionSelect2">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="">Available class for admission</label>
                    <select name="class_pid[]" multiple class="form-control form-control-sm" id="classSelect2">
                    </select>
                    <p class="text-danger class_pid_error"></p>

                    <label for="">Admission Fee</label>
                    <select name="fee" class="form-control form-control-sm" id="admissionFeeSelect2">
                    </select>
                    <p class="text-danger fee_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createAdmissionBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- create school category modal  -->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#admissionNameTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            // destroy: true,
            type: "GET",
            "ajax": "{{route('load.admission.details')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    "data": "class"
                },
                {
                    "data": "session"
                },
                {
                    "data": "from"
                },
                {
                    "data": "to"
                },
                // {
                //     "data": "status"
                // },
                {
                    "data": "date",
                },
                // {
                //     "data": "action",
                // },

            ],
        });
        $('#setup-tab').click(function() {
            loadConfiguration()
        })

        function loadConfiguration() {
            $('#admissionFeeTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                type: "GET",
                "ajax": "{{route('load.admission.setup')}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "class"
                    },
                    {
                        "data": "session"
                    },
                    {
                        "data": "from"
                    },
                    {
                        "data": "to"
                    },

                    {
                        "data": "amount",
                    },

                ],
            });
        }
        // add more title 

        // add more title 

        // load dropdown on 

        // filter class subject 
        multiSelect2('#sessionSelect2', 'createAdmissionModal', 'session', 'Select Session');
        multiSelect2('#classSelect2', 'createAdmissionModal', 'all-class', 'Select Class');
        multiSelect2('#admissionFeeSelect2', 'createAdmissionModal', 'on-demand-fee', 'Select Fee Amount');
        FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        // multiSelect2('#admissionItem', 'admissionConfigModal', 'admission-items', 'Select Admission');

        // create Admission
        $('#createAdmissionBtn').click(function() {
            submitFormAjax('createAdmissionForm', 'createAdmissionBtn', "{{route('configure.admission')}}");
        });
        $(document).on('click', '.createAdmissionBtn', function() {
            let pid = $(this).attr('pid');
            let formId = 'AdmissionForm' + pid;
            let btnId = 'id' + pid;
            submitFormAjax(formId, btnId, "route('create.Admission.name')");
        })

        // create school class arm
        $('#createClassArmSubjectBtn').click(function() {
            submitFormAjax('createClassArmSubjectForm', 'createArmSubjectBtn', "{{route('create.school.class.arm.subject')}}");
        });

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->