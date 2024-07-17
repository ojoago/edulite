<link href="{{ public_path('css/pdf.css') }}" rel="stylesheet" type="text/css" />
<style  type="text/css" media="all">
    

        .rotate-up {
            vertical-align: bottom !important;
            text-align: center !important;
            /* font-weight: normal; */
        }

        .rotate-up {
            -ms-writing-mode: tb-rl !important;
            -webkit-writing-mode: vertical-rl !important;
            writing-mode: vertical-rl !important;
            /* translate(25px, 51px) // 45 is really 360-45 */
            /* rotate(315deg); */
            /* transform: rotate(315deg) translate(25px, 51px); */
            white-space: nowrap !important;
            /* overflow: hidden; */
            /* width: 25px; */
            transform: rotate(180deg) !important;
            /* height: 150px; */
            width: 30px !important;
            /* transform-origin: left bottom; */
            /* box-sizing: border-box; */
        }
        .subject-column{
            text-align: left !important;
        }

</style>

    <div class="subject-result">
         <table class="table table-hover table-striped table-bordered examTable" id="examTable" cellpadding="pixels">
                    <thead>
                        <tr>
                            @if (@$setting->serial_number == 1)
                             <th width="5%">S/N</th>
                            @endif
                            <th class="flat-row p-2 subject-column" align="left" >SUBJECTS</th>
                            @foreach($scoreSettings as $row)
                            <th class="rotate-up">{{$row->title}} ({{$row->score}}%)</th>
                            @endforeach
                            @foreach($terms as $term)
                            <th class="rotate-up">{{$term->term}} (100%)</th>
                            @endforeach
                            <th class="rotate-up">Cumulative Average</th>
                            @if (@$setting->subject_grade == 1)
                                <th class="rotate-up">GRADE</th>
                            @endif
                            @if (@$setting->subject_average == 1)
                                <th class="rotate-up">Subject Average</th>
                            @endif
                            @if (@$setting->subject_position == 1)
                                <th class="rotate-up">SUBJECT POSITION</th>
                            @endif
                            @if (@$setting->subject_teacher == 1)
                                <th class="flat-row">TEACHER</th>
                            @endif
                            @if (@$setting->remark == 1)
                                <th class="flat-row">Remarks</th>
                            @endif

                        </tr>
                        
                    </thead>
                    <tbody>
                        @foreach($subResult as $row)
                        <tr>
                            @if (@$setting->serial_number == 1)
                             <td>{{$loop->iteration}}</td>
                            @endif
                            <td align="left" class="subject-column">{{$row->subject}}</td>
                            @foreach($scoreSettings as $hrow)
                            <td>
                                {{ number_format(getTitleAVGScore(student:$std->pid,pid:$hrow->assessment_title_pid,param:$param,sub:$row->type),1)}}
                            </td>
                            @endforeach
                            @foreach($terms as $term)
                            <td >
                                {{ number_format(getSubjectTotalScore(student:$std->pid,param:$term->pid,sub:$row->type),1)}}

                            </td>
                            @endforeach
                            <td>
                                {{ number_format(getSubjectAVGScore(student:$std->pid,session:$term->session_pid,sub:$row->type),1)}}
                            </td>
                           
                             @if (@$setting->subject_grade == 1)
                                <td>  {{ $row->grade ?? rtnGrade($row->total,$grades)}}</td>
                            @endif
                            @if (@$setting->subject_average == 1)
                                <td>{{$row->avg}}</td>
                            @endif
                            @if (@$setting->subject_position == 1)
                                <td>{{ordinalFormat($row->position)}}</td>
                            @endif
                            @if (@$setting->subject_teacher == 1)
                               <td>{{$row->subject_teacher_name}}</td>
                            @endif
                            @if (@$setting->remark == 1)
                               <td> </td>
                            @endif
                            
                        </tr>
                        @endforeach
                    </tbody>
                  
                </table>
    </div>