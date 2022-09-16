<button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#{{$data->pid}}">
    Create Hostel
</button>
<div class="modal fade" id="{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Hostel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="{{$data->pid}}">
                    @csrf
                    <input type="text" name="name" value="{{$data->name}}" class="form-control form-control-sm" placeholder="Hostel Name">
                    <input type="hidden" name="pid" value="{{$data->pid}}">
                    <p class="text-danger name_error"></p>
                    <input type="number" name="capacity" value="{{$data->capacity}}" class="form-control form-control-sm" placeholder="Capacity" required>
                    <p class="text-danger capacity_error"></p>
                    <textarea type="text" name="location" class="form-control form-control-sm" placeholder="Location" required>{{$data->location}}</textarea>
                    <p class="text-danger location_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary createHostelBtn" id="{{$data->pid}}">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Psychomotro Modal-->