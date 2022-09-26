@extends('layout.mainlayout')
@section('title','Upload Parents')
@section('content')
<div class="section min-vh-50 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="card justify-content-center shadow">
        <form class="row g-3 p-4" id="uploadParentForm">
            @csrf
            <div class="col-12">
                <p>Click on the button below to download template</p>
                <a href="{{asset('files/excel-template/parent-template.xlsx')}}"> <button type="button" class="btn btn-sm btn-success">download</button> </a>
            </div>
            <p class="errors text-danger"></p>
            <div class="col-12">
                <label class="form-label">File</label>
                <input type="file" class="form-control form-control-sm" name="file">
                <p class="text-danger file_error"></p>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="button" id="uploadParentBtn">Submit</button>
            </div>
        </form>
    </div>
</div>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // upload Parent
        $('#uploadParentBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('upload.parent')}}",
                type: "POST",
                data: new FormData($('#uploadParentForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                beforeSend: function() {
                    $('#uploadParentForm').find('p.text-danger').text('');
                    $('#uploadParentForm').find('p.errors').text('');
                    $('#uploadParentBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#uploadParentBtn').prop('disabled', false);
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
                        $('#uploadParentForm')[0].reset();
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
                    $('#uploadParentBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // create school class 
    });
</script>
@endsection