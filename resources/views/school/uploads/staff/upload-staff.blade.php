@extends('layout.mainlayout')
@section('title','Upload Staff')
@section('content')
<div class="section min-vh-50 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="card justify-content-center shadow">
        <form class="row g-3 p-4" enctype='multipart/form-data' id="uploadStaffForm">
            @csrf
            <div class="col-12 p-4">
                <p>Click on the button below to download template</p>
                <a href="{{asset('files/excel-template/staff-template.xlsx')}}"> <button class="btn btn-sm btn-success" type="button">download</button> </a>
            </div>
            <p class="errors text-danger"></p>
            <div class="col-12">
                <label class="form-label">File</label>
                <input type="file" class="form-control form-control-sm" name="file">
                <p class="text-danger file_error"></p>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="button" id="uploadStaffBtn">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        // create school category 
        $('#uploadStaffBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('upload.staff')}}",
                type: "POST",
                data: new FormData($('#uploadStaffForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                beforeSend: function() {
                    $('#uploadStaffForm').find('p.text-danger').text('');
                    $('#uploadStaffForm').find('p.errors').text('');
                    $('#uploadStaffBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#uploadStaffBtn').prop('disabled', false);
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
                        $('#uploadStaffForm')[0].reset();
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
                    $('#uploadStaffBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // create school class 
    });
</script>
@endsection