<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Edit</a></li>
        <li><a class="dropdown-item" href="#">Details</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#createArmTeacherModal">Assign to Teacher</a></li>
        <li><a class="dropdown-item" href="#">Class Subject</a></li>
    </ul>
</div>

<!-- create class subject  -->
<div class="modal fade" id="createArmTeacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Lite Cls sbj</h5>
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
                    <select name="term_pid" id="termSelect24t" placeholder="select" class="termSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger term_pid_error"></p>
                    <label for="teacher_pid">Teacher</label>
                    <select name="teacher_pid" id="teacherSelect24t" style="width: 100%;" class="teacherSelect2 form-control form-control-sm">
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