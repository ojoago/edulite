@extends('layout.mainlayout')
@section('title','Enter Student Scores')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                @if(isset($class))
                    {{$class}} <small>Result</small> <i class="bi bi-calendar-event-fill"></i> {{$term}} {{$session}}
                @endif
                <div class="float-end">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
           
            
            @if(isset($data))
                <!-- Primary Color Bordered Table -->
            <table class="table table-bordered border-primary cardTable" id="resultTable">
                <thead>
                    @if ($subjects)
                        <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Position</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Subjects</th>
                        <th scope="col">Total</th>
                        <th scope="col">Average</th>
                        <th scope="col">Class Teacher's Comment</th>
                        <th scope="col">Principal's Comment</th>
                        @if(getSchoolType()!=1)
                        <th scope="col">Portal's Comment</th>
                        @endif
                    </tr>
                    @else
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Class Teacher's Comment</th>
                        <th scope="col">Principal's Comment</th>
                        @if(getSchoolType()!=1)
                        <th scope="col">Portal's Comment</th>
                        @endif
                        <th>Action</th>
                    </tr>
                    @endif
                    
                </thead>
                <tbody>
                    @foreach($data as $row)
                    
                    @if ($subjects)
                        <tr class="studentId">
                        <td>{{$loop->iteration}}</td>
                        <td>{{ordinalFormat(@$row->position)}}</td>
                        <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                        <td>{{$row->fullname}}</td>
                        <td>{{@$row->count}}</td>
                        <td>{{number_format($row->total,2)}}</td>
                        <td>{{number_format(@$row->average,1)}}</td>
                        <td>{{$row->class_teacher_comment}}</td>
                        <td>{{$row->principal_comment}}</td>
                        @if(getSchoolType()!=1)
                        <td>{{$row->portal_comment}}</td>
                        @endif
                        <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer"> <button class="btn btn-sm btn-primary">View Detail</button> </a></td>
                    </tr>
                    @else
                        <tr class="studentId">
                        <td>{{$loop->iteration}}</td>
                        <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                        <td>{{$row->fullname}}</td>
                        <td>{{$row->class_teacher_comment}}</td>
                        <td>{{$row->principal_comment}}</td>
                        @if(getSchoolType()!=1)
                        <td>{{$row->portal_comment}}</td>
                        @endif
                        <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer"> <button class="btn btn-sm btn-primary">View Detail</button> </a></td>
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
                 <p class="text-center small">Load Class Result</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body">
                @csrf
                <label for="session" class="form-label">Session</label>
                <select type="text" name="session" class="form-control" id="resultSessionSelect2" required>
                </select>

                <label for="term" class="form-label">Term</label>
                <select type="text" name="term" class="form-control" id="resultTermSelect2" required>
                </select>

                <label for="category" class="form-label">Category</label>
                <select type="text" name="category" class="form-control" id="resultCategorySelect2" required>
                </select>
            
                <label for="class" class="form-label">Class</label> 
                <select type="text" name="class" class="form-control" id="resultClassSelect2" required>
                </select>
          
                <label for="arm" class="form-label">Class Arm</label>
                <select type="text" name="arm" class="form-control" id="resultArmSelect2" required>
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


        multiSelect2('#resultTermSelect2', 'filterModal', 'term', 'Select Term');
        multiSelect2('#resultSessionSelect2', 'filterModal', 'session', 'Select Session');
        multiSelect2('#resultCategorySelect2', 'filterModal', 'category', 'Select Category');
        $('#resultCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#resultClassSelect2','filterModal', 'class', id, 'Select Class');
        });
        $('#resultClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#resultArmSelect2','filterModal', 'class-teacher-arm', id, 'Select Class Arm');
        });


        $('#resultTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });

    });
</script>
@endsection