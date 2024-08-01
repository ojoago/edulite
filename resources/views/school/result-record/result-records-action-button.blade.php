<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
       
        <li><a class="dropdown-item" href="{{route('result.detail',['id'=>base64Encode($data->id)])}}">Details</a></li>
        {{-- <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#role{{$data->pid}}">Edit Role</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#access{{$data->pid}}" href="#">Edit Access</a></li>
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#modal{{$data->pid}}">Update Images</a></li> --}}
    </ul>
</div>
