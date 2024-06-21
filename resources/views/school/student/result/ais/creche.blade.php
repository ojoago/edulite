
@include('school.student.result.ais.header')



<hr>

{{-- student infor  --}}

<table border="1">
    <tr>
        <td colspan="2">Pupil Name</td>
        <td colspan="2">Term</td>
    </tr>
    <tr>
        <td >Gender</td>
        <td></td>
        <td>Session</td>
        <td>next Term begins</td>
    </tr>
    <tr>
        <td >Height</td>
        <td></td>
        <td>Weight</td>
        <td></td>
    </tr>
</table>

{{-- student infor  --}}

    @foreach($psycho as $row)
        @if($row->baseKey->isNotEmpty())
            <table class="table table-hover table-striped table-bordered w-30">
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


    <table class="table table-bordered w-30">
        <tr>
            <td colspan="3">Name of Teacher</td>
        </tr>
        <tr>
            <td colspan="3">Teacher's Comment:</td>
        </tr>
        <tr>
            <td></td>
            <td>Sign </td>
            <td>Date:</td>
        </tr>

       
        <tr>
            <td colspan="3">Principal's Comment:</td>
        </tr>
        <tr>
            <td></td>
            <td>Sign </td>
            <td>Date:</td>
        </tr>

    </table>
