@extends('layout.mainlayout')
@section('title','Record Student domainmotor')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">{{$params['arm']}}</h5>
                    <p> <i class="bi bi-calendar-event-fill"></i> {{termName($params['term'])}} {{sessionName($params['session'])}}</p>
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
            <table class="table table-bordered border-primary" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">
                            Reg-Number
                        </th>
                        <th scope="col">Names</th>
                        @foreach($domain as $row)
                        <th scope="col">{{$row->title}} max-[{{$row->max_score}}]</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $student)
                    <tr class="studentId" id="{{$student->pid}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$student->reg_number}}</td>
                        <td> {{ $student->fullname }}</td>
                        <form>
                            @csrf
                            @foreach($domain as $row)
                            <td scope="col"><input type="number" value="{{getDomainKeyScore(student:$student->pid,param:$params['param'],key:$row->pid)}}" step="0.01" class="form-control form-control-sm studentdomain" id="{{$row->pid}}" placeholder="max obtainable {{$row->max_score}}"> </td>
                            @endforeach
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <td colspan="{{$domain->count()+2}}"></td>
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
        $('.studentdomain').change(function() {
            var score = $(this).val(); //CA score
            var key = $(this).attr('id'); //CA score
            var spid = $(this).closest('tr').attr('id'); // student pid 
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{route('record.affective.score')}}",
                type: "POST",
                data: {
                    score: score,
                    student_pid: spid,
                    _token: token,
                    param: "{{$params['param']}}",
                    key_pid: key,
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