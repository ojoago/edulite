<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer " data-bs-toggle="modal" data-bs-target="#updateCategoryModal{{$data->pid}}">Edit</a></li>
        {{-- <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#assignHead{{$data->pid}}">Assign Head</a></li> --}}
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#categoryDetail{{$data->pid}}">Details</a></li>
        <li><a class="dropdown-item deleteCategory bg-danger pointer" pid = "{{$data->pid}}" >Delete</a></li>
    </ul>
</div>

<div class="modal fade" id="categoryDetail{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Category Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($data->categoryClass->isNotEmpty())
                <strong>{{$data->category}}</strong>
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Class</th>
                            <th>Class Number</th>
                            <th>Class Arms</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->categoryClass as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->class}}</td>
                            <td>{{$row->class_number}}</td>
                            <td>
                                @foreach($row->classArms as $arm)
                                {{$arm->arm}}, &nbsp;
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                 No class created under <strong>{{$data->category}}</strong> category
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="assignHead{{$data->pid}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Head to {{$data->category}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createArmTeacherForm">
                    @csrf
                    <label for="teacher_pid">Teacher</label>
                    <select name="teacher_pid" id="subjectTeacherSelect2" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger teacher_pid_error"></p>
                    <input type="hidden" name="pid" value="{{$data->pid}}" id="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createArmSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- create school category modal  -->
<div class="modal fade" id="updateCategoryModal{{$data->pid}}" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="updateCategoryForm{{$data->pid}}">
                    @csrf
                    <input type="text" name="category" id="categoryName" value="{{ $data->category }}" class="form-control form-control-sm" placeholder="school category" required>
                    <input type="hidden" name="pid" value="{{ $data->pid }}" id="categoryPid">
                    <p class="text-danger category_error"></p>
                    <label for="head_pid">Principal/Head</label>
                    <select name="head_pid" class="form-control form-control-sm" style="width: 100%;">
                        @foreach($heads as $item)
                            <option value="{{$item->pid}}" {{ $data->head_pid == $item->pid ? 'selected' : '' }}> {{$item->fullname}}</option>
                        @endforeach
                    </select>
                    <p class="text-danger head_pid_error"></p>
                        <select name="number" id="classNumberSelect" class="form-control form-control-sm">
                            <option disabled selected>Select Serial Number</option>
                            @foreach(CLASS_NUMBER as $key=> $nm)
                                <option value="{{$key}}" {{ $data->number == $key ? 'selected' : '' }}> {{$nm}}</option>
                            @endforeach
                        </select>
                    <p class="text-danger number_error"></p>
                    <textarea type="text" name="description" id="categoryDescription" class="form-control form-control-sm" placeholder="description" required>{{ $data->description }}</textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm updateCategoryBtn" pid="{{$data->pid}}" id="updateCategoryBtn{{$data->pid}}">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal end here  -->
