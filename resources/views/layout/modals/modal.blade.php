<!-- create class subject to teacher modal  -->
<div class="modal fade" id="createArmSubjectTeacherModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Class Arm Subject to Teacher for<small class="text-danger"> {{activeTermName()}} {{activeSessionName()}}</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="assignArmSubjectTeacherForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="category_pid">Category</label>
                            <select name="category_pid" id="categorySelect2s" placeholder="select" class="categorySelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                        </div>
                        <!-- <div class="col-md-6">
                            <label for="session_pid">Session</label>
                            <select name="session_pid" id="sessionSelect2s" placeholder="select" class="sessionSelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger session_pid_error"></p>
                        </div> -->
                        <div class="col-md-6">
                            <label for="class_pid">Class</label>
                            <select name="class_pid" id="classSelect2s" placeholder="select" class="classSelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                        <!-- <div class="col-md-6">
                            <label for="term_pid">Term</label>
                            <select name="term_pid" id="termSelect2s" placeholder="select" class="termSelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger term_pid_error"></p>
                        </div> -->
                    </div>
                    <!-- no need to select class cos subject already belong to class  -->
                    <label for="arm_pid">Arm</label>
                    <select name="arm_pid" id="armSelect2s" placeholder="select" class="armSelect2 form-control form-control-sm" style="width: 100%;">
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
                <button type="button" class="btn btn-primary btn-sm" id="assignArmSubjectTeacherBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- assign class arm rep modal  -->
<div class="modal fade" id="assignArmToRepModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Class Arm Rep for<small class="text-danger"> {{activeTermName()}} {{activeSessionName()}}</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="assignArmToRepForm">
                    @csrf

                    <label for="category_pid">Category</label>
                    <select name="category_pid" id="ccarCategorySelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <!-- <label for="session_pid">Session</label>
                    <select name="session_pid" id="ccarSessionSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p> -->
                    <label for="class_pid">Class</label>
                    <select name="class_pid" id="ccarClassSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <!-- <label for="term_pid">Term</label>
                    <select name="term_pid" id="ccarTermSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p> -->
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
                <button type="button" class="btn btn-primary btn-sm" id="assignArmToRepBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- assign class to class arm teacher modal  -->
<div class="modal fade" id="assignClassArmTeacherModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Class Arm To Teacher for<small class="text-danger"> {{activeTermName()}} {{activeSessionName()}}</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="assignClassArmToTeacherForm">
                    @csrf
                    <!-- <label for="session_pid">Session</label>
                    <select name="session_pid" id="sessionSelect24t" placeholder="select" class="sessionSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="session_pid">Term</label>
                    <select name="term_pid" id="termSelect2" placeholder="select" class="termSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p> -->
                    <label for="category_pid">Category</label>
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
                    <p class="text-danger arm_pid_error"></p>
                    <label for="teacher_pid">Teacher</label>
                    <select name="teacher_pid" id="teacherSelect2" style="width: 100%;" class="teacherSelect2 form-control form-control-sm">
                    </select>
                    <p class="text-danger teacher_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="assignClassArmToTeacherBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- link students to parent modal  -->
<div class="modal fade" id="linkMyWardsModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Link Student to Parent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="linkStudentParentDynamicForm">
                    @csrf
                    <input name="parent_pid" id="linkMyWardsPid" type="hidden">
                    <label for="student_pid">Students</label>
                    <select name="student_pid[]" id="lmToParentstudentSelect2" multiple="multiple" style="width: 100%;" class="studentToParentstudentSelect2 form-control form-control-sm">
                    </select>
                    <p class="text-danger student_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="linkStudentParentDynamicBtn">Link</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- link students to parent modal  -->
<div class="modal fade" id="linkMyParentModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Link Student to Parent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="linkParentDynamicForm">
                    @csrf
                    <label for="parent_pid">Parent/Guardian</label>
                    <select name="parent_pid" id="lpToParentparentSelect2" placeholder="select" class="parentSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger parent_pid_error"></p>
                    <input name="student_pid[]" id="lpStudentpid" type="hidden">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="linkParentDynamicBtn">Link</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- link students to parent modal  -->
<div class="modal fade" id="linkStudentParentModal" tabindex="-1" data-bs-backdrop="false">
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
                    <label for="student_pid">Students</label>
                    <select name="student_pid[]" id="studentToParentstudentSelect2" multiple="multiple" style="width: 100%;" class="studentToParentstudentSelect2 form-control form-control-sm">
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
<div class="modal fade" id="createParentOnStudentFormMadal" tabindex="-1" data-bs-backdrop="false">
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
<div class="modal fade" id="addStaffModal" tabindex="-1" data-bs-backdrop="false">
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
<div class="modal fade" id="addStudentModal" tabindex="-1" data-bs-backdrop="false">
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
<div class="modal fade" id="addParentModal" tabindex="-1" data-bs-backdrop="false">
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
<div class="modal fade" id="addRiderModal" tabindex="-1" data-bs-backdrop="false">
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
<div class="modal fade" id="assignHostelToPortalModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Hostel to Portal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="assignHostelToPortalForm">
                    @csrf
                    <p class="text-danger">Note, you are assigning to {{activeTermName()}} {{activeSessionName()}}</p>
                    <!-- <label for="session_pid">Session</label>
                    <select name="session_pid" id="ahtpSessionSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="term_pid">Term</label>
                    <select name="term_pid" id="ahtpTermSelect2" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p> -->
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


<div class="modal fade" id="assignHostelToStudentModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Hostel to Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="assignHostelToStudentForm">
                    @csrf
                    <label for="hostel_pid">Hostels</label>
                    <select name="hostel_pid" id="ahtsHostelSelect2" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger hostel_pid_error"></p>
                    <label for="student_pid">Student</label>
                    <select name="student_pid[]" id="ahtsStudentSelect2" multiple="multiple" placeholder="select" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger student_pid_error"></p>

                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="assignHostelToStudentBtn">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- student invoice payment -->
<div class="modal fade" id="processStudentInvoiceModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="processStudentInvoiceForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="hostel_pid" class="text-center">Select Student</label>
                            <select name="student_pid" id="psiStudentSelect2" class="form-control form-control-sm">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="hostel_pid" class="text-center">Enter Student Reg Instead</label>
                            <div class="input-group">
                                <input type="text" name="" id="studentReg" class="form-control form-control-sm">
                                <span class="input-group-text pointer" id="findStudentByReg"> <i class="bi bi-search"></i> </span>
                            </div>
                        </div>
                    </div>
                    <p class="text-danger student_pid_error"></p>
                    <div id="studentUnPaidInvoices"></div>
                    <hr>
                    <p>select mode of payment</p>
                    
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" type="button" id="acceptPaymentBtn" style="display: none;">Submit</button>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- student direct payment -->
<div class="modal fade" id="payDirectModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Accept Payment</h5>
                <div class="float-end">
                    <button id="addMoreArm" type="button" class="btn btn-danger btn-sm btn-sm mb-1 text-center">Add More Row</button><br>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="payDirectForm">
                    @csrf
                    <label for="hostel_pid" class="text-center">Student</label>
                    <div class="row">
                        <div class="col-md-6">
                            <select name="student_pid" id="apStudentSelect2" class="form-control form-control-sm">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="" id="stdReg" class="form-control form-control-sm">
                                <span class="input-group-text pointer" id="findStudentByReg"> <i class="bi bi-search"></i> </span>
                            </div>
                        </div>
                    </div>
                    <p class="text-danger student_pid_error"></p>
                    <!-- <div id="studentUnPaidInvoices"></div> -->
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" type="button" id="payDirectBtn">Submit</button>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="linkStudentToRiderModal" tabindex="-1" data-bs-backdrop="false">
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


<div class="modal fade" id="updateAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info">Update Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="updateAccountForm">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control form-control-sm" name="firstname" id="updateAccountFirstname" placeholder="Enter your first name">
                        <p class="text-danger firstname_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control form-control-sm" name="lastname" id="updateAccountLastname" placeholder="Enter your last name">
                        <p class="text-danger lastname_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Othername</label>
                        <input type="text" class="form-control form-control-sm" name="othername" id="updateAccountOthername" placeholder="Other name">
                        <p class="text-danger othername_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of birth</label>
                        <input type="date" class="form-control form-control-sm" name="dob" id="updateAccountDOB" placeholder="date od birth">
                        <p class="text-danger dob_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select form-select-sm" id="updateAccountGender">
                            <option disabled selected>Select Gender</option>
                            <option value="2">Female</option>
                            <option value="1">Male</option>
                        </select>
                        <p class="text-danger gender_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select id="religion" name="religion" class="form-select form-select-sm" id="updateAccountReligion">
                            <option disabled selected>Select Religion</option>
                            <option value="2">Christian</option>
                            <option value="1">Muslim</option>
                            <option value="3">Other</option>
                        </select>
                        <p class="text-danger religion_error"></p>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea type="text" class="form-control form-control-sm" name="address" id="updateAccountAddress" placeholder="Enter Address"></textarea>
                        <p class="text-danger address_error"></p>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">About</label>
                        <textarea type="text" class="form-control form-control-sm" name="about" id="updateAccountAbout" placeholder="say something good about yourself"></textarea>
                        <p class="text-danger about_error"></p>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="updateAccountBtn">Update</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- hire me  -->
<div class="modal fade" id="hireMeModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info text-center">Open for Hire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="hireMeForm">
                    @csrf
                    <div class="col-md-12">
                        <label class="form-label">About</label>
                        <textarea type="text" name="about" class="form-control form-control-sm" id="hireAbleAbout" placeholder="say something good about yourself"></textarea>
                        <p class="text-danger about_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Highest Qualification</label>
                        <input type="text" class="form-control form-control-sm" name="qualification" id="qualification" placeholder="COE">
                        <p class="text-danger qualification_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course of Study</label>
                        <input type="text" class="form-control form-control-sm" name="course" id="course" placeholder="e.g Economic Social Studies">
                        <p class="text-danger course_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Years of Expirence</label>
                        <input type="number" class="form-control form-control-sm" name="years" id="years" placeholder="e.g 2">
                        <p class="text-danger years_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Open For Employment?</label><br>
                        <input type="checkbox" class="checkbox" name="status" id="status" value="1">
                        <p class="text-danger status_error"></p>
                    </div>

                    <label for="" class="text-center">Prefered state/Area you want to be employed</label>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <select name="state" id="hireMeStateSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger state_error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">LGA</label>
                        <select name="lga" id="hireMeLgaSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger state_error"></p>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Subject of interest</label>
                        <select name="subject[]" id="areaSubjectSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                        <p class="text-danger subject_error"></p>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="hireMeBtn">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end of hire me modal  -->

<!-- setup modal  -->
<!-- stage 2 term modal  -->
<!-- create school term modal  -->
<div class="modal fade" id="createTermModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Term</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createTermForm">
                    @csrf
                    <input type="text" name="term" autocomplete="off" class="form-control" placeholder="lite term e.g first term" required>
                    <p class="text-danger term_error"></p>
                    <textarea type="text" name="description" autocomplete="off" class="form-control" placeholder="lite term description"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createTermBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end term modal  -->
<!-- set active term modal -->
<!-- set active active Modal -->
<div class="modal fade" id="setActiveTermModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Active active</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="setActiveTermForm">
                    @csrf
                    <select class="form-control select2-container" style="width: 100%;" id="setTermSessionSelect2" name="active_session">
                    </select>
                    <p class="text-danger active_session_error"></p>
                    <select class="form-control select2-container" style="width: 100%;" id="setTermSelect2" name="active_term">
                    </select>
                    <p class="text-danger active_term_error"></p>
                    <label for="">Term Begin</label>
                    <input type="date" name="term_begin" autocomplete="off" class="form-control" placeholder="lite term e.g first term" required>
                    <p class="text-danger term_begin_error"></p>
                    <label for="">Term End</label>
                    <input type="date" name="term_end" autocomplete="off" class="form-control" placeholder="lite term e.g first term" required>
                    <p class="text-danger term_end_error"></p>
                    Re-asign last term class ? <input type="checkbox" name="clone_class" value="1" class="checkbox"> <br>
                    Re-asign last term subjects ? <input type="checkbox" name="clone_subject" value="1" class="checkbox">
                    <textarea type="text" name="note" autocomplete="off" class="form-control" placeholder="lite term description"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="setActiveTermBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end set active term modal -->

<!-- stage 3 create session  -->

<!-- create school session modal  -->
<div class="modal fade" id="createSessionModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Academic Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createSessionForm">
                    @csrf
                    <input type="text" name="session" autocomplete="off" class="form-control" placeholder="lite session e.g 2021/2022" required>
                    <p class="text-danger session_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createSessionBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End school session Modal-->
<!-- set active session modal  -->
<div class=" modal fade" id="setActiveSessionModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Active Academic Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="setActiveSessionForm">
                    @csrf
                    <select class="form-control select2-container" style="width: 100%;" id="sessionSelect2" name="active_session">
                    </select>
                    <span class="text-danger active_session_error"></span>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="setActiveSessionBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end active session modal  -->


<!-- end create session  -->
<!-- create school category modal start here  -->
<!-- create school category modal  -->
<div class="modal fade" id="createClassCategoryModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassCategoryForm">
                    @csrf
                    <input type="text" name="category" id="categoryName" class="form-control form-control-sm" placeholder="school category" required>
                    <input type="hidden" name="pid" id="categoryPid">
                    <p class="text-danger category_error"></p>
                    <label for="head_pid">Principal/Head</label>
                    <select name="head_pid" id="staffSelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger head_pid_error"></p>
                    <textarea type="text" name="description" id="categoryDescription" class="form-control form-control-sm" placeholder="description" required></textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createClassCategoryBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal end here  -->

<!-- class modal start here  -->
<div class="modal fade" id="createClassModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Class
                    <button id="addMoreClass" type="button" class="btn btn-danger btn-sm btn-small m-3">Add More Row</button>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassForm">
                    @csrf
                    <select name="category_pid" id="classCategorySelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>

                    <div class="row">
                        <div class="col-md-7">
                            <input type="text" name="class[]" placeholder="class e.g JSS 1" class="form-control form-control-sm" required>
                            <p class="text-danger class_error"></p>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <select name="class_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                    <option disabled selected>Select Class Number</option>
                                    @foreach(CLASS_NUMBER as $key=> $nm)
                                    <option value="{{$key}}"> {{$nm}}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                            </div>
                            <p class="text-danger class_number_error"></p>
                        </div>
                    </div>
                    <div id="addMoreClassRow"></div>
                    <p>[Class equivalence in number] is used to promote student to the next class automatically by the system if need be</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createClassBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- class modal end here  -->

<!-- class arm model start here  -->
<div class="modal fade" id="createClassArmModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Class Arms

                    <center>
                        prepend class name to class arm ? <input type="checkbox" name="prepend">
                        <button id="addMArm" type="button" class="btn btn-danger btn-sm btn-small mb-1">Add More Arm</button>
                    </center>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassArmForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <select name="category_pid" id="ccaCategorySelect2" class="ccaCategorySelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                        </div>
                        <div class="col-md-6">
                            <select name="class_pid" id="ccaClassSelect2" class="ccaclassSelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label for="arm">Class Arm Name</label>
                            <div class="input-group">
                                <input type="text" name="arm[]" placeholder="class arm" class="form-control form-control-sm" required>
                                <i class="bi bi-x-circle-fill text-white m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Class Arm Serial Number</label>
                            <div class="input-group mb-3">
                                <select name="arm_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                    <option disabled selected>Select Class Number</option>
                                    @foreach(CLASS_NUMBER as $key=> $nm)
                                    <option value="{{$key}}"> {{$nm}}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-x-circle-fill text-white m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger arm_number_error"></p>
                        </div>
                    </div>
                    <div id="addMoreArmRow"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createClassArmBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- class arm model end here  -->

<!-- subject type  -->
<!-- subject type modal  -->
<div class="modal fade" id="createSubjectTypeModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Subject Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="createSubjectTypeForm" id="createSubjectTypeForm">
                    @csrf
                    <input type="text" name="subject_type" class="form-control form-control-sm" placeholder="name of Subject" required>
                    <p class="text-danger subject_type_error"></p>
                    <input type="text" name="description" class="form-control form-control-sm" placeholder="Subject Description" required>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm createSubjectTypeBtn" id="createSubjectTypeForm">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end subject type modal  -->
<!-- subject modal  -->
<div class="modal fade" id="createSubjectModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="createSchoolCategortSubjectForm">
                    @csrf
                    <select name="category_pid" style="width:100%" class="form-control form-control-sm createSubjectCategorySelect2" id="createSubjectCategorySelect2">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <select name="subject_type_pid" style="width:100%" class="form-control form-control-sm createSubjectSubjectTypeSelect2" id="createSubjectSubjectTypeSelect2">
                    </select>
                    <p class="text-danger subject_type_pid_error"></p>
                    <input type="text" name="subject" id="subject" class="form-control form-control-sm" placeholder="subject name" required>
                    <input type="hidden" name="pid" id="pid">
                    <p class="text-danger subject_error"></p>
                    <textarea type="text" name="description" id="description" class="form-control form-control-sm" placeholder="description" required></textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- duplicate subject type as subject modal  -->
<div class="modal fade" id="dupSubjectTypeModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Use subject types as subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="createDupSubjectForm">
                    @csrf
                    <select name="category_pid" style="width:100%" class="form-control form-control-sm createSubjectCategorySelect2" id="dupSubjectCategorySelect2">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <select name="subject_type_pid[]" style="width:100%" multiple class="form-control form-control-sm createSubjectSubjectTypeSelect2" id="dupSubjectTypeSelect2">
                    </select>
                    <p class="text-danger subject_type_pid_error"></p>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createDupSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- create class subject modal -->
<div class="modal fade" id="createArmSubjectModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Class Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassArmSubjectForm">
                    @csrf
                    <label for="category_pid">Category</label>
                    <select name="category_pid" id="casfCategorySelect2" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <!-- <label for="session_pid">Session</label>
                    <select name="session_pid" id="casfSessionSelect2" placeholder="select" class=" " style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p> -->
                    <label for="class_pid">Class</label>
                    <select name="class_pid" id="casfClassSelect2" class="classSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <label for="arm_pid">Arm</label>
                    <select name="arm_pid[]" id="casfArmSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger arm_pid_error"></p>
                    <label for="subject_pid">Subjects</label>
                    <select name="subject_pid[]" id="casfSubjectSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger subject_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createClassArmSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- asseement type modal  -->
<div class="modal fade" id="createAssessmentModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Assessment Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createAssessmentForm">
                    @csrf
                    <input type="text" name="title" class="form-control form-control-sm" autocomplete="off" placeholder="Assessment title">
                    <p class="text-danger title_error"></p>
                    <!-- <select type="number" name="category" class="form-control form-control-sm">
                        <option disabled selected>Select Category</option>
                        <option value="1" selected>General</option>
                        <option value="2">Mid Term</option>
                    </select> -->
                    <input type="hidden" name="category" value="1">
                    <p class="text-danger category_error"></p>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="assessment description" required></textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createAssessmentBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->


<!-- score settings  -->

<div class="modal fade" id="createScoreSettingModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Score Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createScoreSettingForm">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                @csrf
                                <!-- <select type="text" name="session_pid" id="cssSessionSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger session_pid_error"></p> -->
                                <select name="category_pid" id="cssCategorySelect2" style="width: 100%;">
                                </select>
                                <p class="text-danger category_pid_error"></p>
                                <select type="text" name="class_pid" id="cssClassSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger class_pid_error"></p>
                                <!-- <select type="text" name="term_pid" id="cssTermSelect2" style="width: 100%;" class="form-control form-control-sm">
                                </select>
                                <p class="text-danger term_pid_error"></p> -->
                            </div>
                            <div class="col-md-5">
                                <h5 class="text-danger">The Sum of Score Settings has to be equal to 100</h5>

                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-info">
                                Title will appear on student result in the other they are entered.
                                I.e if you enter exam first then from left to right exam will appear before other student assessment titles
                            </p>
                            <!-- Multiple ? <input class="custom-check m-1" name="keekVal" type="checkbox" id="gridCheck2"> -->

                            <button id="addMore" type="button" class="btn btn-danger btn-sm btn-small m-1">Add More Row</button>
                            <p class="text-danger title_pid_error"></p>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <select type="text" name="title_pid[]" id="titleSelect0" style="width:100%;" class="titleSelect2 form-control form-control-sm">
                                </select>
                                <p class="text-danger title_pid0_error"></p>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" step=".0" min="1" max="100" class="form-control form-control-sm" name="score[]" placeholder="obtainable score">
                                    <span class="input-group-text">Mid-Term?</span>
                                    <input class="custom-check m-1" value="2" name="mid[]" type="checkbox" id="gridCheck2">
                                    <i class="bi bi-x-circle-fill text-danger hidden-item m-2"></i>
                                </div>
                                <p class="text-danger score0_error"></p>
                            </div>
                        </div>
                        <div id="settingParams"></div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="createScoreSettingBtn">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <!-- <button id="resetForm" type="reset" class="btn btn-warning btn-sm btn-small m-3">Reset</button> -->
        </div>
    </div>
</div>

<!-- end of setup modal  -->
<!-- videos modals  -->