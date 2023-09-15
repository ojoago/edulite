@extends('layout.mainlayout')
@section('title','Assignment')
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
                <button class="nav-link w-100 active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="true">Manually Marked</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="automated-tab" data-bs-toggle="tab" data-bs-target="#automated" type="button" role="tab" aria-controls="automated" aria-selected="false">Automated</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="submitted-tab" data-bs-toggle="tab" data-bs-target="#submitted" type="button" role="tab" aria-controls="submitted" aria-selected="false">Assessments</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="mark-tab" data-bs-toggle="tab" data-bs-target="#mark" type="button" role="tab" aria-controls="mark" aria-selected="false">Submitted</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="manual" role="tabpanel" aria-labelledby="manual-tab">

                <fieldset class="border rounded-3 p-3">
                    <legend class="float-none w-auto px-3">New Assignment</legend>
                    <form class="row g-3 needs-validation" enctype="multipart/form-data" id="newManualAssignmentForm">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" id="newAssignmentCategorySelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger category_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Class</label>
                            <select name="class" id="newAssignmentClassSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger class_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Class Arm</label>
                            <select name="arm" id="newAssignmentClassArmSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Subject</label>
                            <select name="subject" id="newAssignmentSubjectSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger subject_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Assignment Title</label>
                            <input type="text" class="form-control form-control-sm" name="title" id="newAssignmentScore" placeholder="enter title">
                            <p class="text-danger title_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Deadline</label>
                            <input type="date" class="form-control form-control-sm" name="end_date" id="end_date">
                            <p class="text-danger end_date_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mark</label>
                            <input type="number" class="form-control form-control-sm" name="total_mark" id="newAssignmentScore" placeholder="e.g 5">
                            <p class="text-danger mark_error"></p>
                        </div>
                        <div class="col-md-10">
                            <label class="form-label">Note</label>
                            <textarea type="text" class="form-control form-control-sm summer-note" name="note" id="newAssignmentNote" placeholder="guideline"></textarea>
                            <p class="text-danger note_error"></p>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Recordable?</label><br>
                            Yes <input type="checkbox" class="radio" name="recordable" id="newAssignmentRecordable">
                            <p class="text-danger recordable_error"></p>
                            <label class="form-label">Same Mark?</label><br>
                            Yes <input type="checkbox" class="radio" name="same_make" id="same_make">
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
                            Upload <input type="radio" class="radio assessmentType" name="type" id="newAssignmentType" value="1">
                            In App <input type="radio" class="radio assessmentType" name="type" id="newAssignmentType" value="2" checked>
                            <p class="text-danger type_error"></p>
                        </div>

                        <div class="col-md-12" id="newAssignmentQuestion">
                            <label class="form-label">Question</label>
                            <textarea name="question" class="form-control form-control-sm summer-note"></textarea>
                            <p class="text-danger question_error"></p>
                        </div>
                        <div class="col-md-12" style="display:none" id="newAssignmentFile">
                            <label class="form-label">File</label>
                            <input type="file" accept=".pdf,.docs,.doc" name="file" class="form-control form-control-sm">
                            <p class="text-danger file_error"></p>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="button" id="newManualAssignmentBtn">Submit</button>
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </fieldset>
            </div>
            <div class="tab-pane fade" id="automated" role="tabpanel" aria-labelledby="automated-tab">

                <fieldset class="border rounded-3 p-3">
                    <legend class="float-none w-auto px-3">Automated Assignment</legend>
                    <div class="formController" id="formController">
                        <button class="btn btn-outline-success" id="nextQuestion"><i class="bi bi-plus mr-1"></i>Next Question</button>
                    </div>
                    <form class="row g-3 needs-validation" id="automatedAssignmentForm">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" id="newAutomatedAssignmentCategorySelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger category_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Class</label>
                            <select name="class" id="newAutomatedAssignmentClassSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger class_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Class Arm</label>
                            <select name="arm" id="newAutomatedAssignmentClassArmSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Subject</label>
                            <select name="subject" id="newAutomatedAssignmentSubjectSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger subject_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Assignment Title</label>
                            <input type="text" class="form-control form-control-sm" autocomplete="off" name="title" id="newAssignmentScore" placeholder="e.g Assignment 1">
                            <p class="text-danger title_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Deadline</label>
                            <input type="date" class="form-control form-control-sm" name="end_date" id="end_date">
                            <p class="text-danger end_date_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mark</label>
                            <input type="number" class="form-control form-control-sm" name="total_mark" id="newAssignmentScore" placeholder="e.g 5">
                            <p class="text-danger total_mark_error"></p>
                        </div>
                        <div class="col-md-10">
                            <label class="form-label">Note</label>
                            <textarea type="text" class="form-control form-control-sm summer-note" name="note" id="newAssignmentNote" placeholder="guideline"></textarea>
                            <p class="text-danger note_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Recordable?</label><br>
                            Yes <input type="checkbox" class="radio" name="recordable" id="newAssignmentRecordable">
                            <p class="text-danger recordable_error"></p>
                            <label class="form-label">Same Mark?</label><br>
                            Yes <input type="checkbox" class="radio" name="same_mark" id="same_mark" checked>
                            <p class="text-danger recordable_error"></p>
                        </div>

                        <div class="col-md-8" style="display:none" id="newAssignmentCaType">
                            <label class="form-label">Link to Assessment</label>
                            <select name="ca_title" id="newAssignmentCaTypeSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger ca_title_error"></p>
                        </div>
                        <input type="hidden" name="type" id="newAutomatedAssignmentType" value="3" checked>

                        <div class="col-md-12  px-0" id="fieldQuestions">
                            <fieldset class="border rounded-3 p-3  px-0">
                                <legend class="float-none w-auto px-3">Question 1</legend>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        Question Type
                                        <select name="types[]" id="type0" type="0" class="changeQuestionType form-select form-select-sm ">
                                            <option value="1">Single Select</option>
                                            <option value="2">Multi Select</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 sameMarkRow" style="display:none">
                                        <label for="">Score</label>
                                        <input name="marks[]" placeholder="allocate Score" id="mark1" question="0" class="marks form-control form-control-sm">
                                    </div>
                                </div>
                                <textarea name="question[]" placeholder="Question 1" value="Question 1" id="question1" question="0" class="questions form-control form-control-sm summer-note"></textarea>
                                <p class="text-danger question_error"></p>
                                <button type="button" id="question0" question="0" class="addMoreOption btn btn-sm btn-outline-success"><i class="bi bi-plus"></i></button>
                                <div class="col-md-8 m-3  px-0" id="question0Option">
                                    <div class="row px-0">
                                        <div class="col-md-6  px-0">
                                            <div class="input-group mb-2  px-0">
                                                <input type="radio" answer="0" class="optionAnswer0 m-2 answer" name="answer[0][]">
                                                <input type="text" option="0" name="option[0][]" id="" placeholder="enter option" class="question0 form-control form-control-sm">
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6  px-0">
                                            <div class="input-group mb-2  px-0">
                                                <input type="radio" class="non-visible m-2">
                                                <input type="hidden" mark="0" name="mark[0][]" id="" placeholder="ENter Individual Mark" class="mark0 option-mark form-control form-control-sm">
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- first option  end here-->

                                    <div class="row  px-0">
                                        <div class="col-md-6  px-0">
                                            <!-- send option   start here-->
                                            <div class="input-group mb-2  px-0">
                                                <input type="radio" answer="1" class="optionAnswer0 m-2 answer" name="answer[0][]">
                                                <input type="text" option="1" name="option[0][]" id="" placeholder="enter option " class="question0 form-control form-control-sm">
                                                <!-- <input type="hidden" mark="${n}" name="mark[${qn}][]" id="" placeholder="individual Mark" class="mark${qn} mark form-control form-control-sm"> -->
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                        <!-- send option   start here-->
                                        <div class="col-md-6  px-0">
                                            <div class="input-group mb-2  px-0">
                                                <input type="radio" class="non-visible m-2">
                                                <!-- <input type="text" option="1" name="option[0][]" id="" placeholder="enter option " class="question0 form-control form-control-sm"> -->
                                                <input type="hidden" mark="1" name="mark[0][]" id="" placeholder="Enter Individual Mark" class="mark0 option-mark form-control form-control-sm">
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary" type="button" id="automatedAssignmentBtn">Submit</button>
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </fieldset>
            </div>
            <div class="tab-pane fade" id="submitted" role="tabpanel" aria-labelledby="submitted-tab">
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
            <div class="tab-pane fade" id="mark" role="tabpanel" aria-labelledby="mark-tab">
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
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="markTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Subject</th>
                            <th>Student</th>
                            <!-- <th>Date</th> -->
                            <th>Date Submitted</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div><!-- End Default Tabs -->
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {

        $('#submitted-tab').click(function() {
            loadAssessment()
        })
        $('#mark-tab').click(function() {
            loadSubmittedAssessments()
        })

        function loadSubmittedAssessments() {
            $('#markTable').DataTable({
                "processing": true,
                "serverSide": true,
                 
                responsive: true,
                destroy: true,
                "ajax": "{{route('load.submitted.assessments')}}",
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
                        "data": "fullname"
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
                                '<tr class="group"><td colspan="4">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }

        function loadAssessment() {
            $('#assignmentTable').DataTable({
                "processing": true,
                "serverSide": true,
                 
                responsive: true,
                destroy: true,
                "ajax": "{{route('load.assignment')}}",
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
                                '<tr class="group"><td colspan="5">' + group + '</td></tr>'
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

        // delete assessment 
        $(document).on('click', '.deleteAssessment', function() {

            Swal.fire({
                title: 'Delete Assessment',
                text: "Are you sure, you want to delete this ?",
                type: "warning",
                confirmButtonText: 'Yes Delete',
                confirmButtonColor: '#DD6B55',
                cancelButtonText: "No, Cancel!",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result) => {
                if (result['isConfirmed']) {
                    // Put your function here
                    const key = $(this).attr('key');
                    $('.overlay').show();
                    $.ajax({
                        url: "{{route('delete.assessment')}}", //"url,
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            key: key
                        },
                        success: function(data) {
                            console.log(data);
                            $('.overlay').hide();
                            if (data.status === 1) {
                                alert_toast(data.message);
                                loadAssessment()
                            } else {
                                alert_toast(data.message, 'error');
                            }
                        },
                        error: function(data) {

                            $('.overlay').hide();
                            alert_toast('Something Went Wrong', 'error');
                        }
                    });
                }
            })

        })
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
        $('.assessmentType').click(function() {
            const type = $(this).val();
            if (type == 1) {
                $('#newAssignmentFile').show(500);
                $('#newAssignmentQuestion').hide(500);
            } else {
                $('#newAssignmentFile').hide(500);
                $('#newAssignmentQuestion').show(500);
            }
        });
        $('#same_mark').click(function() {
            if ($(this).is(':checked')) {
                $('.sameMarkRow').hide(500);
                $('.option-mark').attr('type', 'hidden');
            } else {
                $('.sameMarkRow').show(500);
                $('.option-mark').show(500);
            }
        });

        $('#newManualAssignmentBtn').click(function() {
            submitFormAjax('newManualAssignmentForm', 'newManualAssignmentBtn', "{{route('submit.manual.assignment')}}");
            $('.summer-note').val('')

        });


        let qn = 0;
        let n = 2;
        $('#nextQuestion').click(function() {
            qn++;
            n = 2;
            $('#fieldQuestions').append(`
                <fieldset class="border rounded-3 p-3  px-0">
                                <legend class="float-none w-auto px-3">Question ${qn+1} <i class="bi bi-x-circle-fill btn-danger m-2 removeFieldsetBtn pointer"></i></legend>
                                <div class="row mb-2 px-0">
                                    <div class="col-md-6 px-0">
                                        Question Type
                                        <select name="types[]" id="type${qn}" type="${qn}" class="changeQuestionType form-select form-select-sm ">
                                            <option value="1">Single Select</option>
                                            <option value="2">Multi Select</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 px-0 sameMarkRow" style="display:none">
                                        <label for="">Score</label>
                                        <input name="marks[]" placeholder="allocate Score"  id="mark${qn}" question="${qn}" class="marks form-control form-control-sm">
                                    </div>
                                </div>
                                <textarea name="question[]" placeholder="Question ${qn+1}"  value="Question ${qn+1}" id="question${qn}" question="${qn}" class="questions form-control form-control-sm summer-note"></textarea>
                                <p class="text-danger question_error"></p>
                                <button type="button" id="question${qn}" question="${qn}" class="addMoreOption btn btn-sm btn-outline-success"><i class="bi bi-plus"></i></button>
                                <div class="col-md-8 m-3 px-0" id="question${qn}Option">
                                    <div class="row px-0">
                                        <div class="col-md-6 px-0">
                                            <div class="input-group mb-2 px-0">
                                                <input type="radio" answer="0" class="optionAnswer${qn} answer m-2" name="answer[${qn}][]">
                                                <input type="text" option="0" name="option[${qn}][]" id="" placeholder="enter option " class="question${qn} form-control form-control-sm">
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-0">
                                            <div class="input-group mb-2 px-0">
                                                <input type="radio" class="non-visible m-2">
                                                <input type="hidden" mark="0" name="mark[${qn}][]" id="" placeholder="enter individual mark " class="mark${qn} form-control form-control-sm">
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row px-0">
                                        <div class="col-md-6 px-0">
                                            <div class="input-group mb-2 px-0">
                                                <input type="radio" answer="1" class="optionAnswer${qn} answer m-2" name="answer[${qn}][]">
                                                <input type="text" option="1" name="option[${qn}][]" id="" placeholder="enter option " class="question${qn} form-control form-control-sm">
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-0">
                                            <div class="input-group mb-2 px-0">
                                                <input type="radio" class="non-visible m-2">
                                                <input type="hidden" mark="1" name="mark[${qn}][]" id="" placeholder="enter Individual Mark " class="mark${qn} form-control form-control-sm">
                                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
            `);
            $('.summer-note').summernote()
            if ($('#same_mark').is(':not(:checked)')) {
                $('.sameMarkRow').show(500);
            }
        })
        $('.summer-note').summernote()
        // remove question 
        $(document).on('click', '.removeFieldsetBtn', function() {
            $(this).parent().parent().remove()
        });

        // add option 
        $(document).on('click', '.addMoreOption', function() {
            n++
            let id = $(this).attr('id')
            let qn = $(this).attr('question')
            let type = $('#type' + qn).val();
            let mark = 'hidden';
            if (type == 2) {
                type = 'checkbox';
                if ($('#same_mark').is(':not(:checked)')) {
                    mark = 'number';
                    $('.mark' + qn).attr('type', mark)
                } else {
                    $('.mark' + qn).attr('type', mark)
                }
            } else {
                type = 'radio';
                $('.mark' + qn).attr('type', mark)
            }

            $('#' + id + 'Option').append(`
                <div class="row px-0">
                    <div class="col-md-6 px-0">
                        <div class="input-group mb-2 px-0">
                            <input type="${type}" answer="${n}" class="optionAnswer${qn} m-2 answers" name="answer[${qn}][]">
                            <input type="text" option="${n}" name="option[${qn}][]" id="" placeholder="enter option " class="question${qn} form-control form-control-sm">
                            <i class="bi bi-x-circle-fill btn-danger m-2 removeRowBtn pointer"></i>
                            </div>
                            </div>
                            <div class="col-md-6 px-0">
                            <div class="input-group mb-2 px-0">
                            <input type="radio" class="non-visible m-2">
                            <input type="${mark}" mark="${n}" name="mark[${qn}][]" id="" placeholder="Enter Individual Mark" class="mark${qn} option-mark form-control form-control-sm">
                            <i class="bi bi-x-circle-fill text-white m-2"></i>
                        </div>
                    </div>
                </div>
            `);
        });
        //    remove option 
        $(document).on('click', '.removeRowBtn', function() {
            $(this).parent().parent().parent().remove()
        });
        $(document).on('change', '.changeQuestionType', function() {
            let cls = $(this).attr('type');
            let type = $(this).val();

            let mark = 'hidden';
            if (type == 2) {
                type = 'checkbox';
                if ($('#same_mark').is(':not(:checked)')) {
                    mark = 'number';
                    $('.mark' + cls).attr('type', mark)
                } else {
                    $('.mark' + cls).attr('type', mark)
                }
            } else {
                type = 'radio';
                $('.mark' + cls).attr('type', mark)
            }
            $('.optionAnswer' + cls).attr('type', type);
        });

        // $('#automatedAssignmentBtn').click(function() {
        //     submitFormAjax('automatedAssignmentForm', 'automatedAssignmentBtn', "{{route('submit.automated.assignment')}}")
        // });
        $('#automatedAssignmentBtn').click(async function(e) {
            e.preventDefault()
            $('#automatedAssignmentForm').find('p.text-danger').text('');
            $('#automatedAssignmentBtn').prop('disabled', true);
            $('.overlay').show();
            const formData = new FormData($('#automatedAssignmentForm')[0])
            formData.delete("question[]");

            const questionArray = await sortQuestion();
            formData.append('questions', JSON.stringify(questionArray));
            $.ajax({
                url: "{{route('submit.automated.assignment')}}", //"url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#automatedAssignmentForm').find('p.text-danger').text('');
                    $('#automatedAssignmentBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#automatedAssignmentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                        $.each(data.error, function(prefix, val) {
                            let prfx = prefix.replace(".", "");
                            $('.' + prfx + '_error').text(val[0]);
                        });
                        // resolve(null)
                    } else if (data.status === 1) {
                        alert_toast(data.message, 'success');
                        $('#automatedAssignmentForm')[0].reset();
                        $('.summer-note').val('')
                    } else {
                        alert_toast(data.message, 'error');
                    }
                },
                error: function(data) {
                    $('#automatedAssignmentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });

        function sortQuestion() {
            return new Promise((resolve, reject) => {
                const questionArray = []
                const marks = $('.marks');
                $('.questions').each(function(j, obj) {

                    const question = $(this).val();
                    const mark = $(marks[j]).val();
                    const qn = $(this).attr('question');
                    // alert(qn + ' ' + question);
                    const options = $('.question' + qn)
                    const asignMark = $('.mark' + qn)
                    const answer = $('.optionAnswer' + qn)
                    const type = $('#type' + qn).val()
                    let questionOptions = [];
                    let selected;
                    for (let i = 0; i < options.length; i++) {
                        if (answer[i].checked == true) { //check if question is selected
                            selected = true;
                        } else {
                            selected = false;
                        }
                        questionOptions.push({
                            id: i + 1,
                            option: $(options[i]).val(),
                            correct: selected,
                            mark: $(asignMark[i]).val(),
                        })
                    }
                    questionArray.push({
                        question,
                        type,
                        mark,
                        options: questionOptions
                    })

                });

                resolve(questionArray)

            });

        }
    });
</script>
@endsection