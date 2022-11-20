<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#detail{{$data->pid}}"  >Details</a></li>
        <li><a class="dropdown-item">
                <?php if ($data->status == 1) : ?>
                    <button class="btn btn-sm btn-info approveAdmission" pid="{{base64Encode($data->pid)}}">Grant</button>
                    <button class="btn btn-sm btn-warning denyAdmission" pid="{{base64Encode($data->pid)}}">Deny</button>
                <?php elseif ($data->status == 2) : ?>
                    <button class="btn btn-sm btn-success">Granted</button>
                    <?php else: ?>
                    <button class="btn btn-sm btn-danger">Denied</button>
                <?php endif ?>
            </a>
        </li>
        <li><a class="dropdown-item text-warning" href="{{route('edit.student.info',['id'=>base64Encode($data->pid)])}}">Edit Info</a></li>

    </ul>
</div>

<!-- update staff access -->
<div class="modal fade" id="detail{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Admission Details </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary updateStaffRole" type="button" id="{{$data->pid}}">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>