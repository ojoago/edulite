<?php
function formatStaff($row)
{
    if ($row) {
        $email = $row->email ? ' <hr><p>Email' .  $row->email  . '</p>' : '';
        return '
             
                <label class="text-info m-2">Primary Role</label>
                  <div class="input-group mb-3">
                    <select id="staffRole" name="role" class="form-select form-select-sm " required>
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
                        <button type="button" class="btn btn-success" pid="' . $row->pid . '" id="linkUserToSchoolStaff"  data-bs-toggle="tooltip" title="CLick here to link staff to school" >Link</button></span>
                     </div>
                       
            <div class="card-body shadow p-3">
            
            <div class="">
                    Name: <span> ' . $row->title . ' </span> ' . $row->fullname . '
                    <hr>
                    Username: ' . $row->username . '
                    <hr>
                    Date of Birth: ' . $row->dob . '
                    <hr>
                    Gender: ' . matchGender($row->gender) . '
                    <hr>
                    Religion: ' . matchReligion($row->religion) . '
                    <hr>
                    Address: ' . $row->address . '
                   
                    ' . $email . '
                </div>
            </div>       
        </div>
        ';
    } else {
        return '<h2 class="text-danger p-3">Empty Result Set</h2>';
    }
}

function formatStudent($row)
{
    if ($row) {

        $email = $row->email ? 'Email' .  $row->email : '';
        return '
        <div class="card-body shadow">
            
            <div class="row">
                <div class="col-md-7">
                    <div class = "text-center">
                        <img src="' . public_path() . '/files/images/' . $row->passport . '" class="img img-responsive">
                    </div>
                    <h3 class="card-title">Name: ' . $row->fullname . '</h3>
                    <hr>
                    REG: ' . $row->reg_number . '
                    <hr>
                    Username: ' . $row->username . '
                    <hr>
                    Date of Birth: ' . $row->dob . '
                    <hr>
                    Gender: ' . matchGender($row->gender) . '
                    <hr>
                    Religion: ' . matchReligion($row->religion) . '
                    <hr>
                    ' . $email . '
                </div>
                <div class="col-md-5 pt-4">
                    <label for="type" class="form-label">Student Type</label>
                <select name="type" id="stdType" class="form-control  form-control-sm" required>
                    <option value="2">Boarding</option>
                    <option value="1" selected>Day</option>
                </select>
                    <label for="type" class="form-label">Class</label>
                    <select type="text" name="class_pid" id="allArmSelect2" style="width: 100%;" class="form-control form-control-sm mb-3">
                    </select>
                    <button type="button" class="btn btn-success mt-3" pid="' . $row->pid . '" id="linkStudentToSchool"  data-bs-toggle="tooltip" title="CLick here to link staff to school" >Link</button></span>
                </div>
            </div>
        </div>
            
        ';
    } else {
        return '<h2 class="text-danger p-3">Empty Result Set</h2>';
    }
}

function formatParent($row)
{
    if ($row) {
        $email = $row->email ? ' <hr><p>Email' .  $row->email  . '</p>' : '';
        $imgUrl = asset("/files/images/" . $row->passport);
        return '
            <div class="card-body shadow p-3">
                 <div class = "text-center">
                        <img src="' . $imgUrl . '" class="img img-responsive">
                    </div>
            <div class="">
                    Name: <span> ' . $row->title . ' </span> ' . $row->fullname . '
                    <hr>
                    Username: ' . $row->username . '
                    <hr>
                    Date of Birth: ' . $row->dob . '
                    <hr>
                    Gender: ' . matchGender($row->gender) . '
                    <hr>
                    Religion: ' . matchReligion($row->religion) . '
                    <hr>
                    Address: ' . $row->address . '
                   
                    ' . $email . '
                </div>
            </div>       
        </div>
        <button type="button" class="btn btn-success" pid="' . $row->pid . '" id="linkUserToSchoolParent"  data-bs-toggle="tooltip" title="CLick here to link staff to school" >Link</button></span>
        ';
    } else {
        return '<h2 class="text-danger p-3">Empty Result Set</h2>';
    }
}
function formatRider($row)
{
    if ($row) {
        $email = $row->email ? ' <hr><p>Email' .  $row->email  . '</p>' : '';
        $imgUrl = asset("/files/images/" . $row->passport);
        return '
            <div class="card-body shadow p-3">
                 <div class = "text-center">
                        <img src="' .$imgUrl.'" class="img img-responsive">
                    </div>
            <div class="">
                    Name: <span> ' . $row->title . ' </span> ' . $row->fullname . '
                    <hr>
                    Username: ' . $row->username . '
                    <hr>
                    Date of Birth: ' . $row->dob . '
                    <hr>
                    Gender: ' . matchGender($row->gender) . '
                    <hr>
                    Religion: ' . matchReligion($row->religion) . '
                    <hr>
                    Address: ' . $row->address . '
                   
                    ' . $email . '
                </div>
            </div>       
        </div>
        <button type="button" class="btn btn-success" pid="' . $row->pid . '" id="linkUserToSchoolRider"  data-bs-toggle="tooltip" title="CLick here to link staff to school" >Link</button></span>
        ';
    } else {
        return '<h2 class="text-danger p-3">Empty Result Set</h2>';
    }
}



function formatStaffProfile($row)
{
    if ($row) {
        $email = $row->email ? ' <hr><p>Email: ' .  $row->email  . '</p>' : '';
        $imgUrl = asset("/files/images/".$row->passport);
        return '
             <div class="row p-4">
                        <div class="col-md-6">
                            <div class="text-center">
                                <img src="'. $imgUrl. '" class="img img-responsive" alt="' . $row->fullname . ' passport">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                Name: <span> ' . $row->title . ' </span> ' . $row->fullname . '
                                <hr>
                                Username: ' . $row->username . '
                                <hr>
                                Date of Birth: ' . $row->dob . '
                                <hr>
                                Gender: ' . matchGender($row->gender) . '
                                <hr>
                                Religion: ' . matchReligion($row->religion) . '
                                <hr>
                                Address: ' . $row->address . '

                                ' . $email . '
                            </div>

                        </div>
                    </div>
        ';
    } else {
        return '<h2 class="text-danger p-3">Empty Result Set</h2>';
    }
}
function formatRiderProfile($row)
{
    if ($row) {
        $imgUrl = asset("/files/images/".$row->passport);
        return '
             <div class="row p-4">
                        <div class="col-md-6">
                            <div class="text-center">
                                <img src="'. $imgUrl. '" class="img img-responsive" alt="' . $row->fullname . ' passport">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                Name: <span> ' . $row->title . ' </span> ' . $row->fullname . '
                                <hr>
                                Username: ' . $row->username . '
                                <hr>
                                Phone Number: ' . $row->gsm . '
                                <hr>
                                Number of student: ' . $row->count . '
                                <hr>
                                Email: ' . $row->email . '
                                <hr>
                                Date of Birth: ' . $row->dob . '
                                <hr>
                                Gender: ' . matchGender($row->gender) . '
                                <hr>
                                Religion: ' . matchReligion($row->religion) . '
                                <hr>
                                Address: ' . $row->address . '
                            </div>
                        </div>
                    </div>
        ';
    } else {
        return '<h2 class="text-danger p-3">Empty Result Set</h2>';
    }
}

function formatStudentProfile($row)
{
    if ($row) {
        $email = $row->email ? ' <hr><p>Email: ' .  $row->email  . '</p>' : '';
        $imgUrl = asset("/files/images/".$row->passport);
        return '
             <div class="row p-4">
                        <div class="col-md-6">
                            <div class="text-center" >
                                <img src="'. $imgUrl. '" class="img img-responsive" alt="' . $row->fullname . ' image"  img-circle" style="width:100%;height:auto">
                            </div>
                        </div>
                        <div class="col-md-6 pt-4">
                            <div class=" shadow p-3">
                                Name: ' . $row->fullname . '
                                <hr>
                                Username: ' . $row->reg_number . '
                                <hr>
                                Username: ' . $row->username . '
                                <hr>
                                Date of Birth: ' . $row->dob . '
                                <hr>
                                Gender: ' . matchGender($row->gender) . '
                                <hr>
                                Religion: ' . matchReligion($row->religion) . '
                                <hr>
                                Address: ' . $row->address . '

                                ' . $email . '
                            </div>

                        </div>
                    </div>
        ';
    } else {
        return '<h2 class="text-danger p-3">Empty Result Set</h2>';
    }
}




?>

<?php function staffRoleOptions($sl = null) { 
       $roles = '<option disabled selected>Select Role</option>
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
        <option value="405">Security</option>';
    echo $roles;
 } ?>