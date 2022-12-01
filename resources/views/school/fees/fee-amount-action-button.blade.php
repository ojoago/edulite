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
                <h5 class="modal-title">Update Fee Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="feeAmountForm{{$data->pid}}">
                    @csrf
                    <input type="text" disabled value="{{$data->fee_name}}" class="form-control form-control-sm" placeholder="example school fee"><br>
                    <input type="text" disabled value="{{$data->arm}}" class="form-control form-control-sm"><br>
                    <input type="hidden" name="pid" value="{{$data->pid}}">
                    <label for="">Amount</label>
                    <input type="text" name="amount" value="{{$data->amount}}" class="form-control form-control-sm" placeholder="example school fee" required>
                    <p class="text-danger amount_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary feeConfigBtn btn-sm" id="id{{$data->pid}}" pid="{{$data->pid}}">Update</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>