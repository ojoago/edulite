<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-tools"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item pointer editCategory" pid="{{base64Encode($data->pid)}}">Edit</a></li>
        {{-- <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#assignHead{{$data->pid}}">Assign Head</a></li> --}}
        <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#categoryDetail{{$data->pid}}">Details</a></li>
        <!-- <li><a class="dropdown-item" href="#">Disable</a></li> -->
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