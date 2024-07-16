@extends('layout.mainlayout')
@section('title','View Subject Scores')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            
            <h5 class="card-title">
                 @if(isset($param))
                    {{$param->arm}} <small>{{$param->subject}} <i class="bi bi-calendar-event-fill"></i> {{activeTermName()}} {{activeSessionName()}}</small>
                @endif
               
            </h5>
            <!-- Primary Color Bordered Table -->
             @if(isset($param))
            <table class="table table-bordered border-primary" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col"> Status </th>
                        <th scope="col"> Reg-Number </th>
                        <th scope="col">Names</th>
                        <th scope="col"> Seated ? </th>
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
                        <td>{{STUDENT_STATUS[$student->status]}}</td>
                        <td>{{$student->reg_number}}</td>
                        <td>  {{ $student->fullname }}</td>
                        <td>  {{ $student->seated == 1 ? 'True' : 'False' }}</td>
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
          
            @endif
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#scoreTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });
    });
</script>
@endsection