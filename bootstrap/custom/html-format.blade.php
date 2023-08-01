<?php

use App\Http\Controllers\School\Student\StudentController;

function formatStaff($row)
{
    if ($row) {
        $email = $row->email ? ' <hr><p>Email ' .  $row->email  . '</p>' : '';
        // <option value="200">Super Admin</option>
        return '
             
                <label class="text-info m-2">Primary Role</label>
                  <div class="input-group mb-3">
                    <select id="staffRole" name="role" class="form-select form-select-sm " required>
                        <option disabled selected>Select Role</option>
                        <option value="205">School Admin</option>
                        <option value="500">Principal/Head Teacher</option>
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

        $email = $row->email ? 'Email ' .  $row->email : '';
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
        $email = $row->email ? ' <hr><p>Email ' .  $row->email  . '</p>' : '';
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
        $email = $row->email ? ' <hr><p>Email ' .  $row->email  . '</p>' : '';
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
        $imgUrl = $row->passport ? asset("/files/images/".$row->passport) :'';
        $image = '<div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
        <div class="text-center" style="max-height:200px !important;max-width:200px">
             <img src="' . $imgUrl . '" alt="Profile" class="rounded-circle"  style="max-height:200px !important;max-width:200px">
        </div>
                <h1 class="ellipsis-text h6"><span> ' . $row->title . ' </span> ' . $row->fullname . '</h1>
                <h4>'. matchStaffRole($row->role). '</h4>
                <div class="social-links mt-2">
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>';
        $info = '
             <h5 class="card-title">About</h5>
                  <p class="small fst-italic"></p>
                  <h5 class="card-title">Profile Details</h5>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">' . $row->title . ' </span> ' . $row->fullname . '</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Username</div>
                    <div class="col-lg-9 col-md-8">' . $row->username . '</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Staff ID</div>
                    <div class="col-lg-9 col-md-8">' . $row->staff_id . '</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8">' . matchStaffRole($row->role) . '</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">Nigeria</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8">' . $row->address . '</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">' . $row->gsm . '</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">' . $row->email . '</div>
                  </div>';
    } else {
        $info = '<h2 class="text-danger p-3">Empty Result Set</h2>'; 
        $image = '';
    }

    return ['image'=>$image,'info'=>$info];
}
function formatRiderProfile($row)
{
    if ($row) {
        $imgUrl = $row->passport ?  asset("/files/images/".$row->passport) : '';
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
                                Number of student: ' . StudentController::countRiderStudent($row->pid) . '
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
        $imgUrl = $row->passport ? asset("/files/images/".$row->passport) :'';
        $image = '<div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
        <div class="text-center" style="max-height:200px !important;max-width:200px">
             <img src="' . $imgUrl . '" alt="Profile" class="rounded-circle"  style="max-height:200px !important;max-width:200px">
        </div>
                <h1 class="ellipsis-text h6">' . $row->fullname . '</h1>
                <h5>'. $row->arm. '</h5>
                <h5>'. matchStudentStatus($row->status). '</h5>';
            //     <div class="social-links mt-2">
            //         <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            //         <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            //         <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            //         <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            //     </div>
            // </div>';
        
        $info = '
             <div class="row p-4">
                <div class=" shadow p-3">
                    Reg Number: ' . $row->reg_number . '
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

                   <hr><p>Email: ' .  $row->email  . '</p>
                </div>
        ';
    } else {
        $info = '<h2 class="text-danger p-3">Empty Result Set</h2>';
        $image = '';
    }

    return ['image' => $image, 'info' => $info];
}

function formatNotification($sql){
    $ntf = '
        <li class="dropdown-header">
            You have '.$sql->count(). ' new notifications
            <a href="' . route("my.notification") . '"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>';
    foreach($sql as $row){
        // $date = date(strtotime($row->created_at));
        $ntf.='
            <li class="notification-item">
                <i class="bi bi-exclamation-circle text-warning"></i>
                <div>
                    <h4>Notice</h4>
                    <p>'.$row->message.'</p>
                    <p>'. $row->created_at.'</p>
                </div>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li> ';
    }
       $ntf.= '
        <li class="dropdown-footer">
            <a href="'.route("my.notification").'">Show all notifications</a>
        </li>';
    return $ntf;
}

    function formatStudentFees($data){
        if($data->isNotEmpty()){
            $total = 0;
            $fmt = '<table class="table table-bordered">';
            foreach($data as $row){
                $total+=$row->amount;
                $fmt .= '
                    <tr>
                        <td><input type="checkbox" name="'.$row->pid.'" class="invoicePidStatus" value="'. $row->amount.'"> </td>
                        <td>'.$row->fee_name.'</td>
                        <td align="right">'.number_format($row->amount,2).'</td>
                    </tr>
                ';
            }
             $fmt .= '
                   
                    <tr>
                        <td colspan="2" align="right">Total </td>
                        
                        <td  align="right">'. NAIRA_UNIT.'<span id="totalAmountSelected">0</span> </td>
                    </tr>
                ';
            $fmt .'</table>';
            return $fmt;
        }
        return '<span class="text-danger">No invoice found</span>';
    }


?>

<?php function staffRoleOptions($sl = null) { 

    // <option value="200">Super Admin</option>
       $roles = '<option disabled selected>Select Role</option>
        <option value="205">School Admin</option>
        <option value="500">Principal/Head Teacher</option>
        <option value="301">Form/Class Teacher</option>
        <option value="300">Teacher</option>
        <option value="303">Clerk</option>
        <option value="305">Secretary</option>
        <option value="307">Portals</option>
        <option value="400">Office Assisstnace</option>
        <option value="405">Security</option>';
    echo $roles;
 } ?>
