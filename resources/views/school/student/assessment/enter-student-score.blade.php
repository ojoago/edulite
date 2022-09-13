@extends('layout.mainlayout')
@section('title','Enter Student Scores')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">{{$class->arm}} <small>{{$class->subject}}</small></h5>
                    <p> <i class="bi bi-calendar-event-fill"></i> {{termName(session('term'))}} {{sessionName(session('session'))}}</p>
                </div>
                <div class="col-md-6">
                    <form action="{{route('change.arm.subject')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <!-- <label for="arm" class="form-label">Class Arm</label> -->
                                <select type="text" name="arm" class="form-control" id="formArmSelect2">

                                </select>
                            </div>
                            <div class="col-md-4">
                                <!-- <label for="subject" class="form-label">Class Subject</label> -->
                                <select type="text" name="subject" class="form-control" id="formArmSubjectSelect2">

                                </select>
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-primary btn-sm" type="submit">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Primary Color Bordered Table -->
            @if(!$scoreParams->isEmpty())
            <table class="table table-bordered border-primary" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">
                            <!-- Reg-Number -->
                        </th>
                        <th scope="col">Names</th>
                        @foreach($scoreParams as $row)
                        <th scope="col">{{$row->title}} max-[{{$row->score}}]</th>
                        @endforeach
                        <th scope="col">Total
                            <!--[100]-->
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $student)
                    <tr class="studentId" id="{{$student->pid}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{--$student->reg_number--}}</td>
                        <td> <input type="checkbox" name="{{$student->pid}}" class="examStatus" id="{{$student->pid}}" checked> {{ $student->fullname }}</td>
                        <form>
                            @csrf
                            @foreach($scoreParams as $row)
                            <td scope="col"><input type="number" step="0.01" class="form-control form-control-sm studentCaScore" id="{{$row->assessment_title_pid}}" value="{{getTitleScore($student->pid,$row->assessment_title_pid)}}" placeholder="max obtainable {{--$row->score--}}"> </td>
                            @endforeach
                            <td scope="col"></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <td colspan="{{$scoreParams->count()+2}}"></td>
                    <td colspan="2">
                        <button type="button" class="btn btn-primary">Confirm</button>
                    </td>
                </tfoot>
                </form>
            </table>
            @else
            <h3 class="card-title bg-warning text-center">Score Settings for {{termName(session('term'))}} {{sessionName(session('session'))}} Has not been set, Please contact the School Admin...</h3>
            @endif
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#scoreTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });
        $('.studentCaScore').change(function() {
            var score = $(this).val(); //CA score
            var title = $(this).attr('id'); // title pid
            var spid = $(this).closest('tr').attr('id'); // student pid 
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{route('submit.student.ca')}}",
                type: "POST",
                data: {
                    score: score,
                    titlePid: title,
                    student_pid: spid,
                    _token: token,
                },
                success: function(data) {
                    showTipMessage(data)
                },
                error: function(data) {
                    showTipMessage('Last Score not saved!!!');
                }
            });
        });

        $('.examStatus').click(function() {
            if ($(this).is(':checked')) {
                seated = 1;
            } else {
                seated = 0;
            }

            var spid = $(this).attr('id'); // student pid 
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{route('change.student.ca.student')}}",
                type: "POST",
                data: {
                    seated: seated,
                    student_pid: spid,
                    _token: token,
                },
                success: function(data) {
                    showTipMessage(data)
                },
                error: function(data) {
                    showTipMessage('Last Score not saved!!!');
                }
            });
        });

        var arm = "{{session('arm')}}";
        if (arm != null) {
            getArmSubject(arm)
        }
        var class_pid = "{{session('class')}}";
        if (class_pid != null) {
            getClassArms(class_pid)
        }
        // $('#formClassSelect2').on('change', function(e) {
        //     var id = $(this).val();
        //     FormMultiSelect2Post('#formArmSelect2', 'class-arm', id, 'Select Class Arm');
        // });
        // $('#formArmSelect2').on('change', function(e) {
        //     var id = $(this).val();
        //     FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        // });
        $('#formArmSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        });

        function getClassArms(id) {
            FormMultiSelect2Post('#formArmSelect2', 'class-arm', id, 'Select Class Arm');
        }

        function getArmSubject(id) {
            FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        }
    });
</script>
@endsection