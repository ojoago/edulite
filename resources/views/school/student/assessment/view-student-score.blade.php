@extends('layout.mainlayout')
@section('title','Enter Student Scores')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{--$class->arm--}} <small>{{$class->subject}}</small></h5>
            <p> <i class="bi bi-calendar-event-fill"></i> {{--sessionName(session('session'))--}} {{termName(session('term'))}}</p>
            <!-- Primary Color Bordered Table -->
            <table class="table table-bordered border-primary" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">
                            <!-- Reg-Number -->
                        </th>
                        <th scope="col">Names</th>
                        @foreach($scoreParams as $row)
                        <th scope="col">{{$row->title}} <small>/[{{$row->score}}]</small></th>
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
                            <td scope="col">{{getTitleScore($student->pid,$row->assessment_title_pid)}}</td>
                            @endforeach
                            <td scope="col"></td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <td colspan="{{$scoreParams->count()+2}}"></td>
                    <td colspan="2">
                        <button type="button" class="btn btn-primary">Confirm</button>
                    </td>
                </tbody>
                </form>
            </table>
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

    });
</script>
@endsection