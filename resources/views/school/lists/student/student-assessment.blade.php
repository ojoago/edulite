@extends('layout.mainlayout')
@section('title','Student Assessment')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet"> -->
<style>
    .formController {
        right: 0 !important;
        position: fixed;
        z-index: 1;
        padding: 5px;
        border: 1px solid #f1f1f1;
    }

    .non-visible {
        visibility: hidden;
    }
</style>
<div class="card">
    <div class="card-body">
        <h5 class="card-title mr-4">Assignments</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">

            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="assessment-tab" data-bs-toggle="tab" data-bs-target="#assessments" type="button" role="tab" aria-controls="assessment" aria-selected="false">Assessments</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="submitted-tab" data-bs-toggle="tab" data-bs-target="#submitted" type="button" role="tab" aria-controls="submitted" aria-selected="false">Submitted</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">

            <div class="tab-pane fade show active" id="assessments" role="tabpanel" aria-labelledby="assessments-tab">
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
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="assignmentTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Subject</th>
                            <th>TItle</th>
                            <!-- <th>Date</th> -->
                            <th>Deadline</th>
                            <!-- <th></th> -->
                            <th>Date</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="submitted" role="tabpanel" aria-labelledby="mark-tab">
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
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="submittedTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Subject</th>
                            <th>TItle</th>
                            <th>Mark</th>
                            <!-- <th>Date</th> -->
                            <th>Deadline</th>
                            <!-- <th></th> -->
                            <th>Date</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div><!-- End Default Tabs -->
    </div>
</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {

        $('#assessment-tab').click(function() {
            loadAssessment()
        })
        $('#submitted-tab').click(function() {
            loadSubmittedAssessments()
        })


        loadAssessment()

        function loadAssessment() {
            $('#assignmentTable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                destroy: true,
                "ajax": "{{route('load.assignment.for.student',['id'=>studentPid()])}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "end_date"
                    },


                    {
                        "data": "created_at"
                    },
                    {
                        "data": "action"
                    },
                ],
                "columnDefs": [{
                    "visible": false,
                    "targets": 1
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(1, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="5"><b>' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }

        function loadSubmittedAssessments() {
            $('#submittedTable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                destroy: true,
                "ajax": "{{route('load.student.submitted.assignment',['id'=>studentPid()])}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "mark"
                    },
                    {
                        "data": "end_date"
                    },


                    {
                        "data": "created_at"
                    },
                    {
                        "data": "action"
                    },
                ],
                "columnDefs": [{
                    "visible": false,
                    "targets": 1
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(1, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="5"><b>' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }




        FormMultiSelect2('#newAssignmentCategorySelect2', 'category', 'Select Category');
        $('#newAssignmentCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#newAssignmentClassSelect2', 'class', id, 'Select Class');
        });
        $('#newAssignmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#newAssignmentClassArmSelect2', 'class-teacher-arm', id, 'Select Class Arm');
        });
        $('#newAssignmentClassArmSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#newAssignmentSubjectSelect2', 'class-arm-subject', id, 'Select Class Subject');
        });

        FormMultiSelect2('#newAutomatedAssignmentCategorySelect2', 'category', 'Select Category');
        $('#newAutomatedAssignmentCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#newAutomatedAssignmentClassSelect2', 'class', id, 'Select Class');
        });
        $('#newAutomatedAssignmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#newAutomatedAssignmentClassArmSelect2', 'class-teacher-arm', id, 'Select Class Arm');
        });
        $('#newAutomatedAssignmentClassArmSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#newAutomatedAssignmentSubjectSelect2', 'class-arm-subject', id, 'Select Class Subject');
        });



    });
</script>
@endsection