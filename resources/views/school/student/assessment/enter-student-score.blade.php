@extends('layout.mainlayout')
@section('title','Enter Student Scores')
@section('content')
<style>
    /* p {
        text-align: center;
        color: limegreen;
        font-size: 1.5em;
        font-weight: bold;
        text-shadow: 1px 1px 2px #000;
        margin-bottom: 1em;
    } */
    .studentTotal {
        border: none;
        background-color: transparent;
        color: #000;
        width: 100%;
        padding: 0;
        margin: 0;
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{route('change.arm.subject')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <!-- <label for="arm" class="form-label">Class Arm</label> -->
                        <select type="text" name="arm" class="form-control" id="formArmSelect2">

                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <!-- <label for="subject" class="form-label">Class Subject</label> -->
                        <select type="text" name="subject" class="form-control" id="formArmSubjectSelect2">

                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm" type="submit">Change</button>
                    </div>
                </div>
            </form>
            <!-- Primary Color Bordered Table -->
            <h5 class="card-title">{{$class->arm}} <small>{{$class->subject}} <i class="bi bi-calendar-event-fill"></i> {{termName(session('term'))}} {{sessionName(session('session'))}}</small></h5>
            @if($scoreParams->isNotEmpty())
            @if($data->isNotEmpty())
            <div class="btn-group">
                <a href="{{route('export.student.list')}}"><button class="btn btn-primary btn-sm" type="btn" id="exportStudentList" data-bs-toggle="tooltip" title="Export Student list to excel to enter score offline">export</button></a>
                <button class="btn btn-success btn-sm" type="button" id="importStudentScore" data-bs-toggle="tooltip" title="Import Student Scores">import</button>
            </div>
            <table class="table table-bordered border-primary" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">S/N</th>
                        <th scope="col">
                            Reg-Number
                        </th>
                        <th scope="col">Names</th>
                        @foreach($scoreParams as $row)
                        <th scope="col">{{$row->title}} [{{$row->score}}]</th>
                        @endforeach
                        <th scope="col" width="5%">Total
                            [100]
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <form>
                        @csrf
                        @foreach($data as $student)
                        <tr class="studentId" id="{{$student->pid}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$student->reg_number}}</td>
                            <td> <input type="checkbox" name="{{$student->pid}}" class="examStatus" id="{{$student->pid}}" checked> {{ $student->fullname }}</td>
                            @php $total = 0;@endphp
                            @foreach($scoreParams as $row)
                            <td scope="col">
                                @php
                                $score = getTitleScore($student->pid,$row->assessment_title_pid);
                                $total += $score;
                                @endphp
                                <input type="number" step="0.01" class="form-control form-control-sm studentCaScore score{{$student->pid}}" id="{{$row->assessment_title_pid}}" value="{{$score}}" max_score="{{$row->score}}" placeholder="max obtainable {{--$row->score--}}">
                            </td>
                            @endforeach
                            <td scope="col" id="total{{$student->pid}}">{{$total}}</td>
                        </tr>
                        @endforeach
                </tbody>
                {{-- <tfoot>
                        <td colspan="{{$scoreParams->count()+2}}"></td>
                <td colspan="2">
                </td>
                </tfoot> --}}
                </form>
            </table>
            <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
            @else
            <h3 class="card-title bg-warning text-center">No Student Assign to {{$class->arm}} in {{sessionName(session('session'))}} , Please contact the School Admin...</h3>
            @endif
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
            var max = Number($(this).attr('max_score')); // obtainable score
            if (score < max + 0.00000001) {
                var title = $(this).attr('id'); // title pid
                var spid = $(this).closest('tr').attr('id'); // student pid 
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{route('submit.student.ca')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        score: score,
                        titlePid: title,
                        student_pid: spid,
                        _token: token,
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            let total = 0;
                            $('.score' + spid).each(function() {
                                total += Number($(this).val());
                            });
                            $('#total' + spid).text(total.toFixed(2))
                        } else {
                            alert_toast(data.message, 'error')
                            showTipMessage(data.message)
                        }
                    },
                    error: function(data) {
                        showTipMessage('Last Score not saved!!!');
                    }
                });

            } else {
                if (score > max) {
                    showTipMessage('Obtainable Score is ' + max);
                }
                $(this).val('');
                return false;
            }
        });

        $('#confirmBtn').click(function() {
            alert_toast('Weldone', 'success')
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

        // export student list 
        $('exportStudentList').click(function() {
            $('.overlay').show();
            $ > ajax({
                url: "",
                type: "get",
                cache: false,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data) {

                },
                fail: function(data) {
                    console.log(data);
                    alert_toast('Failed to exported', 'error')
                }
            });
        })
        $('#importStudentScore').click(function() {
            $('#importStudentScoreModal').modal('show');
        });

        // upload score  
        $('#uploadResultBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('import.student.score')}}",
                type: "POST",
                data: new FormData($('#uploadResultForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                beforeSend: function() {
                    $('#uploadResultForm').find('p.text-danger').text('');
                    $('#uploadResultBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#uploadResultBtn').prop('disabled', false);
                    $('.overlay').hide();
                    console.log(data.errors);
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 1) {
                        $.each(data.errors, function(prefix, val) {
                            let error = val + '<br>';
                            $('.errors').append(error);
                        });
                        alert_toast(data.message, 'success');
                        $('#uploadResultForm')[0].reset();
                        $('#importStudentScoreModal').modal('hide');
                        location.reload()
                    } else {
                        $.each(data.errors, function(prefix, val) {
                            let error = val + '<br>';
                            $('.errors').append(error);
                        });
                        alert_toast(data.message, 'warning');
                    }
                },
                error: function(data) {
                    console.log(data);
                    $('#uploadResultBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
    });
</script>

<!-- link students to parent modal  -->
<div class="modal fade" id="importStudentScoreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="uploadResultForm">
                    @csrf
                    <input name="file" type="file">
                    <p class="text-danger file_error errors"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="uploadResultBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection