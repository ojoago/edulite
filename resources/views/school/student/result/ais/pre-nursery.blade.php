
@include('school.student.result.ais.header')



<hr>

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

     <div class="col-md-12">
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