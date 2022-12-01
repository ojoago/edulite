<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm pointer" data-bs-toggle="modal" data-bs-target="#modal{{$data->pid}}">
        <i class="bi bi-tools"></i>
    </button>
</div>
<!-- create edit fee  -->
<div class="modal fade" id="modal{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Fee Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="feeForm{{$data->pid}}">
                    @csrf
                    <input type="text" name="fee_name" value="{{$data->fee_name}}" class="form-control form-control-sm" placeholder="example school fee" required>
                    <input type="hidden" name="pid" value="{{$data->pid}}">
                    <p class="text-danger fee_name_error"></p>
                    <textarea type="text" name="fee_description" class="form-control form-control-sm" placeholder="fee description" required>{{$data->fee_description}}</textarea>
                    <p class="text-danger fee_description_error"></p>
                    Enable <input type="radio" name="status" value="{{$data->status}}" <?php if ($data->status == 1) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                    Disable <input type="radio" name="status" value="{{$data->status}}" <?php if ($data->status == 2) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary createFeeBtn btn-sm" id="id{{$data->pid}}" pid="{{$data->pid}}">Update</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>