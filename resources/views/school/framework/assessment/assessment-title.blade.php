@extends('layout.mainlayout')
@section('title','Assessment setup')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Assessment/Score</h5>
        <!-- Bordered Tabs Justified -->
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="assessment-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-assessment" type="button" role="tab" aria-controls="assessment" aria-selected="true">Assessment</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="scoreSetting-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-scoreSetting" type="button" role="tab" aria-controls="scoreSetting" aria-selected="false">Score Setting</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="bordered-justified-assessment" role="tabpanel" aria-labelledby="assessment-tab">
                <!-- Create assessment -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createAssessmentModal">
                    Create Assessment
                </button>
                <table class="table table-hover table-striped" id="title-dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="bordered-justified-scoreSetting" role="tabpanel" aria-labelledby="scoreSetting-tab">
                <!-- Create Session -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createScoreSettingModal">
                    Create Score Setting
                </button>
                <table class="table table-hover table-striped" id="scoreDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Session</th>
                            <th>Class</th>
                            <th>Term</th>
                            <th>Title</th>
                            <th>Order</th>
                            <th>Score</th>
                            <th>Display</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div><!-- End Bordered Tabs Justified -->

    </div>
</div>

<div class="modal fade" id="createAssessmentModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Assessment Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createAssessmentForm">
                    @csrf
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="ass title">
                    <p class="text-danger title_error"></p>
                    <select type="number" name="category" class="form-control form-control-sm">
                        <option disabled selected>Select Category</option>
                        <option value="1">General</option>
                        <option value="2">Mid Term</option>
                    </select>
                    <p class="text-danger category_error"></p>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="assessment description" required></textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createAssessmentBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->


<div class="modal fade" id="createScoreSettingModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set lite Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createScoreSettingForm">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                @csrf
                                <select type="text" name="session_pid" id="sessionSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger session_pid_error"></p>
                                <select name="category_pid" id="categorySelect2" style="width: 100%;">
                                </select>
                                <p class="text-danger category_pid_error"></p>
                                <select type="text" name="class_pid" id="classSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger class_pid_error"></p>
                                <select type="text" name="term_pid" id="termSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger term_pid_error"></p>
                            </div>
                            <div class="col-md-5">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Placeat asperiores dolorem sapiente ipsa atque voluptatem, beatae numquam, assumenda consectetur ad veniam veritatis aspernatur est, esse eos quia. Sunt, sit vitae.
                            </div>
                        </div>
                        <div class="text-center">
                            Multiple ? <input class="custom-check m-1" name="keekVal" type="checkbox" id="gridCheck2">

                            <button id="addMore" type="button" class="btn btn-danger btn-sm btn-small m-1">Add More Row</button>
                            <p class="text-danger titles_pid_error"></p>
                        </div>

                        <div class="row" id="inputRow">
                            <div class="col-md-5">
                                <p class="text-danger title_pid_error"></p>
                            </div>
                            <div class="col-md-7">
                                <p class="text-danger score_error"></p>
                            </div>
                        </div>
                        <div id="settingParams"></div>
                        <div class="row">
                            <div class="col-md-5">
                                <select type="text" name="title_pid[]" id="titleSelect2" style="width:100%;" class="titleSelect2 form-control form-control-sm">
                                </select>
                                <p class="text-danger title_pid_error_"></p>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" step=".0" min="1" max="100" class="form-control form-control-sm" name="score[]" placeholder="obtainable score">
                                    <span class="input-group-text">Mid-Term?</span>
                                    <input class="custom-check m-1" value="2" name="mid[]" type="checkbox" id="gridCheck2">
                                    <i class="bi bi-x-circle-fill text-danger hidden-item m-2"></i>
                                </div>
                                <p class="text-danger score_error_"></p>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="createScoreSettingBtn">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="resetForm" type="reset" class="btn btn-warning btn-sm btn-small m-3">Reset</button>
        </div>
    </div>
</div>
</div><!-- End Basic Modal-->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // load school session
        $('#title-dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.school.assessment.title')}}",
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "description"
                },
                {
                    "data": "category"
                },
                {
                    "data": "created_at"
                },
                // {
                //     "data": "action"
                // },
            ],
        });
        $('#scoreDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.score.setting')}}",
            "columns": [{
                    "data": "session"
                },
                {
                    "data": "class"
                },
                {
                    "data": "term"
                },
                {
                    "data": "title"
                },
                {
                    "data": "order"
                },
                {
                    "data": "score"
                },
                {
                    "data": "type"
                },
                {
                    "data": "date"
                },
                 
            ],
        });

        // validate signup form on keyup and submit
        $('#createAssessmentBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('school.assessment.title')}}",
                type: "POST",
                data: new FormData($('#createAssessmentForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createAssessmentForm').find('p.text-danger').text('');
                    $('#createAssessmentBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#createAssessmentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill the form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('p.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createAssessmentForm')[0].reset();
                    }
                },
                error: function(data) {
                    $('#createAssessmentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });


        // load active session 
        $('#active-term-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('load.school.active.term')}}",
            "columns": [{
                    "data": "term"
                },
                {
                    "data": "begin"
                },
                {
                    "data": "end"
                },
                {
                    "data": "note"
                },
            ],
        });

        // multiSelect2('categorySelect2', 'createClassArmModal', sbjCategoryselect2Url, 'Select Category');
        multiSelect2('sessionSelect2', 'createScoreSettingModal', 'session', 'Select Session');
        multiSelect2('termSelect2', 'createScoreSettingModal', 'term', 'Select Term');
        multiSelect2('categorySelect2', 'createScoreSettingModal', 'category', 'Select Category');
        $('#categorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('classSelect2', 'createScoreSettingModal', 'class', id, 'Select Class');
        });


        // title dropdown 
        var pid = 2;
        titleDropDown(pid)

        function titleDropDown(id) {
            var id = 'titleSelect' + id;
            multiSelect2(id, 'createScoreSettingModal', 'title', 'Select Title');
        }
        // add more title 
        $('#addMore').click(function() {
            pid++
            $('#settingParams').prepend(
                `
                 <div class="row addedRow">
                            <div class="col-md-5">
                                <select type="text" name="title_pid[]" id="titleSelect${pid}" style="width:100%;" class="titleSelect2 form-control form-control-sm">
                                </select>
                                <p class="text-danger title_pid_error_"></p>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" step=".0" min="1" max="100" class="form-control form-control-sm" name="score[]" placeholder="obtainable score">
                                    <span class="input-group-text">Mid-Term?</span>
                                    <input class="custom-check m-1" value="2" name="mid[]" type="checkbox" id="gridCheck2">
                                    <i class="bi bi-x-circle-fill text-danger removeRowBtn pointer m-2"></i>
                                </div>
                                <p class="text-danger score_error_"></p>
                            </div>
                        </div>`
            );
            // init select2 again 
            titleDropDown(pid);
        });

        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });


        // create score seeting 
        $('#createScoreSettingBtn').click(function(e) {
            let route = "{{route('create.school.score.settings')}}";
            e.preventDefault()
            submitFormAjax('createScoreSettingForm', 'createScoreSettingBtn', route);
        });
    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->