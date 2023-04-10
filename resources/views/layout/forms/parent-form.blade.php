<form class="row g-3" id="createParentForm">
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
    <div class="col-md-4 formS" style="display: none;">
        <label for="state" class="form-label small">State Of Origin <small class="text-danger">*</small></label>
        <select id="stateSelect2" name="state" class="form-select form-select-sm parentStateSelect2" style="width: 100%;">
        </select>
        <p class="text-danger state_error"></p>
    </div>
    <div class="col-md-4 formS" style="display: none;">
        <label for="inputCity" class="form-label small">LGA <small class="text-danger">*</small></label>
        <select id="lgaSelect2" name="lga" class="form-select form-select-sm parentLgaSelect2" style="width: 100%;">
        </select>
        <p class="text-danger lga_error"></p>
    </div>

    <!-- // -->
    <div class="col-md-4 modalS">
        <label for="state" class="form-label small">State Of Origin <small class="text-danger">*</small></label>
        <select id="parentStateSelect2" name="state" class="form-select form-select-sm parentStateSelect2" style="width: 100%;">
        </select>
        <p class="text-danger state_error"></p>
    </div>
    <div class="col-md-4 modalS">
        <label for="inputCity" class="form-label small">LGA <small class="text-danger">*</small></label>
        <select id="parentLgaSelect2" name="lga" class="form-select form-select-sm parentLgaSelect2" style="width: 100%;">
        </select>
        <p class="text-danger lga_error"></p>
    </div>
    <!-- // -->
    <div class="col-md-4">
        <label for="passport" class="form-label">Passport</label>
        <input name="passport" class="form-control form-control-sm passport" id="passport" type="file" accept="image/*">
        <p class="text-danger passport_error"></p>
        <img src="" id="parentPassport" class="previewImg" alt="">
    </div>

    <div class="col-md-8">
        <label for="address" class="form-label">Address <small class="text-danger">*</small></label>
        <textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="e.g no 51  offeoke"></textarea>
        <p class="text-danger address_error"></p>
    </div>

    <div class="col-md-4" id="linkStudentPart" style="display: none;">
        <!-- <div class="input-group"> -->
        <label for="student_pid" class="form-label small">Child/Ward </label>
        <!-- <span class="pointer addStudent ml-1" id="basic-addon1"><i class="bi bi-node-plus-fill lg"></i></span>
        </div> -->
        <select id="studentSelect2" name="student_pid[]" multiple="multiple" class="form-control  form-control-sm">
        </select>
        <p class="text-danger student_pid_error"></p>
    </div>

</form>