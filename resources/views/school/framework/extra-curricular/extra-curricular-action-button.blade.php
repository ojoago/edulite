<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#editBaseModal{{$data->pid}}">Edit</a></li>
        <li><a class="dropdown-item deleteExtraCurricular bg-danger pointer" pid = "{{$data->pid}}" >Delete</a></li>
    </ul>
</div>

<div class="modal fade" id="editBaseModal{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Extra Curricular Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 <form method="post" id="editBaseForm{{$data->pid}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-7">
                            <label for="">School Category</label>
                            <select type="text" name="category" class="form-control" id="cpbfCategorySelect2" required>
                                <option disabled selected> Select Category</option>
                                @foreach ($categories as $item)
                                    <option value="{{$item->pid}}" {{$data->category_pid == $item->pid ? 'selected' : '' }} >{{$item->category}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger category_error"></p>
                        </div>
                        <div class="col-md-5">
                            <label for="">Grade System</label>
                            <select type="text" name="grade" class="form-control form-control-sm" required>
                                <option disabled selected> Select Grade</option>
                                @foreach (EXTRA_CURRICULAR_GRADE_STYLE as $key => $item)
                                    <option value="{{$key}}" {{$data->grade == $key ? 'selected' : '' }} >{{$item}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger grade_error"></p> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <label for="">Extra Curricular Name</label>
                            <input type="hidden" name="pid" value="{{$data->pid}}" >
                            <input type="text" name="psychomotor" value="{{$data->psychomotor}}" class="form-control form-control-sm" placeholder="Create Base Psychomotor">
                            <p class="text-danger psychomotor_error"></p>
                        </div>
                        <div class="col-md-5">
                            <label for="">Maximum Score</label>
                                <input type="number" name="score" value="{{$data->obtainable_score}}" class="form-control form-control-sm" placeholder="obtainable score" required>
                            <p class="text-danger score_error"></p> 
                        </div>
                    </div>

                    Status
                    <hr>

                    Enable <input type="radio" name="status" value="1" {{$data->status == 1 ? 'checked':''}}> 
                    Disable <input type="radio" name="status" value="0" {{$data->status == 0 ? 'checked':''}}>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm editBaseBtn" pid="{{$data->pid}}" id="editBaseBtn{{$data->pid}}">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>