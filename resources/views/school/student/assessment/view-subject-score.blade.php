@extends('layout.mainlayout')
@section('title','View Subject Scores')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            
            <h5 class="card-title">
                 @if(isset($class))
                    {{$class->arm}} <small>{{$class->subject}} <i class="bi bi-calendar-event-fill"></i> {{activeTermName()}} {{activeSessionName()}}</small>
                @endif
                <div class="float-end">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
            <!-- Primary Color Bordered Table -->
             @if(isset($class))
            <table class="table table-bordered border-primary" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">
                            Reg-Number
                        </th>
                        <th scope="col">Names</th>
                        @foreach($scoreParams as $row)
                        <th scope="col">{{$row->title}}/[{{$row->score}}]</th>
                        @endforeach
                        <th scope="col">Total
                            /[100]
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $student)
                    <tr class="studentId" id="{{$student->pid}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$student->reg_number}}</td>
                        <td>  {{ $student->fullname }}</td>
                        @php $total = 0;@endphp
                        @foreach($scoreParams as $row)
                            @php
                            $score = getTitleScore($student->pid,$row->assessment_title_pid);
                            $total += $score;
                            @endphp
                        <td scope="col">
                            {{$score}}
                        </td>
                        @endforeach
                        <td scope="col"> {{$total}}</td>
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

<!-- filter subject form modal  -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-center">View Student Subject Score </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body">
                @csrf
                <label for="category" class="form-label">Category</label>
                <select type="text" name="category" class="form-control" id="assessmentCategorySelect2" required>
                </select>
                <div class="col-12">
                    <label for="session" class="form-label">Session</label>
                    <select type="text" name="session" class="form-control" id="formSessionSelect2">
                    </select>
                </div>

                <div class="col-12">
                    <label for="term" class="form-label">Term</label>
                    <select type="text" name="term" class="form-control" id="formTermSelect2">

                    </select>
                </div>
                <label for="class" class="form-label">Class</label> 
                <select type="text" name="class" class="form-control" id="assessmentClassSelect2" required>
                </select>
          
                <label for="arm" class="form-label">Class Arm</label>
                <select type="text" name="arm" class="form-control" id="assessmentArmSelect2" required>
                </select>
          
                <div class="col-12">
                    <label for="subject" class="form-label">Class Subject</label>
                    <select type="text" name="subject" class="form-control" id="assessmentArmSubjectSelect2">
                    </select>
                </div>
               
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
         multiSelect2('#formSessionSelect2', 'filterModal', 'session', 'Select Session');
         multiSelect2('#formTermSelect2', 'filterModal', 'term', 'Select Term');
        $('#assessmentCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentClassSelect2','filterModal', 'class', id, 'Select Class');
        });
        $('#assessmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentArmSelect2','filterModal', 'class-teacher-arm', id, 'Select Class Arm');
        });
        $('#assessmentArmSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentArmSubjectSelect2','filterModal', 'class-arm-subject', id, 'Select Arm Subject');
        });
        $('#scoreTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });
    });
</script>
@endsection