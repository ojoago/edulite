
@include('school.student.result.ais.header')

<style>
    .extra-curricular{
        display: flex;
        justify-content: space-between
    }
    .result-header{

    }

    .f-row,.s-row{
        display: flex;
        justify-content: space-between
    }
    
    .dotted{    
        border-bottom: 2px dotted  #000;
        color: #000;
        margin: 5px 10px;
    }
    .lf{
        flex-basis: 100%;
        text-align: left;
        
    }
    .rt{
        flex-basis: 40%;
        text-align: left;
    }
    .s-row .f1, 
    .s-row .f2, 
    .s-row .f3, 
    .s-row .f4{
        flex-basis: 25%;
        text-align: left;
    }
    .f1,.f2,.f3{
        flex-basis: 33%;
        text-align: left;
    }

    .b-row{
        display: flex;

    }
    .br{
        flex-basis: 100%;
    }
    
    .bd,.bc{
        flex-basis: 50%;
        margin: 5px 10px;

    }
    .solid{
        border-bottom: 1px solid #000;
        margin: 5px 10px;
    }

</style>

<hr>

{{-- reust header  --}}

<div class="result-header">
    
<h3 class="text-uppercase">
    Secondary result evaluation 
</h3>


    <div class="f-row">
        <div class="lf solid">
            Name of Pupil: {{$std->fullname}}
        </div>
        {{-- <div class="rt solid">Gender: </div> --}}
    </div>

    <div class="f-row">

        <div class="f1 solid">
            Class: {{$result->arm}}
        </div>
        <div class="f2 solid">Term: {{$result->term}} </div>
        <div class="f3 solid">Age: {{dateToAge($std->dob)}} </div>
        {{--  --}}
        
    </div>
    
    <div class="s-row">
        <div class="f1 solid">Next Term Begins: {{$result->next_term}} </div>
        <div class="f2 solid">Gender: {{$std->gender}} </div>
        <div class="f3 solid">Session: {{$result->session}} </div>
        <div class="f4 solid">Pupil's Total: {{number_format($result->total,1)}} </div>

    </div>
    
    <div class="f-row">
        <div class="f1 solid">
            Pupil's Average: {{number_format($result->average,1)}}
        </div>
        <div class="f2 solid">Class Average: {{number_format($result->class_average,1)}} </div>
        <div class="f3 solid">Promoted/Not Promoted </div>

    </div>

</div>
    {{-- subject result  --}}

    <div class="subject-result">
         <table class="table table-hover table-striped table-bordered examTable" id="examTable" cellpadding="pixels">
                    <thead>
                        <tr>
                            {{-- <th colspan="2"></th> --}}
                             <th class="flat-row p-2">SUBJECTS</th>
                            @foreach($scoreSettings as $row)
                            <th class="rotate-up">{{$row->title}} ({{$row->score}}%)</th>
                            @endforeach
                            @foreach($terms as $term)
                            <th class="rotate-up">{{$term->term}} (100%)</th>
                            @endforeach
                            <th class="rotate-up">Cumulative Average</th>
                            <th class="rotate-up">GRADE</th>
                            <th class="rotate-up">Subject Average</th>
                            <th class="rotate-up">SUBJECT POSITION</th>
                            <th class="flat-row">TEACHER</th>
                            <th class="flat-row">Remarks</th>

                        </tr>
                        
                    </thead>
                    <tbody>
                        @php $columnChart = [['Subject','Student Score','Class Min','Class AVG','Class Max']] @endphp
                        @foreach($subResult as $row)
                        <tr>
                            {{-- <td>{{$loop->iteration}}</td> --}}
                            <td>{{$row->subject}}</td>
                            @foreach($scoreSettings as $hrow)
                            <td>
                                {{ number_format(getTitleAVGScore(student:$std->pid,pid:$hrow->assessment_title_pid,param:$param,sub:$row->type),1)}}
                            </td>
                            @endforeach
                            {{-- <td>{{getTitleAVGScore(student:$std->pid,pid:$hrow->assessment_title_pid,param:$param,sub:$row->type)}}</td> --}}
                            @foreach($terms as $term)
                            <td >
                                {{ number_format(getSubjectTotalScore(student:$std->pid,param:$term->pid,sub:$row->type),1)}}

                            </td>
                            @endforeach
                            <td>
                                {{ number_format(getSubjectAVGScore(student:$std->pid,session:$term->session_pid,sub:$row->type),1)}}
                            </td>
                            {{-- <td>{{number_format($row->total,1)}}</td> --}}
                            {{-- <td>{{number_format($row->min,1)}}</td>
                            <td>{{number_format($row->avg,1)}}</td>
                            <td>{{number_format($row->max,1)}}</td> --}}
                            @php array_push($columnChart,[$row->subject,$row->total,$row->min,$row->avg,$row->max]) @endphp
                            <td>{{rtnGrade($row->total,$grades)}}</td>
                            <td>{{$row->avg}}</td>
                            <td>{{ordinalFormat($row->position)}}</td>
                            <td>{{$row->subject_teacher_name}}</td>
                            <td> </td>
                        </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <td>Total</td>
                        </tr>
                    </tfoot> --}}
                </table>
    </div>

    {{-- subject result  --}}

    {{-- extra curricular  --}}

    <div class="extra-curricular">
 @foreach($psycho as $row)
                @if($row->baseKey->isNotEmpty())
                    <table class="psychoTable">
                        <thead>
                            <tr>
                                <th>{{$row->psychomotor}}</th>
                                @for ($i = $row->max; $i > 0; $i--)
                                    <th>{{$i}}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($row->baseKey as $rw)
                            @php
                                $score = getPsychoKeyScore(student:$result->student_pid,param:$param,key:$rw->pid);
                            @endphp
                            <tr>
                                <td> {{$rw->title}} </td>
                                @for ($i = $row->max; $i > 0; $i--)
                                    @if($i == $score)
                                    <td> <i class="bi bi-check"></i></td>
                                    @else
                                    <td></td>
                                    @endif
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach

            {{-- @include('school.student.result.curricula-type.'.$psycho[0]->grade) --}}
        </div>
    </div>

     <div class="result-footer">
        <div class="b-row">
            <div class="br solid">
               Teacher‘s  Comment: {{$result->class_teacher_comment}}
            </div>
        </div>

        <div class="b-row">
            <div class="bd solid signature-container">
                Signature: 
                <div class="signature-base">
                    @php $imgUrl = $result->signature ? asset("/files/images/".$result->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            <div class="bc solid">Date: {{formatDate($result->date)}}</div>
        </div>

        <div class="b-row">
            <div class="br solid">
               Principal’s  Comment: {{$result->principal_comment}}
            </div>
        </div>

        <div class="b-row">
            <div class="bd solid signature-container">
                Signature: 
                <div class="signature-base">
                    @php $imgUrl = $result->principal_signature ? asset("/files/images/".$result->principal_signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            <div class="bc solid">Date: {{formatDate($result->date)}} </div>
        </div>
     </div>

{{-- chart  --}}

 <div class="col-md-12 mt-4">
            <div id="column_Chart" class="chartZoomable" style="width:98%;height:auto;"></div>
        </div>


     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {{-- <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.load('current', {
            'packages': ['line']
        });

        google.charts.setOnLoadCallback(drawColumnChart);
        let dataset = <?php echo json_encode($columnChart, JSON_NUMERIC_CHECK) ?>
        // console.log(dataset);
        function drawColumnChart() {

            var data = google.visualization.arrayToDataTable(dataset);

            var view = new google.visualization.DataView(data);
            // view.setColumns([0, 4,
            //     {
            //         calc: "stringify",
            //         sourceColumn: 1,
            //         type: "string",
            //         role: "annotation"
            //     },
            //     3
            // ]);

            var options = {
                title: "Student Score Against total, MIN, MAX & AVG",
                // subtitle: "based on meter type and installation status",
                bar: {
                    groupWidth: "20%"
                },
                legend: {
                    position: "top"
                },
            };
            var chart = new google.visualization.LineChart(document.getElementById("column_Chart"));
            chart.draw(view, options);
        }
    </script> --}}
     <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.load('current', {
            'packages': ['bar']
        });

        google.charts.setOnLoadCallback(drawColumnChart);
        let dataset = <?php echo json_encode($columnChart, JSON_NUMERIC_CHECK) ?>
        // console.log(dataset);
        function drawColumnChart() {

            var data = google.visualization.arrayToDataTable(dataset);

            var view = new google.visualization.DataView(data);

            var options = {
                title: "Student Score Against total, MIN, MAX & AVG",
                // subtitle: "based on meter type and installation status",
                bar: {
                    groupWidth: "20%"
                },
                legend: {
                    position: "top"
                },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("column_Chart"));
            chart.draw(view, options);
        }
    </script>
