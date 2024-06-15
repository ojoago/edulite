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
        <h5 class="card-title mr-4">Assignment</h5>
        <!-- Default Tabs -->
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
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {

    
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


        
        $('.summer-note').summernote({
            fontsize: '14'
        })
        // remove question 
       

   
    });
</script>
@endsection