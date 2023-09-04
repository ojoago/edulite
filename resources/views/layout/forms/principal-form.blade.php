<form class="row g-3" id="createStaffForm" enctype='multipart/form-data'>
    @csrf
    <div class="col-md-4">
        <label for="firstname" class="form-label">Firstname <small class="text-danger">*</small></label>
        <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" placeholder="e.g OJOago" required>
        <p class="text-danger firstname_error"></p>
    </div>
    <div class="col-md-4">
        <label for="lastname" class="form-label">Lastname <small class="text-danger">*</small></label>
        <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" placeholder="e.g Otteh" required>
        <p class="text-danger lastname_error"></p>
    </div>
    <div class="col-md-4">
        <label for="othername" class="form-label">Othername</label>
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
            {{staffRoleOptions(500)}}
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
    
<!--     
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
    </div> -->

    <div class="text-center">
        <button type="button" class="btn btn-primary" id="createStaffBtn">Create</button>
    </div>
</form><!-- End Multi Columns Form -->