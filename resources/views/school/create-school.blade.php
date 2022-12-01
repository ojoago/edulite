@extends('layout.mainlayout')
@section('title','lite')
@section('content')

<div class="card p-4">
    <h5 class="card-title text-center text-uppercase">Register School</h5>
    <h5>How to create a school <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#createSchoolVideoModal">Watch Video</button></h5>

    <div class="card-body">
        <form action="" class="row g-3" method="post" id="createSchoolForm">
            @csrf
            <div class="col-md-6">
                <label for="school_name">Name of School <span class="text-danger">*</span> </label>
                <input type="text" name="school_name" id="school_name" class=" form-control form-control-sm" placeholder="name of school" required><br>
                <p class="text-danger school_name_error"></p>

            </div>
            <div class="col-md-6">
                <label for="school_email">School Email Address </label>
                <input type="email" name="school_email" id="school_email" class="form-control form-control-sm" placeholder="school email" required><br>
                <p class="text-danger school_email_error"></p>

            </div>
            <div class="col-md-6">
                <label for="school_contact">School Phone Number </label>
                <input type="text" name="school_contact" id="school_contact" class=" form-control form-control-sm" placeholder="phone number" required>
                <p class="text-danger school_contact_error"></p>

            </div>
            <div class="col-md-4">
                <label for="school_moto">School Moto </label>
                <input type="text" name="school_moto" id="school_moto" class=" form-control form-control-sm" placeholder="e.g education is light hence EduLite" placeholder="school moto" required>
                <p class="text-danger school_moto_error"></p>

            </div>
            <div class="col-md-2">
                <label for="school_handel">School Handle </label>
                <input type="text" name="school_code" id="school_code" class=" form-control form-control-sm" placeholder="School Abreviation" required><br>
                <p class="text-danger school_code_error"></p>

            </div>
            <div class="col-md-4">
                <label for="type" class="form-label">Student Type</label>
                <select name="type" id="schoolType" class="form-control form-control-sm" required>
                    <option disabled selected>Select Type</option>
                    <option value="2">Boarding</option>
                    <option value="1" selected>Day</option>
                    <option value="3">Boarding & Day</option>
                </select>
                <p class="text-danger type_error"></p>
            </div>
            <div class="col-md-4">
                <label for="school_state">State </label>
                <select type="text" name="state" id="stateSelect2" class="form-select form-select-sm" placeholder="" required>
                </select>
                <input type="hidden" name="pid" id="schoolpid">
                <p class="text-danger state_error"></p>
            </div>
            <div class="col-md-4">
                <label for="school_state">Local Gov't </label>
                <select type="text" name="lga" id="lgaSelect2" class="form-select form-select-sm" placeholder="" required>
                    <option disabled selected>Select State</option>
                </select>
                <p class="text-danger lga_error"></p>

            </div>
            <div class="col-md-8">
                <label for="school_state">School Address</label>
                <textarea type="text" name="school_address" id="school_address" placeholder="address" class="form-control form-control-sm" required></textarea>
                <p class="text-danger school_address_error"></p>
            </div>
            <div class="col-md-4">
                <label for="school_logo" class="form-label">School Logo</label>
                <input name="school_logo" class="form-control form-control-sm school_logo" id="school_logo" type="file" accept="image/*">
                <p class="text-danger school_logo_error"></p>
                <img src="" id="schoolLogo" class="previewImg" alt="">
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary" id="createSchoolBtn">Create</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                @if(!isset($pid))
                <a href="{{route('users.home')}}">Back to Home</a>
                @endif
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="createSchoolVideoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info">How to create school</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe width="420" height="315" src="https://www.youtube.com/embed/FykOy8vwBkI">
                </iframe>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#school_logo').change(function() {
            previewImg(this, '#schoolLogo');
        });
        // load dropdown  
        // state select2 
        FormMultiSelect2('#stateSelect2', 'state', 'Select State of Origin')
        $('#stateSelect2').change(function() {
            var id = $(this).val();
            FormMultiSelect2Post('#lgaSelect2', 'state-lga', id, 'Select Lga of Origin')
        });


        // create school category 

        $('#createSchoolBtn').click(async function() {
            var route = "{{route('create.school')}}";
            let msg = await submitFormAjax('createSchoolForm', 'createSchoolBtn', route);
            if (msg) {
                if (isset(msg.status) && isset(msg.code)) {
                    let url = "{{'school-sign-in/'}}" + msg.code;
                    location.href = url;
                }
            }
        });

        let pid = "<?php echo $pid ?? '' ?>"
        if (pid != '') {
            $('#createSchoolBtn').text('Update')
            $.ajax({
                url: "{{route('load.school.info')}}",
                dataType: "JSON",
                data: {
                    _token: "{{csrf_token()}}"
                },
                // cache: true,
                type: "post",
                success: function(data) {
                    // console.log(data);
                    $('#school_name').val(data.school_name);
                    $('#school_email').val(data.school_email);
                    $('#school_contact').val(data.school_contact);
                    $('#school_moto').val(data.school_moto);
                    $('#school_code').val(data.school_code) //.attr('disabled', true);
                    $('#school_address').val(data.school_address);
                    $('#schoolpid').val(data.pid);
                    $('#schoolType').val(data.type).trigger('change');
                    $('#stateSelect2').val(data.state).trigger('change');
                    $('#lgaSelect2').val(data.lga).trigger('change');
                }
            });
        }
    });
</script>

@endsection


<!-- school_logo
school_website -->

<!-- <h1>education is light hence EduLite</h1> -->