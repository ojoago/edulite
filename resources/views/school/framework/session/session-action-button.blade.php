    <button type="button" class="btn btn-primary btn-sm dropdown-toggle pointer" data-bs-toggle="modal" data-bs-target="#modal{{$data->pid}}">
        <i class="bi bi-tools"></i>
    </button>

    
    <div class="modal fade" id="modal{{$data->pid}}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="sessionForm{{$data->pid}}">
                        @csrf
                        <input type="text" name="session" value="{{$data->session}}" autocomplete="off" class="form-control" placeholder="session e.g 2021/2022" required>
                        <input type="hidden" name="pid" value="{{$data->pid}}">
                        <p class="text-danger session_error"></p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary createSessionBtn" id="id{{$data->pid}}" pid="{{$data->pid}}">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>