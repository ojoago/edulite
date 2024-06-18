@extends('layout.mainlayout')
@section('title','Grade Key')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Grade Key</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab" aria-controls="home" aria-selected="true">Grade Key</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-grade-tab" data-bs-toggle="tab" data-bs-target="#class-grade" type="button" role="tab">Classes Grade</button>
            </li>
            <!-- <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-justified" type="button" role="tab" aria-controls="contact" aria-selected="false">Ef</button>
            </li> -->
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createGradeKeyModal">
                    Create Grade
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="GradeKeyTable">
                    <thead>
                        <tr>
                            <th>Arm</th>
                            <th>Grade</th>
                            <th>Title</th>
                            <th>Min Score</th>
                            <th>Max Score</th>
                            <th>Grade Point</th>
                            <th>Remark</th>
                            {{-- <th>Date</th> --}}
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="class-grade" role="tabpanel">
                <small class="info">This is will be computed by system when school enter student termly score</small>
                <div class="row mb-3 mt-2">
                    <div class="col-md-3">
                        <select name="category_pid" id="classGradeKeyCategorySelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="class_pid" id="classGradeKeyClassSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                   
                    <div class="col-md-3">
                        <select name="session_pid" id="classGradeKeySessionSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="term_pid" id="classGradeKeyTermSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classGradeKeyTable">
                    <thead>
                        <tr>
                            <th>Arm</th>
                            <th>Term</th>
                            <th>Session</th>
                            <th>Grade</th>
                            <th>Title</th>
                            <th>Min Score</th>
                            <th>Max Score</th>
                            <th>Grade Point</th>
                            <th>Remark</th>
                            <th>Date</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
           
        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create school term modal  -->
<div class="modal fade" id="createGradeKeyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Assessment Grade </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createGradeKeyForm">
                    @csrf

                    <select type="text" name="category_pid" id="gradeCategorySelect2" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <!-- <select type="text" name="session_pid" id="gradeSessionSelect2" class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p> -->
                    <select type="text" name="class_pid[]" id="gradeClassSelect2" multiple class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <!-- <select type="text" name="term_pid" id="gradeTermSelect2" class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p> -->

                    <div class="row">
                        <div class="col-md-6">
                            <label for=""><small>Grade</small></label>
                            <input type="text" name="grade[]" placeholder="grade e.g AB" maxlength="3" id="grade" class="form-control form-control-sm" required>
                            <p class="text-danger grade0_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for=""><small>Grade Title</small></label>
                            <input type="text" name="title[]" id="title" maxlength="15" placeholder="Grade Title e.g V.Good" class="form-control form-control-sm" required>
                            <p class="text-danger titleo_error"></p>
                        </div>

                        <div class="col-md-6">
                            <input type="text" name="min_score[]" id="min_score" min="0" maxlength="4" placeholder="min" class="form-control form-control-sm" required>
                            <p class="text-danger min_score0_error"></p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="max_score[]" id="max_score" maxlength="4" max="100" placeholder="max" class="form-control form-control-sm" required>
                            <p class="text-danger max_score0_error"></p>
                        </div>

                        <div class="toggle-v" style="display: none;">
                            <div class="col-md-6">
                                <input type="number" minimum="1" name="grade_point" maxlength="2" id="grade_point" class="form-control form-control-sm" placeholder="point" required>
                                <p class="text-danger grade_point0_error"></p>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="color" id="color" placeholder="color" class="form-control form-control-sm" required>
                                <p class="text-danger color0_error"></p>
                            </div>
                            <div class="col-md-12">
                                <textarea type="text" name="remark" id="remark" placeholder="remark" maxlength="30" class="form-control form-control-sm" required></textarea>
                                <p class="text-danger remark0_error"></p>
                            </div>
                        </div>
                    </div>
                    <div id="moreRows"></div>
                     <div class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" id="addMore" title="Add More"><i class="bi bi-plus-circle"></i> </button>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createGradeKeyBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let i = 0;
        $('#addMore').click(function() {
            i++;
            $('#moreRows').append(
                `
                <div class="row">
                     <div class="float-end">
                        <i class="bi bi-x-circle-fill text-danger removeRow pointer"></i> 
                    </div>
                        <div class="col-md-6">
                            <label for=""><small>Grade</small></label>
                            <input type="text" name="grade[]" placeholder="grade e.g AB" maxlength="3" id="grade" class="form-control form-control-sm" required>
                            <p class="text-danger grade${i}_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for=""><small>Grade Title</small></label>
                            <input type="text" name="title[]" id="title" maxlength="15" placeholder="Grade Title e.g V.Good" class="form-control form-control-sm" required>
                            <p class="text-danger title${i}_error"></p>
                        </div>

                        <div class="col-md-6">
                            <input type="text" name="min_score[]" id="min_score" min="0" maxlength="4" placeholder="min" class="form-control form-control-sm" required>
                            <p class="text-danger min_score${i}_error"></p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="max_score[]" id="max_score" maxlength="4" max="100" placeholder="max" class="form-control form-control-sm" required>
                            <p class="text-danger max_score${i}_error"></p>
                        </div>

                        <div class="toggle-v" style="display: none;">
                            <div class="col-md-6">
                                <input type="number" minimum="1" name="grade_point" maxlength="2" id="grade_point" class="form-control form-control-sm" placeholder="point" required>
                                <p class="text-danger grade_point${i}_error"></p>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="color" id="color" placeholder="color" class="form-control form-control-sm" required>
                                <p class="text-danger color${i}_error"></p>
                            </div>
                            <div class="col-md-12">
                                <textarea type="text" name="remark" id="remark" placeholder="remark" maxlength="30" class="form-control form-control-sm" required></textarea>
                                <p class="text-danger remark${i}_error"></p>
                            </div>
                        </div>
                    </div>
                `
            );
        })
        $(document).on('click', '.row .removeRow', function() {
            $(this).parent().parent().remove()
        });
        loadGradeKey()
        // load school grade
        function loadGradeKey(){
            $('#GradeKeyTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            responsive: true,
            type: "get",
            "ajax": "{{route('load.school.grade.key')}}",
            "columns": [

                {
                    "data": "class"
                },
                {
                    "data": "grade"
                },
                {
                    "data": "title"
                },

                {
                    "data": "min_score"
                },
                {
                    "data": "max_score"
                },
                {
                    "data": "grade_point"
                },
                {
                    "data": "remark"
                },
                // {
                //     "data": "created_at"
                // },
                // {
                //     "data": "action"
                // },
                ],
                "columnDefs": [{
                    targets: [0],
                    visible: false
                },
                // {
                //     targets: [5],
                //     className: "align-right"
                // }
            ],
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(0, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="8">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
            });
        }
        // filter class subject 
        FormMultiSelect2('#classGradeKeyCategorySelect2', 'category', 'Select Category');
        FormMultiSelect2('#classGradeKeyTermSelect2', 'term', 'Select Term');
        FormMultiSelect2('#classGradeKeySessionSelect2', 'session', 'Select Session');
        $('#classGradeKeyCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#classGradeKeyClassSelect2', 'class', id, 'Select Class');
        });
        $('#classGradeKeyClassSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#classGradeKeyArmSelect2', 'class-arm', id, 'Select Class Arm');
        });


        multiSelect2('#ctCategorySelect2', 'createclassGradeKeyModal', 'category', 'Select Category');
        $('#ctCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#ctClassSelect2', 'createclassGradeKeyModal', 'class', id, 'Select Class');
        });
        $('#ctClassSelect2').on('change', function(e) {
            var pid = $(this).val();
            multiSelect2Post('#ctArmSelect2', 'createclassGradeKeyModal', 'class-arm', pid, 'Select Class Arm');
            // var id = ;
            multiSelect2Post('#ctArmSubjects0', 'createclassGradeKeyModal', 'all-arms-subject', pid, 'Select Class Subject');
        });

        $('#classGradeKeyTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            responsive: true,
            type: "get",
            "ajax": "{{route('load.class.grade.key')}}",
            "columns": [

                {
                    "data": "arm"
                },
                {
                    "data": "term"
                },
                {
                    "data": "session"
                },

                {
                    "data": "grade"
                },
                {
                    "data": "title"
                },

                {
                    "data": "min_score"
                },
                {
                    "data": "max_score"
                },
                {
                    "data": "grade_point"
                },
                {
                    "data": "remark"
                },
                {
                    "data": "created_at"
                },
                // {
                //     "data": "action"
                // },
            ],
        });

        // load dropdown on 

        // multiSelect2('categorySelect2', 'createClassArmModal', sbjCategoryselect2Url, 'Select Category');
        multiSelect2('#gradeSessionSelect2', 'createGradeKeyModal', 'session', 'Select Session');
        multiSelect2('#gradeTermSelect2', 'createGradeKeyModal', 'term', 'Select Term');
        multiSelect2('#gradeCategorySelect2', 'createGradeKeyModal', 'category', 'Select Category');
        $('#gradeCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#gradeClassSelect2', 'createGradeKeyModal', 'class', id, 'Select Class');
        });


        $('#createGradeKeyBtn').click(async function() {
            let s = await submitFormAjax('createGradeKeyForm', 'createGradeKeyBtn', "{{route('school.grade.key')}}");
            if(s.status == 1){
                // loadGradeKey()
            }
        });

    });
</script>

@endsection