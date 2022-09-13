@extends('layout.mainlayout')
@section('title','Enter Student Scores')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">{{$session['class']}} <i class="bi bi-calendar-event-fill"></i> {{$session['session']}} <small>Cumulative Result</small></h5>
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
                        <th width="5%">S/N</th>
                        <th width="10%">Position</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th width="5%">Terms</th>
                        <th scope="col">Total</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $row)
                    <tr class="studentId">
                        <td>{{$loop->iteration}}</td>
                        <td>{{ordinalFormat($row->position)}}</td>
                        <td> <a href="{{ route('student.cumulative.result',['param'=>$row->session_pid,'std'=>$row->student_pid])}}" target="_blank" rel="noopener noreferrer">{{$row->reg_number}}</a></td>
                        <td>{{$row->fullname}}</td>
                        <td>{{$row->terms}}</td>
                        <td>{{number_format($row->total,1)}}</td>
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