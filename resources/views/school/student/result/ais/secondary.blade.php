
@include('school.student.result.ais.header')



<hr>


    {{-- subject result  --}}

    <div class="subject-result">
         <table class="table table-hover table-striped table-bordered examTable" cellpadding="pixels">
                    <thead>
                        <tr>
                            <th colspan="2"></th>

                            @foreach($scoreSettings as $row)
                            <th class="rotate-up">{{$row->title}}</th>
                            @endforeach
                            <th class="rotate-up">TOTAL</th>
                            <th class="rotate-up">CLASS MIN</th>
                            <th class="rotate-up">CLASS AVG</th>
                            <th class="rotate-up">CLASS MAX</th>
                            <th class="rotate-up">GRADE</th>
                            <th class="rotate-up">SUBJECT POSITION</th>
                        </tr>
                        <tr>
                            <th width="5%">S/N</th>
                            <th class="flat-row p-2">SUBJECTS</th>
                            @foreach($scoreSettings as $row)
                            <th class="flat-row">{{$row->score}}</th>
                            @endforeach
                            <th class="flat-row">100</th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row">TEACHER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $columnChart = [['Subject','Student Score','Class Min','Class AVG','Class Max']] @endphp
                        @foreach($subResult as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->subject}}</td>
                            @foreach($scoreSettings as $hrow)
                            <td>
                                {{ number_format(getTitleAVGScore(student:$std->pid,pid:$hrow->assessment_title_pid,param:$param,sub:$row->type),1)}}
                            </td>
                            @endforeach
                            <td>{{number_format($row->total,1)}}</td>
                            <td>{{number_format($row->min,1)}}</td>
                            <td>{{number_format($row->avg,1)}}</td>
                            <td>{{number_format($row->max,1)}}</td>
                            @php array_push($columnChart,[$row->subject,$row->total,$row->min,$row->avg,$row->max]) @endphp
                            <td>{{rtnGrade($row->total,$grades)}}</td>
                            <td>{{ordinalFormat($row->position)}}</td>
                            <td>{{$row->subject_teacher_name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                        </tr>
                    </tfoot>
                </table>
    </div>

    {{-- subject result  --}}

    {{-- extra curricular  --}}

    <div class="extra-curricular">

        {{-- table side 50% --}}
        <div class="rating"> 
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
                                <td> {{$rw->title}} </td>
                                <td>{{getPsychoKeyScore(student:$results->student_pid,param:$param,key:$rw->pid)}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach
        </div>
    </div>

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
