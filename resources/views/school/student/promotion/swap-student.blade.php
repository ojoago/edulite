@extends('layout.mainlayout')
@section('title','Swap Student')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            {{-- <h5 class="card-title">Swap Student</h5> --}}
                 <h5 class="card-title">
                @if(isset($className))
                    Swap Student, Class: {{$className}} 
                @endif
                <div class="float-end">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
            @if (isset($data))
                <table class="table table-bordered border-primary cardTable" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr class="studentId" id="{{$row->pid}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->reg_number}}</td>
                        <td>{{ $row->fullname }}</td>
                        <td scope="col" width="5%" align="center">
                            <button class="btn btn-sm btn-info swapStudent" pid="{{$row->pid}}"><i class="bi bi-subtract pointer" title="Swap Student" data-bs-toggle="tooltip"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                 <h3 class="card-title text-center">Click On filter to select class </h3>
            @endif
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>


<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title h6">Create Extra Curricular Name</h5> --}}
                 <p class="text-center small">Promote Student To next class</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body">
                @csrf
                <label for="category" class="form-label">Category</label>
                <select type="text" name="category" class="form-control" id="assessmentCategorySelect2" required>
                </select>
            
                <label for="class" class="form-label">Class</label> 
                <select type="text" name="class" class="form-control" id="assessmentClassSelect2" required>
                </select>
          
                <label for="arm" class="form-label">Class Arm</label>
                <select type="text" name="arm" class="form-control" id="assessmentArmSelect2" required>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </form>
    </div>
</div><!-- filter form-->
<!-- hire me  -->
<div class="modal fade" id="swapStudentModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info">Swap Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="swapStudentForm">
                    @csrf
                    <div class="col-12">
                        <label for="category" class="form-label">Category</label>
                        <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                        </select>
                        <p class="text-danger category_error"></p>
                        <input type="hidden" name="pid" id="studentPid">
                    </div>
                    <div class="col-12">
                        <label for="class" class="form-label">Class</label>
                        <select type="text" name="class" class="form-control" id="formClassSelect2">
                        </select>
                        <p class="text-danger class_error"></p>
                    </div>
                    <div class="col-12">
                        <label for="arm" class="form-label">Class Arm</label>
                        <select type="text" name="arm" class="form-control" id="formArmSelect2">
                        </select>
                        <p class="text-danger arm_error"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" type="button" id="swapStudentBtn">Submit</button>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

         multiSelect2('#assessmentCategorySelect2', 'filterModal', 'category', 'Select Category');
        $('#assessmentCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentClassSelect2','filterModal', 'class', id, 'Select Class');
        });
        $('#assessmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentArmSelect2','filterModal', 'class-teacher-arm', id, 'Select Class Arm');
        });

        $('.swapStudent').click(function() {
            let pid = $(this).attr('pid');
            $('#studentPid').val(pid);
            $('#swapStudentModal').modal('show');
        })

        multiSelect2('#formCategorySelect2', 'swapStudentModal', 'category', 'Select Category');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formClassSelect2', 'swapStudentModal', 'class', id, 'Select Class');
        });
        $('#formClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formArmSelect2', 'swapStudentModal', 'class-arm', id, 'Select Class Arm');
        });

        // swap student
        $('#swapStudentBtn').click(async function() {
            data = await submitFormAjax('swapStudentForm', 'swapStudentBtn', "{{route('swaping.student')}}");
            if (data.status === 1) {
                var pid = $('#studentPid').val();
                $('table#scoreTable tr#' + pid).remove();
            }
        });

    });
</script>
@endsection