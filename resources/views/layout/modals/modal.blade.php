<!-- create class subject to teacher modal  -->
<div class="modal fade" id="createArmSubjectTeacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Class Arm Subject to Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createArmSubjectTeacherForm">
                    @csrf
                    <label for="category_pid">Category</label>
                    <select name="category_pid" id="categorySelect2s" placeholder="select" class="categorySelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <label for="session_pid">Session</label>
                    <select name="session_pid" id="sessionSelect2s" placeholder="select" class="sessionSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="class_pid">Class</label>
                    <select name="class_pid" id="classSelect2s" placeholder="select" class="classSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <label for="term_pid">Term</label>
                    <select name="term_pid" id="termSelect2s" placeholder="select" class="termSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p>
                    <label for="arm_pid">Arm</label>
                    <select name="arm_pid[]" id="armSelect2s" multiple="multiple" placeholder="select" class="armSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger arm_pid_error"></p>
                    <label for="subject_pid">Subject</label>
                    <select name="subject_pid[]" id="subjectSelect2s" placeholder="select" multiple="multiple" class="subjectSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger subject_pid_error"></p>
                    <label for="teacher_pid">Teacher</label>
                    <select name="teacher_pid" id="teacherSelect2s" style="width: 100%;" class="teacherSelect2 form-control form-control-sm">
                    </select>
                    <p class="text-danger teacher_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createArmSubjectTeacherBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- assign class arm rep modal  -->
<div class="modal fade" id="assignArmToRepModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Class Arm Rep</h5>ccar
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="assignArmToRepForm">
                    @csrf

                    <label for="category_pid">Category</label>
                    <select name="category_pid" id="ccarCategorySelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <label for="session_pid">Session</label>
                    <select name="session_pid" id="ccarSessionSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="class_pid">Class</label>
                    <select name="class_pid" id="ccarClassSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <label for="term_pid">Term</label>
                    <select name="term_pid" id="ccarTermSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p>
                    <label for="arm_pid">Arm</label>
                    <select name="arm_pid" id="ccarArmSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger arm_pid_error"></p>

                    <label for="student_pid">Student</label>
                    <select name="student_pid" id="ccarStudentSelect2" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger student_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="assignArmToRepBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- assign class to class arm teacher modal  -->
<div class="modal fade" id="createArmTeacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Class Arm To Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createArmTeacherForm">
                    @csrf
                    <label for="session_pid">Session</label>
                    <select name="session_pid" id="sessionSelect24t" placeholder="select" class="sessionSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="session_pid">Term</label>
                    <select name="term_pid" id="termSelect2" placeholder="select" class="termSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p>
                    <label for="session_pid">Category</label>
                    <select name="category_pid" id="categorySelect2" placeholder="select" class="categorySelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <label for="session_pid">Class</label>
                    <select name="class_pid" id="classSelect2" placeholder="select" class="classSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <label for="arm_pid">Arm</label>
                    <select name="arm_pid[]" id="armSelect2" multiple="multiple" placeholder="select" class="armSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="teacher_pid">Teacher</label>
                    <select name="teacher_pid" id="teacherSelect2" style="width: 100%;" class="teacherSelect2 form-control form-control-sm">
                    </select>
                    <p class="text-danger teacher_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createArmSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- link students to parent modal  -->
<div class="modal fade" id="linkStudentParentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Link Student to Parent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="linkStudentParentForm">
                    @csrf
                    <label for="parent_pid">Parent/Guardian</label>
                    <select name="parent_pid" id="studentToParentparentSelect2" placeholder="select" class="parentSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger parent_pid_error"></p>
                    <label for="student_pid">Student</label>
                    <select name="student_pid[]" id="studentToParentstudentSelect2" multiple="multiple" style="width: 100%;" class="studentSelect2 form-control form-control-sm">
                    </select>
                    <p class="text-danger student_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="linkStudentParentBtn">Link</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create parent on student form modal  -->
<div class="modal fade" id="createParentOnStudentFormMadal" tabindex="-1">
    <style>
        .addStudent {
            display: none;
        }
    </style>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Parent/Guardian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('layout.forms.parent-form')
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-primary" id="createParentBtn">Create</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add nav section  -->
<!-- add user or staff from another school modal  -->
<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add staff Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="searchExistingStaff" placeholder="phone number, username, former school login email">
                    <span class="pointer input-group-text" data-bs-toggle="tooltip" title="click here" id="basic-addon1"><i class="bi bi-node-plus-fill"></i></span>
                </div>
                <hr>
                <div class="textcenter" id="staffDetails"></div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add existing user or Student from another school modal  -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="searchExistingStudent" placeholder="phone number, username, former school login email">
                    <span class="pointer input-group-text" data-bs-toggle="tooltip" title="click here" id="basic-addon1"><i class="bi bi-node-plus-fill"></i></span>
                </div>
                <hr>
                <div class="textcenter" id="studentDetails"></div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add existing user or parent from another school modal  -->
<div class="modal fade" id="addParentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Parent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="searchExistingParent" placeholder="phone number, username, former school login email">
                    <span class="pointer input-group-text" data-bs-toggle="tooltip" title="click here" id="basic-addon1"><i class="bi bi-node-plus-fill"></i></span>
                </div>
                <hr>
                <div class="textcenter" id="parentDetails"></div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add existing user or rider from another school modal  -->
<div class="modal fade" id="addRiderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Rider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="searchExistingRider" placeholder="phone number, username, former school login email">
                    <span class="pointer input-group-text" data-bs-toggle="tooltip" title="click here" id="basic-addon1"><i class="bi bi-node-plus-fill"></i></span>
                </div>
                <hr>
                <div class="textcenter" id="riderDetails"></div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- link portal to hostel -->
<div class="modal fade" id="assignHostelToPortalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Hostel to Portal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="assignHostelToPortalForm">
                    @csrf
                    <label for="session_pid">Session</label>
                    <select name="session_pid" id="ahtpSessionSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="term_pid">Term</label>
                    <select name="term_pid" id="ahtpTermSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p>
                    <label for="portal_pid">Portals</label>
                    <select name="portal_pid" id="ahtpPortalSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger portal_pid_error"></p>
                    <label for="hostel_pid">Hostels</label>
                    <select name="hostel_pid[]" id="ahtpHostelSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger hostel_pid_error"></p>
                </form>

            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="assignHostelToPortalBtn">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="linkStudentToRiderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Link Student To Care/Rider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="linkStudentToRiderForm">
                    @csrf
                    <label for="rider_pid">Care/Rider</label>
                    <select name="rider_pid" id="lstcrRiderSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger rider_pid_error"></p>
                    <label for="student_pid">Students</label>
                    <select name="student_pid[]" id="lstcrStudentSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger student_pid_error"></p>
                </form>

            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="linkStudentToRiderBtn">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updatePwd" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="updatePwdForm">
                    @csrf
                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Old Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bi bi-shield-lock-fill" id="inputGroupPrepend"></span>
                            <input type="password" class="form-control" name="opwd" placeholder="Old Password">
                        </div>
                        <p class="text-danger opwd_error"></p>
                    </div>
                    <div class="col-12">
                        <label for="yourPassword" class="form-label">New Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bi bi-lock-fill" id="inputGroupPrepend"></span>
                            <input type="password" class="form-control" name="password" placeholder="New Password">
                        </div>
                        <p class="text-danger password_error"></p>
                    </div>
                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Confirm New Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bi bi-unlock-fill" id="inputGroupPrepend"></span>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password">
                        </div>
                        <p class="text-danger password_confirmation_error"></p>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary w-100" type="button" id="updatePwdBtn">Update</button>
                    <!-- <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button> -->
                </div>
            </div>
        </div>
    </div>
</div>