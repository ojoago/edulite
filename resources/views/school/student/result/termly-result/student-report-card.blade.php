@extends('layout.mainlayout')
@section('title',$std->fullname.' Report card')
@section('content')
<style>
    .flex-container,
    .flex-row {
        display: flex;
        justify-content: space-between;
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
    }

    .student-img>img {
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

    @media print {

        .header,
        #header,
        button {
            display: none;
        }

        .rotate-up {
            vertical-align: bottom !important;
            text-align: center;
        }

        .rotate-up {
            -ms-writing-mode: tb-rl !important;
            -webkit-writing-mode: vertical-rl !important;
            writing-mode: vertical-rl !important;
            white-space: nowrap !important;
            transform: rotate(180deg) !important;
            width: 30px;
        }

        .student-img{
            border: none;
        }
    }
</style>
<div class="container-fluid">
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
                        Addmin No.
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
                        {{$results->arm}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Term
                    </td>
                    <td>
                        {{$results->term}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Session
                    </td>
                    <td>
                        {{$results->session}}
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
                        Number of times open
                    </td>
                    <td>
                        {{date_diff_weekdays($results->begin,$results->end)}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Present: {{$results->present}}
                    </td>
                    <td>
                        Absent: {{$results->absent}}
                    </td>

                </tr>

            </table>
        </div>
        <div class="img img-responsive student-img">
            @php $imgUrl = $std->passport ? asset("/files/images/".$std->passport) :'' @endphp
            <img src="{{$imgUrl}}" alt="" class="img img-responsive">
        </div>
    </div>
    <div class="table table-responsive">
        <div class="flex-container">
            <table class="table table-hover table-striped table-bordered" cellpadding="pixels">
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
                        <td>{{'tempnam'}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>

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
                            <td>NA</td>
                            <td>Not Defined</td>
                        </tr>
                    </tbody>

                </table>
                @foreach($psycho as $row)
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
                            <td>{{getPsychoKeyScore(student:$results->student_pid,param:$param,key:$rw->pid)}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endforeach
            </div>
        </div>

        <div class="flex-row">
            <div class="section">
                <div class="card-header">Principal/Head Teacher</div>
                Name: {{$results->teacher}}<br>
                Comment: {{$results->principal_comment}}<br>
                @php $imgUrl = $std->passport ? asset("/files/images/".$results->signature) :'' @endphp
                <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
            </div>
            <div class="section">
                <div class="card-header">Class/Form Teacher</div>
                Name: {{$results->teacher}}<br>
                Comment: {{$results->class_teacher_comment}}<br>
                @php $imgUrl = $std->passport ? asset("/files/images/".$results->signature) :'' @endphp
                <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
            </div>
            @if($results->type==2)
            <div class="section">
                <div class="card-header">Class/Form Teacher</div>
                Name: {{$results->teacher}}<br>
                Comment: {{$results->portal_comment}}<br>
                @php $imgUrl = $std->passport ? asset("/files/images/".$results->signature) :'' @endphp
                <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
            </div>
            @endif
        </div>
        <div class="col-md-12">
            <div id="column_Chart" class="chartZoomable" style="width:90%;height:auto;"></div>
        </div>
        <button class="btn btn-success btn-sm"> <i class="bi bi-printer"></i> </button>
    </div>
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
            title: "Student Score Against total,MIN, MAX & AVG",
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
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

@endsection