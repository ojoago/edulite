@extends('layout.mainlayout')
@section('title','Promote Student')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
             <h5 class="card-title">
                @if(isset($className))
                    Promote Student, Class: {{$className}} <i class="bi bi-calendar-event-fill"> </i> {{activeSessionName() }} {{activeTermName()}}
                @endif
                <div class="float-end">
                
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
            @if (isset($students))
                <table class="table table-bordered border-primary cardTable" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Next Class</th>
                        <th scope="col">Class Arm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $row)
                    <tr class="studentId" id="">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->reg_number}}</td>
                        <td>{{ $row->fullname }}</td>
                        <form method="post" action="{{route('migrate.student')}}">
                            @csrf
                            <td scope="col">
                                <select name="" id="" class="form-control form-control-sm" required>
                                    <option disabled selected>Select Next Class</option>
                                    @foreach($nextClass as $cls)
                                    <option value="{{$cls->pid}}" @php echo $cls->class_number==$currentClassNumber+1 ? 'selected':'' @endphp >{{$cls->class}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="pid[]" value="{{$row->pid}}">
                            </td>
                            <td scope="col">
                                <select name="next_class[]" id="" class="form-control form-control-sm" required>
                                    <option disabled selected>Select Class Arm</option>
                                    @foreach($nextArm as $arm)
                                    <option value="{{$arm->pid}}" <?php if ($arm->arm_number == $armNumber) {
                                                                        echo 'selected';
                                                                    } ?>>{{$arm->arm}}</option>
                                    @endforeach
                                </select>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="3">
                        </td>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
                        </td>
                    </tr>
                </tbody>
                </form>
            </table>
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
                 <p class="text-center small">Promote Student To next class</p>
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
        });
        $('#assessmentClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#assessmentArmSelect2','filterModal', 'class-teacher-arm', id, 'Select Class Arm');
        });
       

    });
</script>
@endsection