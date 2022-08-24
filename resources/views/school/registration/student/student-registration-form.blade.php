@extends('layout.mainlayout')
@section('title','lite create Std')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Multi Columns Form</h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" id="createStudentForm">
            @csrf
            <div class="col-md-4">
                <label for="firstname" class="form-label">First-Name</label>
                <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" placeholder="e.g OJOago" required>
                <p class="text-danger firstname_error"></p>
            </div>
            <div class="col-md-4">
                <label for="lastname" class="form-label">Last-Name</label>
                <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" placeholder="e.g Otteh" required>
                <p class="text-danger lastname_error"></p>
            </div>
            <div class="col-md-4">
                <label for="othername" class="form-label">Other-Name</label>
                <input type="text" class="form-control form-control-sm" id="othername" name="othername" placeholder="e.g oceje">
            </div>
            <div class="col-md-4">
                <label for="gsm" class="form-label">Phone Number</label>
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
            </div>
            <div class="col-md-4">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-control  form-control-sm">
                    <option disabled selected>Select Gender</option>
                    <option value="2">Female</option>
                    <option value="1">Male</option>
                </select>
                <p class="text-danger gender_error"></p>
            </div>
            <div class="col-md-4">
                <label for="dob" class="form-label">Date Of Birth</label>
                <input type="date" class="form-control form-control-sm" id="dob" name="dob" required>
                <p class="text-danger dob_error"></p>
            </div>
            <div class="col-md-4">
                <label for="religion" class="form-label">Religion</label>
                <select id="religion" name="religion" class="form-control form-control-sm">
                    <option disabled selected>Select Religion</option>
                    <option value="2">Christian</option>
                    <option value="1">Muslim</option>
                    <option value="3">Other</option>
                </select>
                <p class="text-danger religion_error"></p>
            </div>
            <div class="col-md-4">
                <label for="state" class="form-label small">State Of Origin</label>
                <select id="stateSelect2" value="1" name="state" class="form-control" style="width: 100%;">
                </select>
                <p class="text-danger state_error"></p>
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label small">LGA</label>
                <select id="lgaSelect2" value="1" name="lga" class="form-control" style="width: 100%;">
                </select>
                <p class="text-danger lga_error"></p>
            </div>
            <div class="col-md-4">
                <label for="parent_pid" class="form-label small">Parent/Guardian</label>
                <div class="input-group">
                    <select id="lgaSelect2" name="parent_pid" class="form-control  form-control-sm">
                    </select>
                    <span class="input-group-text pointer" id="basic-addon1"><i class="bi bi-node-plus-fill"></i></span>
                </div>
                <p class="text-danger parent_pid_error"></p>
            </div>
            <div class="col-md-12">
                <label for="address" class="form-label">Address</label>
                <textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="e.g no 51  offeoke"></textarea>
                <p class="text-danger address_error"></p>
            </div>
            <div class="col-md-4">
                <label for="type" class="form-label">Student Type</label>
                <select name="type" class="form-control  form-control-sm" required>
                    @if(getSchoolType()==1)
                    <option value="1" selected>Day</option>
                    @else
                    <option disabled selected>Select Type</option>
                    <option value="2">Boarding</option>
                    <option value="1">Day</option>
                    @endif
                </select>
                <p class="text-danger type_error"></p>
            </div>
            <div class="col-md-4">
                <label for="state" class="form-label">Session </label>
                <select name="session_pid" style="width: 100%;" id="sessionSelect2" required>
                </select>
                <p class="text-danger session_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="term_pid" class="form-label">Term</label>
                <select name="term_pid" style="width: 100%;" id="tmSelect2" required>
                </select>
                <p class="text-danger term_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="category_pid" class="form-label">Category</label>
                <select name="category_pid" style="width: 100%;" id="cateSelect2" required>
                </select>
                <p class="text-danger category_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="class_pid" class="form-label">Class</label>
                <select name="class_pid" style="width: 100%;" id="classSelect2" required>
                </select>
                <p class="text-danger class_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="arm_pid" class="form-label">Class Arm</label>
                <select name="arm_pid" class="form-select" style="width: 100%;" id="armSelect2" required>
                </select>
                <p class="text-danger arm_pid_error"></p>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary" id="createStudentBtn">Create</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->

    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // load dropdown  
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
        $('#createStudentBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('register.student')}}",
                type: "POST",
                data: new FormData($('#createStudentForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
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