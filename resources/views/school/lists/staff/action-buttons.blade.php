<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('school.staff.profile',['id'=>base64Encode($data->pid)])}}">Profile</a></li>
        <li>
            <a class="dropdown-item pointer" href="#">
                <?php if ($data->status == 1) : ?>
                    <button class="btn btn-sm btn-success toggleStaffStatus" pid="{{base64Encode($data->pid)}}">Disable</button>
                <?php else : ?>
                    <button class="btn btn-sm btn-danger toggleStaffStatus" pid="{{base64Encode($data->pid)}}">Enable</button>
                <?php endif ?>
            </a>
        </li>
        <li><a class="dropdown-item" href="{{route('edit.staff',['id'=>base64Encode($data->pid)])}}">Edit Info</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#role{{$data->pid}}">Edit Role</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#access{{$data->pid}}" href="#">Edit Access</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#modal{{$data->pid}}">Update Images</a></li>
    </ul>
</div>

<!-- update staff access -->
<div class="modal fade" id="access{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update <i class="bi bi-file-person"></i> <small class="text-info"> {{$data->username}}</small> Access </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="accessModal" id="accessForm{{$data->pid}}">
                    @csrf
                    <div class="col-md-12">
                        <label class="form-label">Grant Extra Access </label><br>
                        @if(getSchoolType() !=1)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="access[]" id="" value="307">
                            <label class="form-check-label" for="flexCheckDefault">
                                Portals
                            </label>
                        </div>
                        @endif
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="access[]" id="" value="301">
                            <label class="form-check-label" for="flexCheckDefault">
                                Class/Form Teacher
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="access[]" id="" value="305">
                            <label class="form-check-label" for="flexCheckDefault">
                                Secretary
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="access[]" id="" value="303">
                            <label class="form-check-label" for="flexCheckDefault">
                                Clerk
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="access[]" id="" value="1">
                            <label class="form-check-label" for="flexCheckDefault">
                                Manage Results
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="access[]" id="" value="610">
                            <label class="form-check-label" for="flexCheckDefault">
                                Rider/Care
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="access[]" id="" value="605">
                            <label class="form-check-label" for="flexCheckDefault">
                                Parent/Guardian
                            </label>
                        </div>
                        <input type="hidden" value="{{$data->pid}}" name="pid">
                        <p class="text-danger access_error"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary updateStaffAccess" type="button" id="{{$data->pid}}">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- update staff primary role -->
<div class="modal fade" id="role{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update <i class="bi bi-file-person"></i> <small class="text-info"> {{$data->username}}</small> Primary Role </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="roleform{{$data->pid}}">
                    @csrf
                    <div class="col-md-12">
                        <label for="state" class="form-label">Primary Role</label>
                        <select id="roleSelect2" name="role" class="form-select form-select-sm " required>
                            {{staffRoleOptions()}}
                        </select>
                        <input type="hidden" value="{{$data->pid}}" name="pid">
                        <p class="text-danger role_error"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary updateStaffRole" type="button" id="{{$data->pid}}">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- update images modal  -->
<div class="modal fade" id="modal{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Images <i class="bi bi-file-person"></i> <small class="text-info"> {{$data->username}}</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="form{{$data->pid}}">
                    @csrf
                    <div class="col-md-12">
                        <label for="passport" class="form-label">Passport</label>
                        <input type="file" accept="image/*" class="form-control form-control-sm" id="passport" name="passport">
                        <p class="text-danger passport_error"></p>
                        <img src="" id="updateStaffPassport" class="previewImg" alt="">
                    </div>
                    <div class="col-md-12">
                        <label for="signature" class="form-label">Signature</label>
                        <input type="file" accept="image/*" class="form-control form-control-sm" id="signature" name="signature">
                        <p class="text-danger signature_error"></p>
                        <img src="" id="updateStaffSignature" class="previewImg" alt="">
                    </div>
                    <div class="col-md-12">
                        <label for="stamp" class="form-label">Staff Stamp</label>
                        <input type="file" accept="image/*" class="form-control form-control-sm" id="stamp" name="stamp">
                        <input type="hidden" value="{{$data->pid}}" name="pid">
                        <p class="text-danger stamp_error"></p>
                        <img src="" id="updateStaffStamp" class="previewImg" alt="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary updateStaffImage" type="button" id="{{$data->pid}}">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>