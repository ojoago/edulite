@extends('layout.mainlayout')
@section('title',$std->fullname.' Report card')
@section('content')
<style>
    .flex-container,
    .flex-row {
        display: flex;
        justify-content: space-between;
    }


    .flex-row {
        /* height: 200px; */
        justify-content: space-between;
    }

    .personal-detail,
    .flex-col {
        flex-basis: 40%;
        margin: 3px;
        ;
    }

    .student-img {
        flex-basis: 15%;
        border-radius: 5px;
        align-items: center;
        justify-content: center;
        border: 1px solid #000;
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

    .flat-row{
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
        /* transform: rotate(90deg); */
        /* height: 150px; */
        width: 30px;
        /* transform-origin: left bottom; */
        /* box-sizing: border-box; */
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

                    </td>
                </tr>
                <tr>
                    <td>
                        AGE
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
        </div>

        <div class="flex-col">
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <td colspan="2">
                        Class Data
                    </td>
                </tr>
                <tr>
                    <td>
                        Class
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        Term
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        Session
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <td colspan="2">
                        Class @ndnc
                    </td>
                </tr>
                <tr>
                    <td>
                        Number of times open
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        present
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        Absent
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
        </div>
        <div class="img img-responsive student-img">
            <img src="{{asset('themes/img/apple-touch-icon.png')}}" alt="">
        </div>
    </div>

    <div class="table table-responsive">
        <div class="flex-container">
            <table class="table table-hover table-striped table-bordered" cellpadding="pixels">
                <thead>
                    <tr>
                        <th width="5%">S/N</th>
                        <th class="flat-row p-2">SUBJECTS</th>
                        @foreach($scoreSettings as $row)
                        <th class="rotate-up">{{$row->title}}</th>
                        @endforeach
                        <th class="rotate-up">TOTAL</th>
                        <th class="rotate-up">CLASS MIN</th>
                        <th class="rotate-up">CLASS AVG</th>
                        <th class="rotate-up">CLASS MAX</th>
                        <th class="rotate-up">GRADE</th>
                        <th class="rotate-up">SUBJECT POSITION</th>
                        <th class="flat-row">TEACHER</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td>{{''}}</td>
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
                <table class="table table-hover table-striped table-bordered w-30">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Grade</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        </tr>
                    </tbody>

                </table>
                <table class="table table-hover table-striped table-bordered w-30">
                    <thead>
                        <tr>
                            <th>title</th>
                            <th>score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($psycho as $row)
                        <tr>
                            <td> CHEMISTRY CHEMISTRY CHEMISTRY{{$row->title}}</td>
                            <td>{{$row->score}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <table class="table table-hover table-striped table-bordered w-30">
                    <thead>
                        <tr>
                            <th>title</th>
                            <th>Score</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($domains as $row)
                        <tr>
                            <td> CHEMISTRY CHEMISTRY CHEMISTRY{{$row->title}}</td>
                            <td>{{$row->score}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
        <table>

        </table>

    </div>
</div>


<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {

    });
</script>
@endsection