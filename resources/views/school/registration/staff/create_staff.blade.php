@extends('layout.mainlayout')
@section('title','lite G S')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Multi Columns Form</h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" id="createStaffForm">
            @csrf
            <div class="col-md-4">
                <label for="firstname" class="form-label">First-Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="e.g OJOago" required>
                <p class="text-danger firstname_error"></p>
            </div>
            <div class="col-md-4">
                <label for="lastname" class="form-label">Last-Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="e.g Otteh" required>
                <p class="text-danger lastname_error"></p>
            </div>
            <div class="col-md-4">
                <label for="othername" class="form-label">Other-Name</label>
                <input type="text" class="form-control" id="othername" name="othername" placeholder="e.g oceje">
            </div>
            <div class="col-md-4">
                <label for="gsm" class="form-label">Phone Number</label>
                <input type="text" class="form-control" maxlength="11" id="gsm" name="gsm" placeholder="e.g 070-XX-XX-XX-XX" required>
                <p class="text-danger gsm_error"></p>
            </div>
            <div class="col-md-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control mr-1" id="username" name="username" placeholder="e.g endowed01">
                <p class="text-danger username_error"></p>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="e.g eulite@gmail.com">
            </div>
            <div class="col-md-3">
                <label for="title" class="form-label">Title</label>
                <select id="titleSelect2" name="title" class="form-select" style="width: 100%;">
                </select>
            </div>
            <div class="col-md-3">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-select">
                    <option disabled selected>Select Gender</option>
                    <option value="2">Female</option>
                    <option value="1">Male</option>
                </select>
                <p class="text-danger gender_error"></p>
            </div>
            <div class="col-md-3">
                <label for="dob" class="form-label">Date Of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
                <p class="text-danger dob_error"></p>
            </div>
            <div class="col-md-3">
                <label for="religion" class="form-label">Religion</label>
                <select id="religion" name="religion" class="form-select">
                    <option disabled selected>Select Religion</option>
                    <option value="2">Christian</option>
                    <option value="1">Muslim</option>
                    <option value="3">Other</option>
                </select>
                <p class="text-danger religion_error"></p>
            </div>

            <div class="col-md-4">
                <label for="state" class="form-label">Primary Role</label>
                <select id="roleSelect2" name="role" class="form-select" style="width: 100%;" required>
                    <option disabled selected>Select Role</option>
                    <option value="200">Super Admin</option>
                    <option value="205">School Admin</option>
                    <option value="500">Pincipal</option>
                    <option value="505">Head Teacher</option>
                    <option value="301">Form/Class Teacher</option>
                    <option value="300">Teacher</option>
                    <option value="303">Clerk</option>
                    <option value="305">Secretary</option>
                    <option value="307">Portals</option>
                    <option value="400">Office Assisstnace</option>
                    <option value="405">Security</option>
                </select>
                <p class="text-danger role_error"></p>
            </div>
            <div class="col-md-4">
                <label for="state" class="form-label">State Of Origin</label>
                <select id="stateSelect2" name="state" class="form-select" style="width: 100%;">
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label">LGA</label>
                <select id="lgaSelect2" name="lga" class="form-select" style="width: 100%;">
                </select>
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea type="text" class="form-control" id="address" name="address" placeholder="e.g no 51  offeoke"></textarea>
                <p class="text-danger address_error"></p>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-primary" id="createStaffBtn">Create</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->

    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // load page content  

        $('#classCategorySelect2').select2({
            placeholder: 'Select Category',
            dropdownParent: $('#createClassModal'),
            ajax: {
                url: "{{route('load.available.category')}}",
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $('#categorySelect2').select2({
            placeholder: 'Select Category',
            dropdownParent: $('#createClassArmModal'),
            ajax: {
                url: "{{route('load.available.category')}}",
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });


        // create school category 
        $('#createStaffBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.staff')}}",
                type: "POST",
                data: new FormData($('#createStaffForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createStaffForm').find('p.text-danger').text('');
                    $('#createStaffBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
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
        // create school class 
    });
</script>
@endsection