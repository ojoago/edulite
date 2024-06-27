@extends('layout.mainlayout')
@section('title','Record Student Extra Curricular activities')
@section('content')
<div class="container-fluid">
    <div class="card">
        
        <div class="card-body">
            <h5 class="card-title m-0 ">
                @if(isset($params))
                {{$params['arm']}} <small>{{$base->psychomotor}}</small> <i class="bi bi-calendar-event-fill"></i> {{activeTermName()}} {{activeSessionName()}}
            
                @endif
                <div class="float-end">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
            <!-- Primary Color Bordered Table -->
            @if(isset($psycho))
            
                <div class="table-responsive">
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
                            <td scope="col"><input type="number" value="{{getPsychoKeyScore(student:$student->pid,param:$params['param'],key:$row->pid)}}" step="0.01" class="form-control form-control-sm studentPsycho" key="{{$row->pid}}" id="{{$student->pid}}{{$row->pid}}" placeholder="max obtainable {{$base->score}}" max_score="{{$base->score}}"> </td>
                            @endforeach
                    </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <td colspan="{{$psycho->count()+2}}"></td>
                    <td colspan="2">
                    </td>
                </tfoot> --}}
            </form>
        </table>
        </div>
        <button type="button" class="btn btn-primary">Confirm</button>
            @else
            <h4>Click On filter to select class</h4>
            @endif
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>

<!-- create psycho Base modal  -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">Create Extra Curricular Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="g-3" action="{{route('load.psychomotor.keys')}}" method="post">
            <div class="modal-body">
                @csrf
           
                <label for="category" class="form-label">Category</label>
                <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                </select>
            
                <label for="class" class="form-label">Class</label> 
                <select type="text" name="class" class="form-control" id="formClassSelect2" required>
                </select>
          
          
                <label for="arm" class="form-label">Class Arm</label>
                <select type="text" name="arm" class="form-control" id="formArmSelect2" required>
                </select>
          
                <label for="arm" class="form-label">Psychomotor Type</label> 
                <div class="input-group">
                    <select type="text" name="psychomotor_pid" class="form-control" id="psychomotorBaseSelect2" required>
                    </select>
                </div>
               
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
    </div>
</div>
</form>
    </div>
</div><!-- End Psychomotro Modal-->


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
            var key = $(this).attr('key'); //CA score
            var max = $(this).attr('max_score'); //CA score
            var spid = $(this).closest('tr').attr('id'); // student pid 
            // alert(spid)
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
                        // alert(data)
                        showTipMessage('Last Score not saved!!!');
                    }
                })
            } else {
                showTipMessage('Maximum Score ' + max);
                $(this).val('');
            }

        });


        multiSelect2('#formCategorySelect2', 'filterModal', 'category', 'Select Category');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formClassSelect2','filterModal', 'class', id, 'Select Class');
            multiSelect2Post('#psychomotorBaseSelect2', 'filterModal','psychomotors', id, 'Select Psychomotor');
        });
        $('#formClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formArmSelect2','filterModal', 'class-teacher-arm', id, 'Select Class Arm');
        });

    });
</script>
@endsection