<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('school.rider.profile',['id'=>base64Encode($data->pid)])}}">Profile</a></li>
        <li><a class="dropdown-item">
                <?php if ($data->status == 1) : ?>
                    <button class="btn btn-sm btn-danger toggleRiderStatus" pid="{{base64Encode($data->pid)}}">Disable</button>
                <?php else : ?>
                    <button class="btn btn-sm btn-success toggleRiderStatus" pid="{{base64Encode($data->pid)}}">Enable</button>
                <?php endif ?>
            </a>
        </li>
        <li><a class="dropdown-item" href="#">Edit Info</a></li>
    </ul>
</div>