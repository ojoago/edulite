@extends('layout.mainlayout')
@section('title','lite')
@section('content')

<div class="card p-4">
    <h5 class="card-title text-center text-uppercase">Register School</h5>

    <div class="card-body">
        <form action="" class="row g-3" method="post" id="createSchoolForm">
            @csrf
            <div class="col-md-6">
                <label for="school_name">Name of School <span class="text-danger">*</span> </label>
                <input type="text" name="school_name" class="form-control form-control-sm" placeholder="name of school" required><br>
                <p class="text-danger school_name_error"></p>

            </div>
            <div class="col-md-6">
                <label for="school_email">School Email Address </label>
                <input type="email" name="school_email" class="form-control form-control-sm" placeholder="school email" required><br>
                <p class="text-danger school_email_error"></p>

            </div>
            <div class="col-md-6">
                <label for="school_contact">School Phone Number </label>
                <input type="text" name="school_contact" class="form-control form-control-sm" placeholder="phone number" required>
                <p class="text-danger school_contact_error"></p>

            </div>
            <div class="col-md-4">
                <label for="school_moto">School Moto </label>
                <input type="text" name="school_moto" class="form-control form-control-sm" placeholder="e.g education is light hence EduLite" placeholder="school moto" required>
                <p class="text-danger school_moto_error"></p>

            </div>
            <div class="col-md-2">
                <label for="school_handel">School Handle </label>
                <input type="text" name="school_code" class="form-control form-control-sm" placeholder="School Abreviation" required><br>
                <p class="text-danger school_code_error"></p>

            </div>
            <div class="col-md-4">
                <label for="type" class="form-label">Student Type</label>
                <select name="type" class="form-control form-control-sm" required>
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
                <textarea type="text" name="school_address" placeholder="address" class="form-control form-control-sm" required></textarea>
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
            </div>
        </form>
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

    });
</script>

@endsection


<!-- school_logo
school_website -->

<!-- <h1>education is light hence EduLite</h1> -->