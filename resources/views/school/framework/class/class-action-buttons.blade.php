<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="modal" data-bs-target="#modal{{$data->pid}}">
        <!-- <i class="bi bi-tools"></i> -->
        Edit
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer"></a></li>
        <li><a class="dropdown-item" href="#">Details</a></li>
        <li><a class="dropdown-item" href="#">Arms</a></li>
    </ul>
</div>
<!-- create school term modal  -->
<div class="modal fade editClassModal" id="modal{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="updateClassForm{{$data->pid}}">
                    @csrf
                    <!-- <select name="category_pid" id="editClassCategorySelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p> -->
                    <input type="hidden" name="category_pid" value="{{$data->category_pid}}">
                    <input type="hidden" name="pid" value="{{$data->pid}}">
                    <div class="row">
                        <div class="col-md-7">
                            <input type="text" name="class[]" placeholder="class e.g JSS 1" value="{{$data->class}}" class="form-control form-control-sm" required>
                            <p class="text-danger class_error"></p>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <select name="class_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                    <option disabled selected>Select Class Number</option>
                                    @foreach(CLASS_NUMBER as $key=> $nm)
                                    <option value="{{$key}}" @if($key==$data->class_number){{'selected'}} @endif>{{$nm}}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                            </div>
                            <p class="text-danger class_number_error"></p>
                        </div>
                    </div>
                    <!-- <p>[Class equivalence in number] is used to promote student to the next class automatically by the system if need be</p> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm updateClassBtn" id="id{{$data->pid}}" pid="{{$data->pid}}"><i class="bi bi-edit"></i> Update</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>