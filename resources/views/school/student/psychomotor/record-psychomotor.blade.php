@extends('layout.mainlayout')
@section('title','Record Student Extra Curricular activities')
@section('content')
<div class="container-fluid">
    <div class="card">
        <form class="row g-3" action="{{route('load.psychomotor.keys')}}" method="post">
            @csrf
            <div class="col-md-3">
                <!-- <label for="category" class="form-label">Category</label> -->
                <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                </select>
            </div>

            <div class="col-md-3">
                <!-- <label for="class" class="form-label">Class</label> -->
                <select type="text" name="class" class="form-control" id="formClassSelect2">
                </select>
            </div>

            <div class="col-md-3">
                <!-- <label for="arm" class="form-label">Class Arm</label> -->
                <select type="text" name="arm" class="form-control" id="formArmSelect2">
                </select>
            </div>
            <div class="col-md-3">
                <!-- <label for="arm" class="form-label">Psychomotor Type</label> -->
                <div class="input-group">
                    <select type="text" name="psychomotor_pid" class="form-control" id="psychomotorBaseSelect2">
                    </select>
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Go</button>
            </div>
            <!-- <div class="col-md-1">
                </div> -->
        </form>
        <div class="card-body">
            @if(isset($params))
            <h5 class="card-title m-0 ">{{$params['arm']}} <small>{{$base->psychomotor}}</small> <i class="bi bi-calendar-event-fill"></i> {{activeTermName()}} {{activeSessionName()}}</h5>
            @endif

            <!-- Primary Color Bordered Table -->
            @if(isset($psycho))
            <table class="table table-bordered border-primary cardTable" id="scoreTable">
                <thead>
                    <tr>
                        <th width="5%">S/N</th>
                        <th scope="col">
                            Reg-Number
                        </th>
                        <th scope="col">Names</th>
                        @foreach($psycho as $row)
                        <th scope="col">{{$row->title}} max-[{{$base->score}}]</th>
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
                            @foreach($psycho as $row)
                            <td scope="col"><input type="number" value="{{getPsychoKeyScore(student:$student->pid,param:$params['param'],key:$row->pid)}}" step="0.01" class="form-control form-control-sm studentPsycho" id="{{$row->pid}}" placeholder="max obtainable {{$base->score}}" max_score="{{$base->score}}"> </td>
                            @endforeach
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <td colspan="{{$psycho->count()+2}}"></td>
                    <td colspan="2">
                        <button type="button" class="btn btn-primary">Confirm</button>
                    </td>
                </tbody>
                </form>
            </table>
            @else
            Assessment key not Defined
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
        $('.studentPsycho').change(function() {
            var score = $(this).val(); //CA score
            var key = $(this).attr('id'); //CA score
            var max = $(this).attr('max_score'); //CA score
            var spid = $(this).closest('tr').attr('id'); // student pid 
            var token = $("input[name='_token']").val();
            if (max >= score) {
                $.ajax({
                    url: "{{route('record.psycomotor.score')}}",
                    type: "POST",
                    data: {
                        score: score,
                        student_pid: spid,
                        _token: token,
                        param: "{{@$params['param']}}",
                        key_pid: key,
                    },
                    success: function(data) {
                        // showTipMessage(data)
                    },
                    error: function(data) {
                        showTipMessage('Last Score not saved!!!');
                    }
                });
            } else {
                showTipMessage('Maximum Score ' + max);
                $(this).val('');
            }

        });


        FormMultiSelect2('#formCategorySelect2', 'category', 'Select Category');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formClassSelect2', 'class', id, 'Select Class');
            FormMultiSelect2Post('#psychomotorBaseSelect2', 'psychomotors', id, 'Select Psychomotor');
        });
        $('#formClassSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formArmSelect2', 'class-teacher-arm', id, 'Select Class Arm');
        });
        // $('#formArmSelect2').on('change', function(e) {
        //     var id = $(this).val();
        //     FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        // });

        // function getClassArms(id) {
        //     FormMultiSelect2Post('#formArmSelect2', 'class-teacher-arm', id, 'Select Class Arm');
        // }

    });
</script>
@endsection