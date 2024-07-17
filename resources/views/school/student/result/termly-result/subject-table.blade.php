
@php
    $rotate_up = '
        vertical-align: bottom !important;
        text-align: center !important;
        -ms-writing-mode: tb-rl !important;
        -webkit-writing-mode: vertical-rl !important;
        writing-mode: vertical-rl !important;
        white-space: nowrap !important;
        transform: rotate(180deg) !important;
        width: 30px !important;
    ';

    $table_style = '
        border: solid 1px #000;
        margin-bottom: 15px;
    ';
    $table_head = '
        background: #000;
        color: #fff;
        text-align: center;
    ';
    $table_data = '
        border: solid 1px #000;
        text-align: center;
    ';
@endphp

    <div class="subject-result">
         <table class="table table-hover table-striped table-bordered examTable" id="examTable" cellpadding="pixels">
                    <thead>
                        <tr style="{{$table_head}}">
                            @if (@$setting->serial_number == 1)
                             <th width="5%">S/N</th>
                            @endif
                            <th class="flat-row p-2 subject-column" style="text-align: left !important" align="left" >SUBJECTS</th>
                            @foreach($scoreSettings as $row)
                            <th class="rotate-up" style="{{$rotate_up}}">{{$row->title}} ({{$row->score}}%)</th>
                            @endforeach
                            @foreach($terms as $term)
                            <th class="rotate-up" style="{{$rotate_up}}">{{$term->term}} (100%)</th>
                            @endforeach
                            <th class="rotate-up" style="{{$rotate_up}}">Cumulative Average</th>
                            @if (@$setting->subject_grade == 1)
                                <th class="rotate-up" style="{{$rotate_up}}">GRADE</th>
                            @endif
                            @if (@$setting->subject_average == 1)
                                <th class="rotate-up" style="{{$rotate_up}}">Subject Average</th>
                            @endif
                            @if (@$setting->subject_position == 1)
                                <th class="rotate-up" style="{{$rotate_up}}">SUBJECT POSITION</th>
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
                        <tr style="">
                            @if (@$setting->serial_number == 1)
                             <td>{{$loop->iteration}}</td>
                            @endif
                            <td align="left" style="text-align: left !important">{{$row->subject}}</td>
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
                                @php
                                    $remark = rtnGrade($row->total,$grades);
                                @endphp
                             @if (@$setting->subject_grade == 1)
                                <td>  {{ $row->grade ?? $remark['grade']}}</td>
                            @endif
                            @if (@$setting->subject_average == 1)
                                <td>{{number_format($row->avg,1)}}</td>
                            @endif
                            @if (@$setting->subject_position == 1)
                                <td>{{ordinalFormat($row->position)}}</td>
                            @endif
                            @if (@$setting->subject_teacher == 1)
                               <td>{{$row->subject_teacher_name}}</td>
                            @endif
                            @if (@$setting->remark == 1)
                               <td> {{ mb_strtoupper($row->title) ?? $remark['title'] }}</td>
                            @endif
                            
                        </tr>
                        @endforeach
                    </tbody>
                  
                </table>
    </div>