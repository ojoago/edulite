@extends('layout.mainlayout')
@section('title','View Student Extra Curricular')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
             <h5 class="card-title">
                @if(isset($arm))
                    {{$arm}}, <small class="small">{{$title}} <i class="bi bi-calendar-event-fill"></i> {{activeTermName()}} {{activeSessionName()}}</small>
                @endif
                <div class="float-end">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
          
            <!-- Primary Color Bordered Table -->
            @if(isset($data))
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
                                @csrf
                                @foreach($psycho as $row)
                                <td scope="col">{{getPsychoKeyScore(student : $student->pid , param : $param , key : $row->pid)}} </td>
                                @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
               </div>
            @else 
                <h3 class="card-title text-center">Click On filter to select class </h3>
            @endif 
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>

<!-- filter subject form modal  -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title h6">Create Extra Curricular Name</h5> --}}
                 <p class="text-center small">load Student Extra Curricular <span class="text-danger"> {{activeTermName()}} {{activeSessionName()}}</span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body">
                @csrf
                <label for="category" class="form-label">Category</label>
                <select type="text" name="category" class="form-control" id="assessmentCategorySelect2" required>
                </select>
            
                <label for="class" class="form-label">Class</label> 
                <select type="text" name="class" class="form-control" id="assessmentClassSelect2" required>
                </select>
          
                <label for="arm" class="form-label">Class Arm</label>
                <select type="text" name="arm" class="form-control" id="assessmentArmSelect2" required>
                </select>
          
                <div class="col-12">
                    <label for="subject" class="form-label">Extra Curricular Type</label>
                    <select type="text" name="psychomotor_pid" class="form-control" id="psychomotorBaseSelect2">
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
</div><!-- filter form-->


<script>
    $(document).ready(function() {


        multiSelect2('#assessmentCategorySelect2', 'filterModal', 'category', 'Select Category');
        $('#assessmentCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentClassSelect2','filterModal', 'class', id, 'Select Class');
            multiSelect2Post('#psychomotorBaseSelect2', 'filterModal','psychomotors', id, 'Select Psychomotor');
        });
        $('#assessmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentArmSelect2','filterModal', 'class-teacher-arm', id, 'Select Class Arm');
        });
       

        $('#scoreTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });
       
    });
</script>
@endsection