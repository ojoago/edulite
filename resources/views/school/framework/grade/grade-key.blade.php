@extends('layout.mainlayout')
@section('title','School Grade Key')
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
            <div class="tab-pane fade" id="class-grade" role="tabpanel">
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classGradeKeyTable">
                    <thead>
                        <tr>
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
            <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab">
                Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create school term modal  -->
<div class="modal fade" id="createGradeKeyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Grade </h5>
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
                    <select type="text" name="class_pid" id="gradeClassSelect2" class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <!-- <select type="text" name="term_pid" id="gradeTermSelect2" class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p> -->

                    <div class="text-center">
                        <button type="button" class="btn btn-danger btn-sm" id="addMore" title="Add More" data-bs-toggle="tooltip"><i class="bi bi-plus-circle"></i> </button>

                    </div>

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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createGradeKeyBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        let i = 0;
        $('#addMore').click(function() {
            i++;
            $('#moreRows').append(
                `
                <div class="row">
                     <div class="text-center">
                        <button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-x-circle-fill text-white"></i> </button>
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
        // load school grade
        $('#GradeKeyTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "get",
            "ajax": "{{route('load.school.grade.key')}}",
            "columns": [

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
        $('#classGradeKeyTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "get",
            "ajax": "{{route('load.school.grade.key')}}",
            "columns": [

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


        $('#createGradeKeyBtn').click(function() {
            submitFormAjax('createGradeKeyForm', 'createGradeKeyBtn', "{{route('school.grade.key')}}");
        });

    });
</script>

@endsection