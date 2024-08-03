<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm pointer" data-bs-toggle="modal" data-bs-target="#modal{{$data->pid}}">
        <!-- <i class="bi bi-tools"></i> -->
        Edit
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
                    <label for="">Fee Name</label>
                    <select name="fee_item_pid" class="form-control form-control-sm" >
                        <option disabled selected>Select Account</option>
                        @foreach ($fees as $fee)
                            <option value="{{$fee->pid}}" {{$fee->fee_name == $data->fee_name ? 'selected' :''}} >{{$fee->fee_name}}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" disabled value="{{$data->fee_name}}" class="form-control form-control-sm" placeholder="example school fee"><br> --}}
                    <label for="">Class Arm</label>
                    <select name="arm" class="form-control form-control-sm" >
                        <option disabled selected>Select Class</option>
                        @foreach ($arms as $arm)
                            <option value="{{$arm->pid}}" {{$arm->arm == $data->arm ? 'selected' :''}} >{{$arm->arm}}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" disabled value="{{$data->arm}}" class="form-control form-control-sm"><br> --}}
                    <input type="hidden" name="pid" value="{{$data->pid}}">
                    <label for="">Amount</label>
                    <input type="text" name="amount" value="{{$data->amount}}" class="form-control form-control-sm" placeholder="e.g 5,000" required>
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