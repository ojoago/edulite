    <button type="button" class="btn btn-primary btn-sm dropdown-toggle pointer" data-bs-toggle="modal" data-bs-target="#modal{{$data->pid}}">
        <!-- <i class="bi bi-tools"></i> -->
        Edit
    </button>

    <!-- create school term modal  -->
    <div class="modal fade" id="modal{{$data->pid}}" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update School Term</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="termForm{{$data->pid}}">
                        @csrf
                        <input type="text" name="term" autocomplete="off" value="{{$data->term}}" class="form-control" placeholder="term e.g first term" required>
                        <input type="hidden" name="pid" value="{{$data->pid}}">
                        <p class="text-danger term_error"></p>
                        <textarea type="text" name="description" autocomplete="off" class="form-control" placeholder="lite term description">{{$data->description}}</textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary createTermBtn" id="id{{$data->pid}}" pid="{{$data->pid}}">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>