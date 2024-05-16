<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#editClassArmModal{{$data->pid}}">Edit</a></li>
        <!-- <li><a class="dropdown-item" href="#">Details</a></li> -->
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#createArmTeacherModal">Assign to Teacher</a></li>
        <!-- <li><a class="dropdown-item" href="#">Class Subject</a></li> -->
    </ul>
</div>

<!-- edit class arm modal  -->

<div class="modal fade" id="editClassArmModal{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Class Arm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="editClassArmFrom{{$data->pid}}">
                    @csrf
                    <div class="row">
                        <!-- <div class="col-md-6">
                            <select name="category_pid" id="ccaCategorySelect2" class="ccaCategorySelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                        </div>
                        <div class="col-md-6">
                            <select name="class_pid" id="ccaClassSelect2" class="ccaclassSelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div> -->

                        <input type="hidden" name="class_pid" value="{{$data->class_pid}}">
                        <input type="hidden" name="category_pid" value="{{$data->category_pid}}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="arm">Class Arm Name</label>
                            <input type="text" name="arm[]" placeholder="class arm" value="{{$data->arm}}" class="form-control form-control-sm">
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Class Arm Serial Number</label>
                            <div class="input-group mb-3">
                                <select name="arm_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                    <option disabled selected>Select Class Number</option>
                                    @foreach(CLASS_NUMBER as $key=> $nm)
                                    <option value="{{$key}}" @if($key==$data->arm_number){{'selected'}} @endif>{{$nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-danger arm_number_error"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm updateClassArmBtn" id="id{{$data->pid}}" pid="{{$data->pid}}">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- create class subject  -->
<div class="modal fade" id="createArmTeacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign {{$data->arm}} To Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createArmTeacherForm">
                    @csrf
                    <p class="text-danger term_pid_error"></p>
                    <label for="teacher_pid">Teacher</label>
                    <select name="teacher_pid" id="assignClassToteacherSelect2" style="width: 100%;" class="teacherSelect2 form-control form-control-sm">
                    </select>
                    <p class="text-danger teacher_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createArmSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>