@extends('layout.mainlayout')
@section('title','Assignment')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mr-4">Assignments <button class="btn btn-primary ml-3 btn-sm" data-bs-toggle="modal" data-bs-target="#addNewAssignmentModal"> <i class="bi bi-plus"></i> Add New</button> </a></h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="active-staff-tab" data-bs-toggle="tab" data-bs-target="#active-staff" type="button" role="tab" aria-controls="active" aria-selected="true">Assignment</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="in-active-staff-tab" data-bs-toggle="tab" data-bs-target="#in-active-staff" type="button" role="tab" aria-controls="in-active" aria-selected="false">Submitted Assignment</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="active-staff" role="tabpanel" aria-labelledby="home-tab">
                <div class="row p-2">
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentSessionSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentTermSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="list-active-staff-dataTable">
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
            <div class="tab-pane fade" id="in-active-staff" role="tabpanel" aria-labelledby="in-active-staff-tab">
                <div class="row p-2">
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentSessionSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentTermSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
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
        </div><!-- End Default Tabs -->
    </div>
</div>
<!-- new assignment  -->
<div class="modal fade" id="addNewAssignmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info">NEW ASSIGNMEENT FOR STUDENT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="newAssignmentForm">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" id="newAssignmentCategorySelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger subject_error"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <select name="class" id="newAssignmentClassSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger subject_error"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Class Arm</label>
                        <select name="arm" id="newAssignmentClassArmSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger subject_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subject</label>
                        <select name="subject" id="newAssignmentSubjectSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger subject_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Score</label>
                        <input type="number" class="form-control form-control-sm" name="score" id="newAssignmentScore" placeholder="e.g 5">
                        <p class="text-danger score_error"></p>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Note</label>
                        <input type="text" class="form-control form-control-sm" name="score" id="newAssignmentNote" placeholder="guideline">
                        <p class="text-danger note_error"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Recordable?</label><br>
                        Yes <input type="checkbox" class="radio" name="recordable" id="newAssignmentRecordable">
                        <p class="text-danger recordable_error"></p>
                    </div>

                    <div class="col-md-8" style="display:none" id="newAssignmentCaType">
                        <label class="form-label">Link to Assessment</label>
                        <select name="ca_title" id="newAssignmentCaTypeSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger ca_title_error"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Type?</label><br>
                        Upload <input type="radio" class="radio" name="type" id="newAssignmentType" value="1">
                        In App <input type="radio" class="radio" name="type" id="newAssignmentType" value="2" checked>
                        <p class="text-danger type_error"></p>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Question</label>
                        <textarea name="question" id="newAssignmentQuestion" class="form-control form-control-sm"></textarea>
                        <p class="text-danger question_error"></p>
                    </div>
                    <div class="col-md-12" style="display:none">
                        <label class="form-label">File</label>
                        <input type="file" accept="pdf,docs" name="file" id="newAssignmentFile" class="form-control form-control-sm">
                        <p class="text-danger file_error"></p>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="hireMeBtn">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {

        $('#list-active-staff-dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.staff.list')}}",
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
                    "data": "username"
                },
                {
                    "data": "gsm"
                },

                {
                    "data": "email"
                },
                {
                    "data": "role"
                },

                {
                    "data": "created_at"
                },
                {
                    "data": "action"
                },
            ],
        });
        $('#in-active-staff-tab').click(function() {
            $('#activedataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                "ajax": "{{route('load.inactive.staff.list')}}",
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
                        "data": "username"
                    },
                    {
                        "data": "gsm"
                    },

                    {
                        "data": "email"
                    },
                    {
                        "data": "role"
                    },

                    {
                        "data": "created_at"
                    },
                    {
                        "data": "action"
                    },
                ],
            });
        });


        multiSelect2('#newAssignmentCategorySelect2', 'addNewAssignmentModal', 'category', 'Select Category');

        $('#newAssignmentCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#newAssignmentClassSelect2', 'addNewAssignmentModal', 'class', id, 'Select Class');
        });
        $('#newAssignmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#newAssignmentClassArmSelect2', 'addNewAssignmentModal', 'class-arm', id, 'Select Class Arm');
        });
        $('#newAssignmentClassArmSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#newAssignmentSubjectSelect2', 'addNewAssignmentModal', 'class-arm-subject', id, 'Select Class Student');
        });
        $('#newAssignmentRecordable').click(function() {
            // var previousValue = $(this).attr('previousValue');
            // if (previousValue == 'true') {
            //     this.checked = false;
            //     $(this).attr('previousValue', this.checked);
            // } else {
            //     this.checked = true;
            //     $(this).attr('previousValue', this.checked);
            // }
            if ($(this).is(':checked')) {
                $('#newAssignmentCaType').show(500);
            } else {
                $('#newAssignmentCaType').hide(500);
            }
        });
    });
</script>
@endsection