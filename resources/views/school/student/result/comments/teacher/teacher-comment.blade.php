@extends('layout.mainlayout')
@section('title',"Teacher's Comment")
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
                <h5 class="card-title">
                @if(isset($class))
                   Comment {{$class}} <small>Result</small>
                @endif
                <div class="float-end">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
            @if(isset($data))
                <table class="table table-bordered border-primary  cardTable" id="resultTable">
                <thead>
                    @if ($subjects)
                        <tr>
                        <th scope="col" width="5%">S/N</th>
                        <th scope="col">Position</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Subjects</th>
                        <th scope="col">Total</th>
                        <th scope="col">Average</th>
                        <th scope="col">Class Teacher's Comment</th>
                        @if(getSchoolType()!=1)
                        <th scope="col">Portal's Comment</th>
                        @endif
                    </tr>
                    @else
                    <tr>
                        <th scope="col" width="5%">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Class Teacher's Comment</th>
                        @if(getSchoolType()!=1)
                        <th scope="col">Portal's Comment</th>
                        @endif
                    </tr>
                    @endif
                    
                </thead>
                <tbody>
                    @foreach($data as $row)
                        @if ($subjects)
                            <tr class="studentId">
                                <td>{{$loop->iteration}}</td>
                                <td>{{ordinalFormat($row->position)}}</td>
                                <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                                <td>{{$row->fullname}}</td>
                                <td>{{$row->count}}</td>
                                <td>{{number_format($row->total,1)}}</td>
                                <td>{{number_format($row->average,1)}}</td>
                                <td><textarea type="text" param="{{$row->class_param_pid}}" std="{{$row->student_pid}}" class="form-control form-control-sm comment" placeholder="Teacher's Comment">{{$row->class_teacher_comment}}</textarea> </td>
                                @if(getSchoolType()!=1)
                                <td>{{$row->portal_comment}}</td>
                                @endif
                            </tr>
                        @else
                            <tr class="studentId">
                                <td>{{$loop->iteration}}</td>
                                <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                                <td>{{$row->fullname}}</td>
                                <td><textarea type="text" param="{{$row->class_param_pid}}" std="{{$row->student_pid}}" class="form-control form-control-sm comment" placeholder="Teacher's Comment">{{$row->class_teacher_comment}}</textarea> </td>
                                @if(getSchoolType()!=1)
                                <td>{{$row->portal_comment}}</td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>

                </form>
            </table>
            <!-- End Primary Color Bordered Table --> 
            @else
                <h3 class="card-title text-center">Click On filter to select class </h3>
            @endif
           

        </div>
    </div>
</div>

<!-- filter subject form modal  -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title h6">Create Extra Curricular Name</h5> --}}
                 <p class="text-center small">load Student Result </p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body">
                @csrf
                 <label for="session" class="form-label">Session</label>
                <select type="text" name="session" class="form-control" id="formSessionSelect2">
                </select>

                <label for="term" class="form-label">Term</label>
                <select type="text" name="term" class="form-control" id="formTermSelect2">
                </select>
                
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


<script>
    $(document).ready(function() {

        multiSelect2('#assessmentCategorySelect2', 'filterModal', 'category', 'Select Category');
        multiSelect2('#formTermSelect2', 'filterModal', 'term', 'Select Term');
        multiSelect2('#formSessionSelect2', 'filterModal', 'session', 'Select Session');
        $('#assessmentCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentClassSelect2','filterModal', 'class', id, 'Select Class');
        });
        $('#assessmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentArmSelect2','filterModal', 'class-teacher-arm', id, 'Select Class Arm');
        });

        $('#resultTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });
        $('.comment').change(function() {
            var comment = $(this).val();
            let param = $(this).attr('param');
            let std = $(this).attr('std');
            let token = "{{csrf_token()}}";
            $.ajax({
                url: "{{route('comment.teacher.student.termly.result')}}",
                type: "post",
                data: {
                    comment: comment,
                    std: std,
                    param: param,
                    _token: token
                },
                success: function(data) {
                    showTipMessage(data)
                },
                error: function(data) {
                    showTipMessage('Last Score not saved!!!');
                }
            });
        });
        var arm = "{{session('arm')}}";
        if (arm != null) {
            getArmSubject(arm)
        }
        var class_pid = "{{session('class')}}";
        if (class_pid != null) {
            getClassArms(class_pid)
        }
        // $('#formClassSelect2').on('change', function(e) {
        //     var id = $(this).val();
        //     FormMultiSelect2Post('#formArmSelect2', 'class-arm', id, 'Select Class Arm');
        // });
        // $('#formArmSelect2').on('change', function(e) {
        //     var id = $(this).val();
        //     FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        // })

        $('#formArmSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        });

        function getClassArms(id) {
            FormMultiSelect2Post('#formArmSelect2', 'class-arm', id, 'Select Class Arm');
        }

        function getArmSubject(id) {
            FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        }
    });
</script>
@endsection