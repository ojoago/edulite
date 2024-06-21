@extends('layout.mainlayout')
@section('title','Principal Comments')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
                    <h5 class="card-title">Comment {{$class}} <small>Result</small></h5>
                    <p> <i class="bi bi-calendar-event-fill"></i> {{termName(session('term'))}} {{sessionName(session('session'))}}</p>
                
            <!-- Primary Color Bordered Table -->
            <table class="table table-bordered border-primary cardTable" id="resultTable">
                <thead>
                    
                    @if ($subjects)
                        <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Position</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Subjects</th>
                        <th scope="col">Total</th>
                        <th scope="col">Average</th>
                        <th scope="col">Principal's Comment</th>
                        @if(getSchoolType()!=1)
                        <th scope="col">Portal's Comment</th>
                        @endif
                    </tr>
                    @else
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Principal's Comment</th>
                        @if(getSchoolType()!=1)
                        <th scope="col">Portal's Comment</th>
                        @endif
                    </tr>
                    @endif
                </thead>
                <tbody>
                    @foreach($data as $row)
                        @if ($subjects)
                            <tr class="studentId">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ordinalFormat($row->position)}}</td>
                                    <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                                    <td>{{$row->fullname}}</td>
                                    <td>{{$row->count}}</td>
                                    <td>{{number_format($row->total,1)}}</td>
                                    <td>{{number_format($row->average,1)}}</td>
                                    <td><textarea type="text" param="{{$row->class_param_pid}}" std="{{$row->student_pid}}" class="form-control form-control-sm comment" placeholder="Principal Comment">{{$row->principal_comment}}</textarea> </td>
                                    @if(getSchoolType()!=1)
                                    <td>{{$row->portal_comment}}</td>
                                    @endif
                            </tr>
                        @else
                            <tr>
                                <td>{{$loop->iteration}}</td>
                        <td> <a href="{{ route('student.report.card',['param'=>$row->class_param_pid,'pid'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                        <td>{{$row->fullname}}</td>
                        <td><textarea type="text" param="{{$row->class_param_pid}}" std="{{$row->student_pid}}" class="form-control form-control-sm comment" placeholder="Principal Comment">{{$row->principal_comment}}</textarea> </td>
                            @if(getSchoolType()!=1)
                                <td>{{$row->portal_comment}}</td>
                            @endif
                            </tr>
                        @endif
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
                url: "{{route('comment.principal.student.termly.result')}}",
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