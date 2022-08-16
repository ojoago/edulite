<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('school.staff.profile',['id'=>base64Encode($data->pid)])}}">Profile</a></li>
        <li>
            
            <?php if ($data->status == 1) : ?>
                <a class="dropdown-item btn btn-danger" href="#">
                    <button class="btn-sm">Disable</button>
                </a>
                <php else: ?>
                    <a class="dropdown-item btn btn-success" href="#">
                        <button class=" btn-small">Disable</button>
                    </a>
                <?php endif ?>
        </li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#createArmTeacherModal">Assign Class</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#createArmSubjectTeacherModal">Assign Subject</a></li>
        <li><a class="dropdown-item" href="#">Classes</a></li>
        <li><a class="dropdown-item" href="#">Subjects</a></li>
        <li><a class="dropdown-item" href="#">Edit Role</a></li>
    </ul>
</div>