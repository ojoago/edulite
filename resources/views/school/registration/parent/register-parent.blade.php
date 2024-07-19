@extends('layout.mainlayout')
@section('title','lite create Std')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Register Parent
            <button class="btn btn-primary btn-sm" data-bs-target="#addParentModal" data-bs-toggle="modal">Link</button>

        </h5>
        <style>
            #linkStudentPart,
            .formS {
                display: block !important;
            }

            .modalS {
                display: none !important;

            }
        </style>
        <!-- Multi Columns Form -->
        @include('layout.forms.parent-form')
        <div class="text-center">
            <button type="button" class="btn btn-primary" id="createParentBtn">Create</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
        <!-- End Multi Columns Form -->

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#passport').change(function() {
            previewImg(this, '#parentPassport');
        });
        // load dropdown  
        // state select2 
        FormMultiSelect2('#stateSelect2', 'state', 'Select State of Origin')
        FormMultiSelect2('#studentSelect2', 'student', 'Select student')
        $('#stateSelect2').change(function() {
            var id = $(this).val();

            FormMultiSelect2Post('#lgaSelect2', 'state-lga', id, 'Select Lga of Origin')
        });


        // create school category 
        $('#createStudentBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('register.parent')}}",
                type: "POST",
                data: new FormData($('#createStudentForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                beforeSend: function() {
                    $('#createStudentForm').find('p.text-danger').text('');
                    $('#createStudentBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#createStudentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 1) {
                        alert_toast(data.message, 'success');
                        $('#createStudentForm')[0].reset();
                    } else {
                        alert_toast(data.message, 'warning');
                    }
                },
                error: function(data) {
                    console.log(data);
                    $('#createStudentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // create school class 
    });
</script>
@endsection