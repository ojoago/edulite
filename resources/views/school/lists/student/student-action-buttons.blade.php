<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('student.profile',['id'=>base64Encode($data->pid)])}}">Profile</a></li>
        <li><a class="dropdown-item">
                <?php if ($data->status == 1) : ?>
                    <button class="btn btn-sm btn-info toggleStudentStatus" pid="{{base64Encode($data->pid)}}" data-bs-toggle="tooltip" title="Active Student">Disable</button>
                <?php elseif ($data->status == 2) : ?>
                    <button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Graduated">Ex Student</button>
                <?php elseif ($data->status == 3) : ?>
                    <button class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Left School">Ex Student</button>
                <?php elseif ($data->status == 4) : ?>
                    <button class="btn btn-sm btn-warning toggleStudentStatus" pid="{{base64Encode($data->pid)}}" data-bs-toggle="tooltip" title="Suspended">Enable</button>
                <?php else : ?>
                    <button class="btn btn-sm btn-danger toggleStudentStatus" pid="{{base64Encode($data->pid)}}" data-bs-toggle="tooltip" title="Disabled">Enable</button>
                <?php endif ?>
            </a>
        </li>
        <li><a class="dropdown-item text-warning" href="{{route('edit.student.info',['id'=>base64Encode($data->pid)])}}">Edit Info</a></li>
        <li><a class="dropdown-item linkMyParent pointer" pid="{{$data->pid}}">Link Parent/Guardian</a></li>
        <!-- <li><a class="dropdown-item" href="#">Promote</a></li>
        <li><a class="dropdown-item" href="#">View Result</a></li> -->
    </ul>
</div>