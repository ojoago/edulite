<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <!-- <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#createClassSubjectToTeacherModal">Assign to Teacher</a></li> -->
        <!-- <li><a class="dropdown-item" href="#">Details</a></li>
        <li><a class="dropdown-item" href="#">Arms</a></li>
        <li><a class="dropdown-item" href="#">Class Subject</a></li> -->
        <li><a class="dropdown-item" href="#">Disable</a></li>
    </ul>
</div>
<!-- create class subject  -->
<div class="modal fade" id="createClassSubjectToTeacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Class subject to teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createArmTeacherForm">
                    @csrf
                    <label for="teacher_pid">Teacher</label>
                    <select name="teacher_pid" id="subjectTeacherSelect2" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger teacher_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createArmSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>