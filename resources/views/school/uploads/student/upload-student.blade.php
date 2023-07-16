@extends('layout.mainlayout')
@section('title','Upload Students')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Upload Student for <span class="text-danger"> {{activeTermName()}} {{activeSessionName()}}</span> </h5>
        <form class="row g-3" id="uploadStudentForm">
            <div class="col-12">
                <p>Click on the button below to download template</p>
                <a href="{{asset('files/excel-template/student-template.xlsx')}}"> <button type="button" class="btn btn-sm btn-success">download</button> </a>
            </div>
            @csrf
            <!-- <div class="col-md-6">
                <label for="state" class="form-label">Session </label>
                <select name="session_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="sessionSelect2" required>
                </select>
                <p class="text-danger session_pid_error"></p>
            </div>
            <div class="col-md-6">
                <label for="term_pid" class="form-label">Term</label>
                <select name="term_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="tmSelect2" required>
                </select>
                <p class="text-danger term_pid_error"></p>
            </div> -->
            <div class="col-md-4">
                <label for="category_pid" class="form-label">Category</label>
                <select name="category_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="cateSelect2" required>
                </select>
                <p class="text-danger category_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="class_pid" class="form-label">Class</label>
                <select name="class_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="classSelect2" required>
                </select>
                <p class="text-danger class_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="arm_pid" class="form-label">Class Arm</label>
                <select name="arm_pid" class="form-select form-select-sm readOnlyProp" style="width: 100%;" id="armSelect2" required>
                </select>
                <p class="text-danger arm_pid_error"></p>
            </div>
            <p class="errors text-danger"></p>
            <div class="col-12 p-4">
                <label class="form-label">File</label>
                <input type="file" class="form-control form-control-sm" name="file">
                <p class="text-danger file_error"></p>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary" id="uploadStudentBtn">Upload</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
        <!-- End Multi Columns Form -->

    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {


        // session select2 
        FormMultiSelect2('#sessionSelect2', 'session', 'Select Session')

        FormMultiSelect2('#cateSelect2', 'category', 'Select Category')

        // class dropdown 
        $('#cateSelect2').change(function() {
            var id = $(this).val();
            FormMultiSelect2Post('#classSelect2', 'class', id, 'Select Class')
        });

        // class arm dropdown 
        $('#classSelect2').change(function() {
            var id = $(this).val();
            FormMultiSelect2Post('#armSelect2', 'class-arm', id, 'Select Class Arm')
        });

        // term dropdown 
        FormMultiSelect2('#tmSelect2', 'term', 'Select Term')

        // create school category 
        $('#uploadStudentBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('upload.student')}}",
                type: "POST",
                data: new FormData($('#uploadStudentForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                beforeSend: function() {
                    $('#uploadStudentForm').find('p.text-danger').text('');
                    $('#uploadStudentForm').find('p.errors').text('');
                    $('#uploadStudentBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#uploadStudentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    console.log(data.errors);
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 1) {
                        $.each(data.errors, function(prefix, val) {
                            let error = val + '<br>';
                            $('.errors').append(error);
                        });
                        alert_toast(data.message, 'success');
                        $('#uploadStudentForm')[0].reset();
                    } else {
                        $.each(data.errors, function(prefix, val) {
                            let error = val + '<br>';
                            $('.errors').append(error);
                        });
                        alert_toast(data.message, 'warning');
                    }
                },
                error: function(data) {
                    console.log(data);
                    $('#uploadStudentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
    });
</script>
@endsection