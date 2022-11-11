<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer editCategory" pid="{{base64Encode($data->pid)}}">Edit</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#categoryDetail{{$data->pid}}">Details</a></li>
        <!-- <li><a class="dropdown-item" href="#">Disable</a></li> -->
    </ul>
</div>
<div class="modal fade" id="categoryDetail{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Category Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>{{$data->category}}</strong>
                @foreach($data->categoryClass() as $row)
                <p>{{$row->class}} | {{$row->class_number}}</p>
                <hr>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>