<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm pointer" data-bs-toggle="modal" data-bs-target="#feeAccountModal{{$data->pid}}">
        Edit
    </button>
</div>
<!-- create edit fee  -->
<div class="modal fade" id="feeAccountModal{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createAccountForm{{$data->pid}}">
                    @csrf
                    <label for="account_number">Account Number</label>
                    <input type="text" name="account_number" maxlength="10" value="{{$data->account_number}}" class="form-control form-control-sm" placeholder="e.g 0001112223" required>
                    <p class="text-danger account_number_error"></p>
                    <label for="account_name">Account Name</label>
                    <input type="text" name="account_name" value="{{$data->account_name}}" class="form-control form-control-sm" placeholder="e.g EduLite" required>
                    <input type="hidden" name="pid" value="{{$data->pid}}" >
                    <p class="text-danger account_name_error"></p>
                    <label for="bank_name">Bank</label>
                    <select name="bank_name" class="form-control form-control-sm" >
                        <option disabled selected>Select Bank</option>
                        @foreach (BANKS as $bank)
                            <option {{ $bank == $data->bank_name ? 'selected' : ''}} >{{$bank}}</option>
                        @endforeach
                    </select>
                    <p class="text-danger bank_name_error"></p>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary createAccountBtn btn-sm" id="createAccountBtn{{$data->pid}}" pid="{{$data->pid}}">Update</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>