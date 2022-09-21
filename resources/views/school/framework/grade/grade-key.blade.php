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
            <!-- <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">Cho</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-justified" type="button" role="tab" aria-controls="contact" aria-selected="false">Ef</button>
            </li> -->
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createGradeKeyModal">
                    Create Grade
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="GradeKeyTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Grade</th>
                            <th>Grade Point</th>
                            <th>Remark</th>
                            <th>Min Score</th>
                            <th>Max Score</th>
                            <th>Date</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                Nesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
            </div>
            <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab">
                Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create school term modal  -->
<div class="modal fade" id="createGradeKeyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Grade </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createGradeKeyForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="title" id="title" maxlength="20" placeholder="ass title" class="form-control form-control-sm" required>
                            <p class="text-danger title_error"></p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="min_score" id="min_score" min="0" maxlength="4" placeholder="min" class="form-control form-control-sm" required>
                            <p class="text-danger min_score_error"></p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="max_score" id="max_score" maxlength="4" max="100" placeholder="max" class="form-control form-control-sm" required>
                            <p class="text-danger max_score_error"></p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="grade" placeholder="grade" maxlength="15" id="grade" class="form-control form-control-sm" required>
                            <p class="text-danger grade_error"></p>
                        </div>
                        <div class="col-md-6">
                            <input type="number" minimum="1" name="grade_point" maxlength="2" id="grade_point" class="form-control form-control-sm" placeholder="point" required>
                            <p class="text-danger grade_point_error"></p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="color" id="color" placeholder="color" class="form-control form-control-sm" required>
                            <p class="text-danger color_error"></p>
                        </div>
                    </div>

                    <textarea type="text" name="remark" id="remark" placeholder="remark" maxlength="30" class="form-control form-control-sm" required></textarea>
                    <p class="text-danger remark_error"></p>
                    <select type="text" name="category_pid" id="gradeCategorySelect2" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <select type="text" name="session_pid" id="gradeSessionSelect2" class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <select type="text" name="class_pid" id="gradeClassSelect2" class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <select type="text" name="term_pid" id="gradeTermSelect2" class="form-control form-control-sm" placeholder="" required style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p>

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

        // load school session
        $('#GradeKeyTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "get",
            "ajax": "{{route('load.school.grade.key')}}",
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "grade"
                },
                {
                    "data": "grade_point"
                },
                {
                    "data": "remark"
                },
                {
                    "data": "min_score"
                },
                {
                    "data": "max_score"
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
            $('.overlay').show();
            $.ajax({
                url: "{{route('school.grade.key')}}",
                type: "POST",
                data: new FormData($('#createGradeKeyForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createGradeKeyForm').find('p.text-danger').text('');
                    $('#createGradeKeyBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
                    $('#createGradeKeyBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#title').val('')
                        $('#min_score').val('')
                        $('#max_score').val('')
                        $('#grade').val('')
                        $('#grade_point').val('')
                        $('#color').val('')
                        $('#remark').val('')
                        // $('#createGradeKeyForm')[0].reset();
                    }
                },
                error: function(data) {
                    $('#createGradeKeyBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });

    });
</script>

@endsection