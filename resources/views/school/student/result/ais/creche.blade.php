
@include('school.student.result.ais.header')


<style>
 
</style>


<hr>

{{-- student infor  --}}

<table id="studentDetailTable">
    <tr>
        <td colspan="2"> <b>PUPIL NAME</b> {{$std->fullname}}</td>
        <td colspan="2"> <b>TERM</b> {{$results->term}}</td>
    </tr>
    <tr>
        <td > <b> GENDER</b> </td>
        <td>{{$std->gender}}</td>
        <td><b>SESSION</b> {{$results->session}}</td>
        <td> <b>NEXT TERM BEGINS</b> </td>
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
                        <td>{{getPsychoKeyScore(student:$results->student_pid,param:$param,key:$rw->pid)}} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    <table id="teacherTable">
        <tr>
            <td colspan="3"><b>Name of Teacher:</b> {{$results->teacher_name}}</td>
        </tr>
        <tr>
            <td colspan="3"><b>Teacher's Comment:</b> {{$results->class_teacher_comment}}</td>
        </tr>
        <tr>
            <td></td>
            <td>Sign </td>
            <td>Date:</td>
        </tr>

       
        <tr>
            <td colspan="3"><b>Principal's Comment:</b> {{$results->principal_comment}} </td>
        </tr>
        <tr>
            <td></td>
            <td>Sign </td>
            <td>Date:</td>
        </tr>

    </table>
