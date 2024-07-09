<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#editAssessmentModal{{$data->pid}}">Edit</a></li>
        {{-- <li><a class="dropdown-item bg-danger deleleteTitle pointer" pid = "{{$data->pid}}" >Delete</a></li> --}}
    </ul>
</div>

<!-- asseement type modal  -->
<div class="modal fade" id="editAssessmentModal{{$data->pid}}" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Assessment Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="editAssessmentForm{{$data->pid}}">
                    @csrf
                    <div >
                        
                            <label for="" class="text-danger">*</label>
                            <input type="text" name="title" value="{{$data->title}}" class="form-control form-control-sm" autocomplete="off" placeholder="Assessment title">
                            <input type="hidden" name="pid" value="{{$data->pid}}">
                            <p class="text-danger title_error"></p>
                            <input type="text" name="description" value="{{$data->description}}" class="form-control form-control-sm" autocomplete="off" placeholder="assessment description">
                        <p class="text-danger description_error"></p>
                    </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm editAssessmentTitle" pid="{{$data->pid}}" id="editAssessmentBtn{{$data->pid}}">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->
