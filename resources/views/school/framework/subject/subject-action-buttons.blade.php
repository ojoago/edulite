
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSubjectModal{{$data->pid}}">
    Edit
</button>
<!-- subject modal  -->
<div class="modal fade" id="editSubjectModal{{$data->pid}}" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="editSubjectForm{{$data->pid}}">
                    @csrf
                        <select name="category_pid" style="width:100%" class="form-control form-control-sm " id="">
                            <option disabled selected>Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{$cat->pid}}" {{ $cat->pid == $data->category_pid ? 'selected' : '' }}  >{{$cat->category}}</option>
                            @endforeach
                        </select>

                    <p class="text-danger category_pid_error"></p>
                        <select name="subject_type" style="width:100%" class="form-control form-control-sm " id="">
                            <option disabled selected>Select Subject Type</option>
                            @foreach ($subs as $sub)
                                <option value="{{$sub->pid}}" {{ $sub->subject_type == $data->subject_type ? 'selected' : '' }}  >{{$sub->subject_type}}</option>
                            @endforeach
                        </select>
                    <p class="text-danger subject_type_error"></p>
                    <div class="form-group">
                            <input type="hidden" name="pid" id="pid" value="{{$data->pid}}" >
                            <input type="text" name="subject" id="subject" value="{{$data->subject}}"  class="form-control form-control-sm" placeholder="subject name" required>
                        <p class="text-danger subject_error"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm editSubjectBtn" pid="{{$data->pid}}" id="editSubjectBtn{{$data->pid}}">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
