@extends('layout.mainlayout')
@section('title',"Portals' Comment")
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Comment {{$class}} <small>Result</small></h5>
                    <p> <i class="bi bi-calendar-event-fill"></i> {{--termName(session('term'))}} {{sessionName(session('session'))--}}</p>
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
            <table class="table table-bordered border-primary" id="resultTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Position</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Subjects</th>
                        <th scope="col">Total</th>
                        <th scope="col">Average</th>
                        @if(getSchoolType()!=1)
                        <th scope="col">Portal's Comment</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr class="studentId">
                        <td>{{$loop->iteration}}</td>
                        <td>{{ordinalFormat($row->position)}}</td>
                        <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                        <td>{{$row->fullname}}</td>
                        <td>{{$row->count}}</td>
                        <td>{{number_format($row->total,1)}}</td>
                        <td>{{number_format($row->average,1)}}</td>
                        @if(getSchoolType()!=1)
                        <td><textarea type="text" param="{{$row->class_param_pid}}" std="{{$row->student_pid}}" class="form-control form-control-sm comment" placeholder="Portals' Comment">{{$row->portal_comment}}</textarea> </td>
                        @endif
                    </tr>
                    @endforeach
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
        $('#resultTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });
        $('.comment').change(function() {
            var comment = $(this).val();
            let param = $(this).attr('param');
            let std = $(this).attr('std');
            let token = "{{csrf_token()}}";
            $.ajax({
                url: "{{route('comment.portals.student.termly.result')}}",
                type: "post",
                data: {
                    comment: comment,
                    std: std,
                    param: param,
                    _token: token
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
        // })

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