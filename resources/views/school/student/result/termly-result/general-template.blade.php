<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>EDL - {{$std->fullname}} Report Card</title>
    <meta content="description" name="Upgrade your school with edulite suite, 
                                    and ease the stress of school manual process at less cost.
                                     get accurate and accessible information about students, staff remotely.
                                      Allow guardian/parent keep track of their childrens performance easily 
                                      and at you their own time and convenience. EduLite manage school process 
                                      such as report card, performance charts, attendance, student promotion, 
                                      automated principal comment, hostel/portals, student pick up rider, 
                                      event notification such as holidays, notify parent student exam timetable">
    <meta content="keywords" name="education, edulite, education suite, educate, education is light, secondary school, school, primary school, nursery school">
    <meta content="author" name="edulite">

    <!-- Favicons -->
    <link href="{{asset('files/edulite/edulite drk bg.png')}}" rel="icon">
    <link href="{{asset('files/edulite/edulite drk bg.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('themes/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{asset('themes/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/css/custom/style.css')}}" rel="stylesheet">

    <style>
        body {
            margin: 20px 160px;
        }

        .flex-container,
        .flex-row {
            display: flex;
            justify-content: space-between;
            /* flex-wrap: wrap; */
            align-items: flex-start;
        }

        .text-content {
            flex-basis: 60%;
            text-align: center;
        }

        .text-content>.h4,
        .text-content>.h3 {
            margin-bottom: 1px;
        }

        .text-content>p {
            margin: 1px;
            font-size: small;
        }

        .logo-image {
            width: 100px !important;
            border-radius: 15px;
        }

        .logo-image>img {
            width: 100%;
        }

        .flex-row {
            /* height: 200px; */
            justify-content: space-between;
        }

        .personal-detail,
        .flex-col {
            flex-basis: 40%;
            margin: 3px;
            /* justify-content: space-between; */
        }

        .student-img {
            flex-basis: 15%;
            border-radius: 5px;
            align-items: center;
            justify-content: center;
            border: 1px solid #000;
            max-height: 200px;
        }

        .student-img>img {
            width: 100%;
            height: 100%;
        }

        .signature-base {
            width: 60px !important;
            align-items: center;
            justify-content: center;
        }

        .signature-base>img {
            width: 100%;
        }


        table {
            /* background: #fff; */
            /* box-shadow: 0 0 0 10px #fff; */

            /* width: calc(100% - 20px); */
            border-spacing: 5px;
        }

        tr>th,
        tr>td {
            padding: 5px !important;
        }

        .flat-row {
            padding: 3px !important;
            width: auto !important;
            /* padding-right: 0 !important; */
        }

        .rotate-up {
            vertical-align: bottom;
            text-align: center;
            /* font-weight: normal; */
        }

        .rotate-up {
            -ms-writing-mode: tb-rl;
            -webkit-writing-mode: vertical-rl;
            writing-mode: vertical-rl;
            /* translate(25px, 51px) // 45 is really 360-45 */
            /* rotate(315deg); */
            /* transform: rotate(315deg) translate(25px, 51px); */
            white-space: nowrap;
            /* overflow: hidden; */
            /* width: 25px; */
            transform: rotate(180deg);
            /* height: 150px; */
            width: 30px;
            /* transform-origin: left bottom; */
            /* box-sizing: border-box; */
        }

        @media screen and (max-width:560px) {
            .student-img {
                border: none !important;
                display: none !important;
            }

            .flex-container {
                flex-direction: column !important;
            }

            .examTable {
                width: 100% !important;
            }

            body {
                margin: 1px;
            }
        }

        @media print {

            .header,
            #header,
            button {
                display: none !important;
            }

            body{
                margin: 50px 30px;
            }

            .rotate-up {
                vertical-align: bottom !important;
                height: 120px;
                text-align: center !important;
            }

            .rotate-up {
                -ms-writing-mode: tb-rl !important;
                -webkit-writing-mode: vertical-rl !important;
                writing-mode: vertical-rl !important;
                white-space: nowrap !important;
                transform: rotate(90deg) !important;
                width: 30px !important;
                transform: translate(45px, -20px)
            }

            .student-img {
                border: none;
            }

            #column_Chart {
                width: auto;
            }
        }
    </style>

</head>

<body>
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
@php
        $settings = null;
        
        if($result_config){
            $settings = json_decode($result_config->settings) ;
        }
    @endphp
    <div class="container-fluid">
        <div id="document">
            @include('school.student.result.headers.top')
        <hr>
        <div class="flex-row">
            <div class="personal-detail">
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td colspan="2" class="text-center" style="padding: 20px!important;">
                            {{@$std->fullname}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center text-uppercase" style="padding: 10px!important;">
                            personal Data
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Gender
                        </td>
                        <td>
                            {{matchGender($std->gender)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Admin No.
                        </td>
                        <td>
                            {{$std->reg_number}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            D.O.B
                        </td>
                        <td>
                            {{$std->dob}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            AGE
                        </td>
                        <td>
                            {{dateToAge($std->dob)}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="flex-col">
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td colspan="2" align="center">
                            Class Data
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Class
                        </td>
                        <td>
                            {{$result->arm}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Term
                        </td>
                        <td>
                            {{$result->term}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Session
                        </td>
                        <td>
                            {{$result->session}}
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td colspan="2" align="center">
                            Class Attendance
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            Number of Times Open
                        </td>
                        <td>
                            {{date_diff_weekdays(@$result->begin,@$result->end)}}
                        </td>
                    </tr>
                    <tr>
                        @if(@$result->present>0 || @$result->absent>0)
                        <td>
                            Present: {{@$result->present}}
                        </td>
                        <td>
                            Absent: {{@$result->absent}}
                        </td>
                        @else
                        <td colspan="2" align="center">
                            No Attendance Record
                        </td>

                        @endif
                    </tr>

                </table>
            </div>
            <div class="img img-responsive student-img">
                @php $imgUrl = $std->passport ? asset("/files/images/".$std->passport) :'' @endphp
                <img src="{{$imgUrl}}" alt="" class="img img-responsive" id="student-img">
            </div>
        </div>
        <div class="table table-responsive">
            <div class="flex-container">
                <table class="table table-hover table-striped table-bordered examTable" cellpadding="pixels">
                    <thead>
                        <tr>
                            <th colspan="2"></th>

                            @foreach($scoreSettings as $row)
                            <th class="rotate-up">{{$row->title}}</th>
                            @endforeach
                            <th class="rotate-up" style="{{$rotate_up}}">TOTAL</th>
                            <th class="rotate-up" style="{{$rotate_up}}">CLASS MIN</th>
                            <th class="rotate-up" style="{{$rotate_up}}">CLASS AVG</th>
                            <th class="rotate-up" style="{{$rotate_up}}">CLASS MAX</th>
                            <th class="rotate-up" style="{{$rotate_up}}">GRADE</th>
                            <th class="rotate-up" style="{{$rotate_up}}">SUBJECT POSITION</th>
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
                            <td>{{rtnGrade($row->total,$grades)['grade']}}</td>
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
                <div class="flex-col">
                    <div class="card-header bg-transparent text-center text-dark">Grade</div>
                    <table class="table table-hover table-striped table-bordered w-30">
                        <thead>
                            <tr>
                                <!-- <th>S/N</th> -->
                                <th>Grade</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $row)
                            <tr>
                                <td>{{$row->grade}}</td>
                                <td>{{$row->title}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>ND</td>
                                <td>Not Defined</td>
                            </tr>
                        </tbody>

                    </table>
                    
                    @foreach($psycho as $row)
                        @if($row->baseKey->isNotEmpty())
                            <div class="card-header text-center bg-transparent text-dark"><small>{{$row->psychomotor}}</small></div>
                            <table class="table table-hover table-striped table-bordered w-30">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($row->baseKey as $rw)
                                    <tr>
                                        <td> {{$rw->title}} </td>
                                        <td>{{getPsychoKeyScore(student:$result->student_pid,param:$param,key:$rw->pid)}} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
        <div class="flex-row">
            <div class="section">
                <div class="card-header">Principal/Head Teacher</div>
                Name: {{$result->principal_name}}<br>
                Comment: {{$result->principal_comment}}<br>
                <div class="signature-base">
                    @php $imgUrl = @$result->signature ? asset("/files/images/". @$result->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            <div class="section">
                <div class="card-header">Class/Form Teacher</div>
                Name: {{$result->teacher_name}}<br>
                Comment: {{$result->class_teacher_comment}}<br>
                <div class="signature-base">
                    @php $imgUrl = @$result->signature ? asset("/files/images/".@$result->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            @if(@$result->type==2)
            <div class="section">
                <div class="card-header">Class/Form Teacher</div>
                Name: {{$result->teacher}}<br>
                Comment: {{$result->portal_comment}}<br>
                <div class="signature-base">
                    @php $imgUrl = @$result->signature ? asset("/files/images/".@$result->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>

            </div>
            @endif
        </div>
        <div class="col-md-12">
            <div id="column_Chart" class="chartZoomable" style="width:98%;height:auto;"></div>
        </div>
        </div>
       <a href="{{route('student.report.card.pdf',['param'=>$param , 'pid' => $std->pid])}}"> <button class="btn btn-primary m-2">Print</button> </a>


    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
            var chart = new google.visualization.ColumnChart(document.getElementById("column_Chart"));
            chart.draw(view, options);
        }
    </script>
     <script src="{{asset('js/jquery.3.7.0.min.js')}}"></script>