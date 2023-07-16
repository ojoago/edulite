<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSubjectModal{{$data->pid}}">
    <!-- <i class="bi bi-tools"></i> -->
    Edit
</button>
<div class="modal fade form-modal" id="editSubjectModal{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subject Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="createSubjectTypeForm" id="{{$data->pid}}">
                    @csrf
                    <input type="text" name="subject_type" value="{{$data->subject_type}} " class="form-control form-control-sm" placeholder="name of school" required>
                    <input type="hidden" name="pid" value="{{$data->pid}}" required>
                    <p class="text-danger subject_type_error"></p>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required>{{ $data->description }}</textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm createSubjectTypeBtn" id="{{$data->pid}}">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


