@extends('layout.mainlayout')
@section('title','Student Admission')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{activeSessionName()}} Admission, {{activeTermName()}}</h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" id="createStudentForm" name="createStudentForm">
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
                <label for="gsm" class="form-label">Applicant Phone Number</label>
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
                <input type="date" class="form-control form-control-sm" id="dob" onkeydown="return false" name="dob" required>
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
                <select id="stateSelect2" value="1" name="state" class="form-control form-control-sm" style="width: 100%;">
                </select>
                <p class="text-danger state_error"></p>
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label small">LGA</label>
                <select id="lgaSelect2" value="1" name="lga" class="form-control form-control-sm select2" style="width: 100%;">
                </select>
                <p class="text-danger lga_error"></p>
            </div>
            <div class="col-md-4">
                <label for="parent_pid" class="form-label small">Parent/Guardian</label>
                <div class="input-group">
                    <select id="parentSelect2" name="parent_pid" class="form-select form-select-sm" width="90%">
                    </select>
                    <span class="input-group-text pointer" data-bs-toggle="modal" data-bs-target="#createParentOnStudentFormMadal" id="basic-addon1"><i class="bi bi-node-plus-fill" title="Create Parent/Guardian" data-bs-toggle="tooltip"></i></span>
                </div>
                <p class="text-danger parent_pid_error"></p>
            </div>
            <div class="col-md-12">
                <label for="address" class="form-label">Address</label>
                <textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="e.g no 51  offeoke"></textarea>
                <p class="text-danger address_error"></p>
            </div>
            <div class="col-md-3">
                <label for="type" class="form-label">Student Type</label>
                <select name="type" class="form-control  form-control-sm" id="studentType" required>
                    @if(getSchoolType()==1)
                    <option value="1" selected>Day</option>
                    @elseif(getSchoolType()==2)
                    <option value="2" selected>Boarding</option>
                    @else
                    <option disabled selected>Select Type</option>
                    <option value="2">Boarding</option>
                    <option value="1">Day</option>
                    <!-- <option value="3">Boarding & Day</option> -->
                    @endif
                </select>
                <p class="text-danger type_error"></p>
            </div>


            <div class="col-md-5">
                <label for="class_pid" class="form-label">Class</label>
                <select name="class_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="classSelect2" required>
                </select>
                <input name="pid" id="pid" type="hidden">
                <input name="user_pid" id="user_pid" type="hidden">
                <p class="text-danger class_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="arm_pid" class="form-label">Class Arm</label>
                <select name="arm_pid" class="form-select form-select-sm readOnlyProp" style="width: 100%;" id="armSelect2">
                </select>
                <p class="text-danger arm_pid_error"></p>
            </div>
            <div class="col-md-2">
                <label for="passport" class="form-label">Passport</label>
                <input name="passport" class="form-control form-control-sm" id="passport" type="file" accept="image/*">
                <p class="text-danger passport_error"></p>
                <img src="" id="studentPassport" class="previewImg" alt="">
            </div>
            <div class="col-md-4">
                <label for="contact_person" class="form-label">Contact Person</label>
                <input name="contact_person" class="form-control form-control-sm" id="contact_person" type="text" placeholder="name of contact person">
                <p class="text-danger contact_person_error"></p>
            </div>
            <div class="col-md-3">
                <label for="contact_gsm" class="form-label">Contact Person GSM</label>
                <input name="contact_gsm" class="form-control form-control-sm" maxlength="11" id="contact_gsm" type="text" placeholder="phone number of contact person">
                <p class="text-danger contact_gsm_error"></p>
            </div>
            <div class="col-md-3">
                <label for="contact_email" class="form-label">Contact Person EMail</label>
                <input name="contact_email" class="form-control form-control-sm" id="contact_email" type="text" placeholder="email of contact person">
                <p class="text-danger contact_email_error"></p>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary " id="createStudentBtn">Submit</button>
                <button type="reset" class="btn btn-secondary" form="createStudentForm">Reset</button>
            </div>
        </form>
        <!-- End Multi Columns Form -->

    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#passport').change(function() {
            previewImg(this, '#studentPassport');
        });
        // load dropdown  
        // session select2 
        FormMultiSelect2('#stateSelect2', 'state', 'Select State of Origin')
        FormMultiSelect2('#parentSelect2', 'parent', 'Select Parent/Guardian')


        $('#stateSelect2').change(function() {
            var id = $(this).val();
            FormMultiSelect2Post('#lgaSelect2', 'state-lga', id, 'Select Lga of Origin')
        });

        FormMultiSelect2('#classSelect2', 'admission-class', 'Select Class')

        // class arm dropdown 
        $('#classSelect2').change(function() {
            var id = $(this).val();
            FormMultiSelect2Post('#armSelect2', 'class-arm', id, 'Select Class Arm')
        });

        // term dropdown 
        $('#createStudentBtn').click(async function() {
            var route = "{{route('school.admission')}}";
            data = await submitFormAjax('createStudentForm', 'createStudentBtn', route);
            if (data) {
                if ((data.status == 1) && data.admission_number) {
                    let url = "{{URL::to('/admission-fee?param=')}}" + data.admission_number;
                    location.href = url;
                }
            }
        });
        // create school category 
        let pid = "<?php echo $pid ?? '' ?>"
        if (pid != '') {
            $('.overlay').show();
            $('.readOnlyProp').attr('readonly', true);
            $.ajax({
                url: "{{route('load.admission.by.pid')}}",
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
                    $('#user_pid').val(data.user_pid);
                    $('#pid').val(data.pid);
                    $('#contact_person').val(data.contact_person);
                    $('#contact_gsm').val(data.contact_gsm);
                    $('#contact_email').val(data.contact_email);
                    $('#gender').val(data.gender).trigger('change');
                    // $('#titleSelect2').val(data.title).trigger('change');
                    $('#religion').val(data.religion).trigger('change');
                    $('#studentType').val(data.type).trigger('change');
                    $('#stateSelect2').val(data.state).trigger('change');
                    $('#lgaSelect2').val(data.lga).trigger('change');
                    $('#createStudentBtn').text('Update').addClass('btn-warning text-white');
                    $('.overlay').hide();
                }
            });
        }
    });
</script>
@endsection