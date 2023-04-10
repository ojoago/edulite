@extends('layout.mainlayout')
@section('title','lite create Staff')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Register Staff</h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" id="createStaffForm" enctype='multipart/form-data'>
            @csrf
            <div class="col-md-4">
                <label for="firstname" class="form-label">First-Name <small class="text-danger">*</small></label>
                <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" placeholder="e.g OJOago" required>
                <p class="text-danger firstname_error"></p>
            </div>
            <div class="col-md-4">
                <label for="lastname" class="form-label">Last-Name <small class="text-danger">*</small></label>
                <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" placeholder="e.g Otteh" required>
                <p class="text-danger lastname_error"></p>
            </div>
            <div class="col-md-4">
                <label for="othername" class="form-label">Other-Name</label>
                <input type="text" class="form-control form-control-sm" id="othername" name="othername" placeholder="e.g oceje">
            </div>
            <div class="col-md-4">
                <label for="gsm" class="form-label">Phone Number <small class="text-danger">*</small></label>
                <input type="text" class="form-control form-control-sm" maxlength="11" id="gsm" name="gsm" placeholder="e.g 070-XX-XX-XX-XX" required>
                <p class="text-danger gsm_error"></p>
            </div>
            <div class="col-md-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control form-control-sm mr-1" id="username" name="username" placeholder="e.g endowed01">
                <p class="text-danger username_error"></p>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="e.g eulite@gmail.com">
                <p class="text-danger email_error"></p>
            </div>
            <div class="col-md-3">
                <label for="title" class="form-label">Title</label>
                <select id="titleSelect2" name="title" class="form-select  form-select-sm" style="width: 100%;">
                    <option disabled selected>Select Title</option>
                    <option>Mr</option>
                    <option>Mrs</option>
                    <option>Mss</option>
                    <option>Dr</option>
                    <option>Prof</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="gender" class="form-label">Gender <small class="text-danger">*</small></label>
                <select id="gender" name="gender" class="form-select form-select-sm">
                    <option disabled selected>Select Gender</option>
                    <option value="2">Female</option>
                    <option value="1">Male</option>
                </select>
                <p class="text-danger gender_error"></p>
            </div>
            <div class="col-md-3">
                <label for="dob" class="form-label">Date Of Birth <small class="text-danger">*</small></label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob" required>
                <p class="text-danger dob_error"></p>
            </div>
            <div class="col-md-3">
                <label for="religion" class="form-label">Religion</label>
                <select id="religion" name="religion" class="form-select form-select-sm">
                    <option disabled selected>Select Religion</option>
                    <option value="2">Christian</option>
                    <option value="1">Muslim</option>
                    <option value="3">Other</option>
                </select>
                <p class="text-danger religion_error"></p>
            </div>

            <div class="col-md-4">
                <label for="state" class="form-label">Primary Role <small class="text-danger">*</small></label>
                <select id="roleSelect2" name="role" class="form-select form-select-sm " required>
                    {{staffRoleOptions()}}
                </select>
                <p class="text-danger role_error"></p>
            </div>
            <div class="col-md-4">
                <label for="state" class="form-label">State Of Origin</label>
                <select id="stateSelect2" name="state" class="form-select form-select-sm" style="width: 100%;">
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label">LGA</label>
                <select id="lgaSelect2" name="lga" class="form-select form-select-sm" style="width: 100%;">
                </select>
            </div>
            <div class="col-md-12">
                <label for="address" class="form-label">Address <small class="text-danger">*</small></label>
                <textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="e.g no 51  offeoke"></textarea>
                <p class="text-danger address_error"></p>
            </div>
            <div class="col-md-4">
                <label for="passport" class="form-label">Passport</label>
                <input type="file" accept="image/*" class="form-control form-control-sm" id="passport" name="passport">
                <p class="text-danger passport_error"></p>
                <img src="" id="staffPassport" class="previewImg" alt="">
            </div>
            <div class="col-md-4">
                <label for="signature" class="form-label">Signature</label>
                <input type="file" accept="image/*" class="form-control form-control-sm" id="signature" name="signature">
                <p class="text-danger signature_error"></p>
                <img src="" id="staffSignature" class="previewImg" alt="">
            </div>
            <div class="col-md-4">
                <label for="stamp" class="form-label">Staff Stamp</label>
                <input type="file" accept="image/*" class="form-control form-control-sm" id="stamp" name="stamp">
                <p class="text-danger stamp_error"></p>
                <img src="" id="staffStamp" class="previewImg" alt="">
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-primary" id="createStaffBtn">Create</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <input type="hidden" id="pid" name="pid">
                <input type="hidden" id="staff_id" name="staff_id">
            </div>
        </form><!-- End Multi Columns Form -->

    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // load page content  
        $('#passport').change(function() {
            previewImg(this, '#staffPassport');
        });
        // load page content  
        $('#signature').change(function() {
            previewImg(this, '#staffSignature');
        });
        $('#stamp').change(function() {
            previewImg(this, '#staffStamp');
        });

        state();

        function state(id = null) {
            FormMultiSelect2('#stateSelect2', 'state', 'Select State of Origin', id)
        }

        function lga(id, pid = null) {
            FormMultiSelect2Post('#lgaSelect2', 'state-lga', id, 'Select Lga of Origin', pid)
        }

        $('#stateSelect2').change(function() {
            var id = $(this).val();
            lga(id);
        });
        // create school category 
        $('#createStaffBtn').click(function() {
            $.ajax({
                url: "{{route('create.school.staff')}}",
                type: "POST",
                data: new FormData($('#createStaffForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                beforeSend: function() {
                    $('.overlay').show();
                    $('#createStaffForm').find('p.text-danger').text('');
                    $('#createStaffBtn').prop('disabled', true);
                },
                success: function(data) {
                    $('#createStaffBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 1) {
                        alert_toast(data.message, 'success');
                        $('#createStaffForm')[0].reset();
                        $('.previewImg').removeAttr('src');
                    } else {
                        alert_toast(data.message, 'warning');
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('#createStaffBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        let pid = "<?php echo $pid ?? '' ?>"
        if (pid != '') {
            $.ajax({
                url: "{{route('load.staff.detail.by.id')}}",
                dataType: "JSON",
                data: {
                    pid: pid,
                    _token: $("input[name='_token']").val()
                },
                // cache: true,
                type: "post",
                success: function(data) {
                    $('#firstname').val(data.firstname);
                    $('#lastname').val(data.lastname);
                    $('#othername').val(data.othername);
                    $('#gsm').val(data.gsm);
                    $('#username').val(data.username) //.attr('disabled', true);
                    $('#email').val(data.email);
                    $('#dob').val(data.dob);
                    $('#address').val(data.address);
                    $('#pid').val(data.user_pid);
                    $('#staff_id').val(data.staff_id);
                    $('#gender').val(data.gender).trigger('change');
                    $('#titleSelect2').val(data.title).trigger('change');
                    $('#religion').val(data.religion).trigger('change');
                    $('#roleSelect2').val(data.role).trigger('change');
                    $('#stateSelect2').val(data.state).trigger('change');
                    $('#lgaSelect2').val(data.lga).trigger('change');
                }
            });
        }
        // create school class 
    });
</script>
@endsection