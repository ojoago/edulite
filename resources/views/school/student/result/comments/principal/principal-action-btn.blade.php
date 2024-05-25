    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="modal" data-bs-target="#automateComment{{$data->id}}">
        Edit
    </button>
    
    <div class="modal fade" id="automateComment{{$data->id}}" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Princial Defined Comment</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="principalCommentForm{{$data->id}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select type="text" name="category" class="form-control  form-control-sm attachSelect2" id="formCategorySelect2" required>
                                    <option disabled selected>Select Category</option>
                                    @foreach($category as $cat)
                                        <option value="{{$cat->pid}}" {{$data->category_pid == $cat->pid ? 'selected' : '' }} >{{$cat->category}}</option>
                                    @endforeach($category as $cat)
                                </select>
                                <p class="text-danger category_error"></p>
                            </div>
                        <div class="col-md-6">
                                <label for="category" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control form-control-sm" value="{{$data->title}}" id="automateCommentTitle" placeholder="enter a unique title " required>
                                <p class="text-danger title_error"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="session" class="form-label">Minimum Score</label>
                                <input type="text" name="min" class="form-control form-control-sm"  value="{{$data->min}}" placeholder="e.g 20" id="minScore">
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <p class="text-danger min_error"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="class" class="form-label">Maximum Score</label>
                                <input type="text" name="max" class="form-control form-control-sm"  value="{{$data->max}}" placeholder="e.g 39.9" id="maxScore">
                                <p class="text-danger max_error"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="arm" class="form-label">Comment</label>
                                <textarea type="text" name="comment" class="form-control form-control-sm" id="comment">{{$data->comment}}</textarea>
                                <p class="text-danger comment_error"></p>
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm principalCommentBtn" pid="{{$data->id}}" id="principalCommentBtn{{$data->id}}">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


