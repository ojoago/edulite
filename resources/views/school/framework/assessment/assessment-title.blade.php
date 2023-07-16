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
                <table class="table table-hover table-striped cardTable" id="title-dataTable" width="100%">
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
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createScoreSettingModal">
                    Create Score Setting
                </button>
                <table class="table table-hover table-striped cardTable" id="scoreDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Title</th>
                            <th>Order</th>
                            <th>Score</th>
                            <th>Category</th>
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
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Assessment title">
                    <p class="text-danger title_error"></p>
                    <select type="number" name="category" class="form-control form-control-sm">
                        <option disabled selected>Select Category</option>
                        <option value="1" selected>General</option>
                        <option value="2">Mid Term</option>
                    </select>
                    <p class="text-danger category_error"></p>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="assessment description" required></textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createAssessmentBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->


<div class="modal fade" id="createScoreSettingModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Score Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createScoreSettingForm">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                @csrf
                                <!-- <select type="text" name="session_pid" id="cssSessionSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger session_pid_error"></p> -->
                                <select name="category_pid" id="cssCategorySelect2" style="width: 100%;">
                                </select>
                                <p class="text-danger category_pid_error"></p>
                                <select type="text" name="class_pid" id="cssClassSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger class_pid_error"></p>
                                <!-- <select type="text" name="term_pid" id="cssTermSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger term_pid_error"></p> -->
                            </div>
                            <div class="col-md-5">
                                <h5 class="text-danger">The Sum of Score Settings has to be equal to 100</h5>

                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-info">
                                Title will appear on student result in the other they are entered.
                                I.e if you enter exam first then from left to right exam will appear before other student assessment titles
                            </p>
                            <!-- Multiple ? <input class="custom-check m-1" name="keekVal" type="checkbox" id="gridCheck2"> -->

                            <button id="addMore" type="button" class="btn btn-danger btn-sm btn-small m-1">Add More Row</button>
                            <p class="text-danger title_pid_error"></p>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <select type="text" name="title_pid[]" id="titleSelect0" style="width:100%;" class="titleSelect2 form-control form-control-sm">
                                </select>
                                <p class="text-danger title_pid0_error"></p>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" step=".0" min="1" max="100" class="form-control form-control-sm" name="score[]" placeholder="obtainable score">
                                    <span class="input-group-text">Mid-Term?</span>
                                    <input class="custom-check m-1" value="2" name="mid[]" type="checkbox" id="gridCheck2">
                                    <i class="bi bi-x-circle-fill text-danger hidden-item m-2"></i>
                                </div>
                                <p class="text-danger score0_error"></p>
                            </div>
                        </div>
                        <div id="settingParams"></div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="createScoreSettingBtn">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <!-- <button id="resetForm" type="reset" class="btn btn-warning btn-sm btn-small m-3">Reset</button> -->
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
                    "data": "date"
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
                    "data": "class"
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
        multiSelect2('#cssSessionSelect2', 'createScoreSettingModal', 'session', 'Select Session');
        multiSelect2('#cssTermSelect2', 'createScoreSettingModal', 'term', 'Select Term');
        multiSelect2('#cssCategorySelect2', 'createScoreSettingModal', 'category', 'Select Category');
        $('#cssCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#cssClassSelect2', 'createScoreSettingModal', 'class', id, 'Select Class');
        });


        // title dropdown 
        var pid = 0;
        titleDropDown(pid)

        function titleDropDown(id) {
            var id = '#titleSelect' + id;
            multiSelect2(id, 'createScoreSettingModal', 'title', 'Select Title');
        }
        // add more title 
        $('#addMore').click(function() {
            pid++
            $('#settingParams').append(
                `
                 <div class="row addedRow">
                            <div class="col-md-5">
                                <select type="text" name="title_pid[]" id="titleSelect${pid}" style="width:100%;" class="titleSelect2 form-control form-control-sm">
                                </select>
                                <p class="text-danger title_pid${pid}_error"></p>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" step=".0" min="1" max="100" class="form-control form-control-sm" name="score[]" placeholder="obtainable score">
                                    <span class="input-group-text">Mid-Term?</span>
                                    <input class="custom-check m-1" value="2" name="mid[]" type="checkbox" id="gridCheck2">
                                    <i class="bi bi-x-circle-fill text-danger removeRowBtn pointer m-2"></i>
                                </div>
                                <p class="text-danger score${pid}_error"></p>
                            </div>
                        </div>`
            );
            // init select2 again 
            titleDropDown(pid);
        });

        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });

        // validate signup form on keyup and submit
        $('#createAssessmentBtn').click(function(e) {
            e.preventDefault()
            submitFormAjax('createAssessmentForm', 'createAssessmentBtn', "{{route('school.assessment.title')}}")
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