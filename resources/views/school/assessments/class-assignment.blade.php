@extends('layout.mainlayout')
@section('title','Assignment')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet"> -->

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
                <button class="nav-link w-100" id="submitted-tab" data-bs-toggle="tab" data-bs-target="#submitted" type="button" role="tab" aria-controls="submitted" aria-selected="false">Assignments</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="manual" role="tabpanel" aria-labelledby="manual-tab">
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
                <fieldset class="border rounded-3 p-3">
                    <legend class="float-none w-auto px-3">New Assignment</legend>
                    <form class="row g-3 needs-validation" id="newManualAssignmentForm">
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
                        <div class="col-md-5">
                            <label class="form-label">Subject</label>
                            <select name="subject" id="newAssignmentSubjectSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger subject_error"></p>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Assignment Title</label>
                            <input type="text" class="form-control form-control-sm" name="title" id="newAssignmentScore" placeholder="e.g 5">
                            <p class="text-danger title_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mark</label>
                            <input type="number" class="form-control form-control-sm" name="mark" id="newAssignmentScore" placeholder="e.g 5">
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
                            <textarea name="question" id="newAssignmentQuestion" class="form-control form-control-sm summer-note"></textarea>
                            <p class="text-danger question_error"></p>
                        </div>
                        <div class="col-md-12" style="display:none">
                            <label class="form-label">File</label>
                            <input type="file" accept="pdf,docs" name="file" id="newAssignmentFile" class="form-control form-control-sm">
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
                <fieldset class="border rounded-3 p-3">
                    <legend class="float-none w-auto px-3">New Assignment</legend>
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
                        <div class="col-md-5">
                            <label class="form-label">Subject</label>
                            <select name="subject" id="newAutomatedAssignmentSubjectSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger subject_error"></p>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Assignment Title</label>
                            <input type="text" class="form-control form-control-sm" name="title" id="newAssignmentScore" placeholder="e.g 5">
                            <p class="text-danger title_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mark</label>
                            <input type="number" class="form-control form-control-sm" name="mark" id="newAssignmentScore" placeholder="e.g 5">
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
                        </div>

                        <div class="col-md-8" style="display:none" id="newAssignmentCaType">
                            <label class="form-label">Link to Assessment</label>
                            <select name="ca_title" id="newAssignmentCaTypeSelect2" style="width: 100%;" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger ca_title_error"></p>
                        </div>
                        <input type="hidden" name="type" id="newAutomatedAssignmentType" value="2" checked>

                        <div class="col-md-12">
                            <fieldset class="border rounded-3 p-3">
                                <legend class="float-none w-auto px-3">Question 1</legend>
                                Question Type 
                                <select name="type" id="questionType" class="" style="width: 200px !important;">
                                    <option value="1">Single Select</option>
                                    <option value="2">Multi Select</option>
                                </select>
                                <textarea name="question" id="newAssignmentQuestion1" class="form-control form-control-sm summer-note"></textarea>
                                <p class="text-danger question_error"></p>
                                Add Option 
                                
                            </fieldset>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary" type="button" id="newManualAssignmentBtn">Submit</button>
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
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="assignmentTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Subject</th>
                            <th>TItle</th>
                            <!-- <th>Date</th> -->
                            <th>Deadline</th>
                            <!-- <th></th> -->
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


<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {

        $('#submitted-tab').click(function() {
            $('#assignmentTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
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
            });
        })

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
        $('.summer-note').summernote()
        $('#newManualAssignmentBtn').click(function() {
            submitFormAjax('newManualAssignmentForm', 'newManualAssignmentBtn', "{{route('submit.manual.assignment')}}")
        })
    });
</script>
@endsection