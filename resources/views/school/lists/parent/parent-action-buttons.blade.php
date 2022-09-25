<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('school.parent.profile',['id'=>base64Encode($data->pid)])}}">Profile</a></li>
        <li><a class="dropdown-item">
                <?php if ($data->status == 1) : ?>
                    <button class="btn btn-sm btn-danger toggleParentStatus" pid="{{base64Encode($data->pid)}}">Disable</button>
                <?php else : ?>
                    <button class="btn btn-sm btn-success toggleParentStatus" pid="{{base64Encode($data->pid)}}">Enable</button>
                <?php endif ?>
            </a>
        </li>
        <li><a class="dropdown-item" href="{{route('school.parent.child',['id'=>base64Encode($data->pid)])}}">Parent Wards</a></li>
        <li><a class="dropdown-item pointer linkMyWards" pid = "{{$data->pid}}">Link Wards</a></li>
        {{--<li><a class="dropdown-item bg-warning" href="{{route('school.parent.edit',['id'=>base64Encode($data->pid)])}}">Edit</a></li>--}}
    </ul>
</div>