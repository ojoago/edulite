
@include('school.student.result.ais.header')

{{-- extra-curricular --}}
<style>
    .extra-curricular{
        display: flex;
        justify-content: space-between
    }
    .result-header{

    }

    .f-row{
        display: flex;
        justify-content: space-between
    }
    
    .dotted{    
        border-bottom: 2px dotted  #000;
        color: #000;
        margin: 5px 10px;
    }
    .lf{
        flex-basis: 60%;
        text-align: left;
        
    }
    .rt{
        flex-basis: 40%;
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
    }
</style>
<hr>


{{-- reust header  --}}

<div class="result-header">
    
<h3>
    NURSERY PUPIL PERFORMANCE REPORT 
</h3>


    <div class="f-row">
        <div class="lf dotted">
            Name of Pupil: 
        </div>
        <div class="rt dotted">Gender: </div>
    </div>

    <div class="f-row">

        <div class="f1 dotted">
            Class: 
        </div>
        <div class="f2 dotted">Age: </div>
        <div class="f3 dotted">Next Term Begins: </div>
        
    </div>
    <div class="f-row">

        <div class="f1 dotted">
            Class Average: 
        </div>
        <div class="f2 dotted">Personal Total: </div>
        <div class="f3 dotted">Personal Average: </div>

    </div>

</div>

<span>Keys to Grades: <i>A – Distinction – 70% & Above, C- Credit – 60% to 69%, P- Pass – 40% to 59%, F – Fail below 40%</i></span>

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
        <div class="legend">
            Key:
            <p>5 - Excellent</p>
            <p>4 - Very Good </p>
            <p>3 - Good</p>
            <p>2 - Fair </p>
            <p>1 - Poor</p>
        </div>
        <div class="rating">
            @include('school.student.result.curricula-type.'.$psycho[0]->grade)
        </div>
    </div>

     <div class="result-footer">
        <div class="b-row">
            <div class="br solid">
               Teacher‘s  Comment: {{$result->class_teacher_comment}}
            </div>
        </div>

        <div class="b-row">
            <div class="bd solid">
                Signature: 
            </div>
            <div class="bc solid">Date: </div>
        </div>

        <div class="b-row">
            <div class="br solid">
               Principal’s  Comment: {{$result->principal_comment}}
            </div>
        </div>

        <div class="b-row">
            <div class="bd solid">
                Signature: 
            </div>
            <div class="bc solid">Date: </div>
        </div>
     </div>

     
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
