@extends('layout.mainlayout')
@section('title','lite create Std')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Register Rider/Care
            <button class="btn btn-primary btn-sm" data-bs-target="#addRiderModal" data-bs-toggle="modal">Link</button>

        </h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" id="createRiderForm">
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
                <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="e.g endowed01">
                <p class="text-danger username_error"></p>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="e.g eulite@gmail.com">
                <p class="text-danger email_error"></p>
            </div>
            <div class="col-md-4">
                <label for="gender" class="form-label">Gender <small class="text-danger">*</small></label>
                <select id="gender" name="gender" class="form-control  form-control-sm">
                    <option disabled selected>Select Gender</option>
                    <option value="2">Female</option>
                    <option value="1">Male</option>
                </select>
                <p class="text-danger gender_error"></p>
            </div>
            <div class="col-md-4">
                <label for="dob" class="form-label">Date Of Birth</label>
                <input type="date" class="form-control form-control-sm" onkeydown="return false" id="dob" name="dob" required>
                <p class="text-danger dob_error"></p>
            </div>
            <div class="col-md-4">
                <label for="religion" class="form-label">Religion <small class="text-danger">*</small></label>
                <select id="religion" name="religion" class="form-control form-control-sm">
                    <option disabled selected>Select Religion</option>
                    <option value="2">Christian</option>
                    <option value="1">Muslim</option>
                    <option value="3">Other</option>
                </select>
                <p class="text-danger religion_error"></p>
            </div>
            <div class="col-md-4">
                <label for="state" class="form-label small">State Of Origin <small class="text-danger">*</small></label>
                <select id="stateSelect2" name="state" class="form-control form-control-sm" style="width: 100%;">
                </select>
                <p class="text-danger state_error"></p>
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label small">LGA <small class="text-danger">*</small></label>
                <select id="lgaSelect2" name="lga" class="form-control form-control-sm" style="width: 100%;">
                </select>
                <p class="text-danger lga_error"></p>
            </div>
            <div class="col-md-4">
                <label for="student_pid" class="form-label small">Students</label>
                <select id="studentSelect2" name="student_pid[]" multiple="multiple" class="form-control  form-control-sm">
                </select>
                <p class="text-danger student_pid_error"></p>
            </div>
            <div class="col-md-8">
                <label for="address" class="form-label">Address <small class="text-danger">*</small></label>
                <textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="e.g no 51  offeoke"></textarea>
                <p class="text-danger address_error"></p>
            </div>
            <div class="col-md-4">
                <label for="passport" class="form-label">Image</label>
                <input type="file" accept="image/*" class="form-control form-control-sm" id="passport" name="passport">
                <p class="text-danger passport_error"></p>
                <img src="" id="riderPassport" class="previewImg" alt="">
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-primary" id="createRiderBtn">Create</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->

    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // load dropdown  
        // state select2 
        FormMultiSelect2('#stateSelect2', 'state', 'Select State of Origin')
        FormMultiSelect2('#studentSelect2', 'student', 'Select student')
        $('#stateSelect2').change(function() {
            var id = $(this).val();

            FormMultiSelect2Post('#lgaSelect2', 'state-lga', id, 'Select Lga of Origin')
        });


        // load page content  
        $('#passport').change(function() {
            previewImg(this, '#riderPassport');
        });
        // create school category 
        $('#createRiderBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.rider')}}",
                type: "POST",
                data: new FormData($('#createRiderForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createRiderForm').find('p.text-danger').text('');
                    $('#createRiderBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
                    $('#createRiderBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 1) {
                        alert_toast(data.message, 'success');
                        $('#createRiderForm')[0].reset();
                    } else {
                        alert_toast(data.message, 'warning');
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('#createRiderBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // create school class 
    });
</script>
@endsection