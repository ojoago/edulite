
@include('school.student.result.ais.header')


<style>
 
</style>


@php
        $settings = null;
        if($result_config->settings){
            $settings = json_decode($result_config->settings) ;
        }
    @endphp
{{-- student infor  --}}
<table id="studentDetailTable">
    <tr>
        <td colspan="2"> <b> {{@$settings->student_name ? @$settings->student_name : 'PUPIL'}} NAME</b> {{$std->fullname}}</td>
        <td colspan="2"> <b>TERM</b> {{$result->term}}</td>
    </tr>
    <tr>
        <td > <b> GENDER</b> </td>
        <td>{{$std->gender}}</td>
        <td><b>SESSION</b> {{$result->session}}</td>
        <td> <b>NEXT TERM BEGINS:</b> {{formatDate($result->next_term)}} </td>
    </tr>
    <tr>
        <td ><b>HEIGHT</b>  </td>
        <td>{{$std->height}}</td>
        <td><b>WEIGHT</b></td>
        <td>{{$std->weight}}</td>
    </tr>
</table>

<b class="rating">KEY TO RATINGS: 5 - EXCELLENT, 4 - VERY GOOD, 3 - GOOD 2 - FAIR 1 - POOR </b>

{{-- student infor  --}}


    @foreach($psycho as $row)
        @if($row->baseKey->isNotEmpty())
            <table class="psychoTable">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>{{$row->psychomotor}}</th>
                        <th>RATING</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($row->baseKey as $rw)
                    <tr>
                        <td> {{$loop->iteration}} </td>
                        <td> {{$rw->title}} </td>
                        <td>{{getPsychoKeyScore(student:$result->student_pid,param:$param,key:$rw->pid)}} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    <table id="teacherTable">
        <tr>
            <td colspan="3"><b>{{@$settings->class_teacher ? @$settings->class_teacher : 'Name of Teacher'}}:</b> {{$result->teacher_name}}</td>
        </tr>
        <tr>
            <td colspan="3"><b>{{@$settings->class_teacher ? @$settings->class_teacher : 'Teacher'}}'s Comment:</b> {{$result->class_teacher_comment}}</td>
        </tr>
        <tr>
            <td></td>
            <td>Sign </td>
            <td>Date:</td>
        </tr>

       
        <tr>
            <td colspan="3"><b>{{@$settings->head_teacher ? @$settings->head_teacher : 'Principal'}}'s Comment:</b> {{$result->principal_comment}} </td>
        </tr>
        <tr>
            <td></td>
            <td>Sign </td>
            <td>Date:</td>
        </tr>

    </table>

<a href="{{route('student.report.card.pdf',['param'=>$param , 'pid' => $std->pid])}}"> <button class="btn btn-primary m-2">Print</button> </a>
