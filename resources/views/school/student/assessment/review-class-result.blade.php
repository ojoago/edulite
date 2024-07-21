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
            <h5 class="card-title">
                @if(isset($class))
                    {{$class->arm}} <small>{{$class->subject}} <i class="bi bi-calendar-event-fill"></i> {{$class->term}} {{$class->session}}</small>
                   Status: {{$class->status == 1 ? 'Published' : 'Not Published' }}
                @endif
                <div class="float-end">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-target="#filterModal" data-bs-toggle="modal" >Filter</button>
                </div>
            </h5>
            
            <!-- Primary Color Bordered Table -->
            @if(isset($subjects))
               
                    <table class="table table-bordered border-primary  cardTable" id="scoreTable">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">S/N</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Status</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($subjects as $subject)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$subject->subject_name}}</td>
                                    {{-- <td>{{$subject->status}}</td> --}}
                                    <td>{{$subject->status == 1 ? 'Published' : 'Not Published' }}</td>
                                    <td>{{$subject->subject_teacher_name}}</td>
                                    <td> <a href="{{route('review.subject.result' , ['param' => $subject->pid] )}}" target="_blank" rel="noopener noreferrer" > <button class="btn btn-sm btn-primary">Review</button>  </a> </td>
                                </tr>
                                @endforeach
                        </tbody>
                       
                    </table>
                    @if($class->status)
                        <button type="button" class="btn btn-success" id="publishResult" param = "{{$class->pid}}">Publish Subject</button>
                    @endif 
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
                <h5 class="modal-title h6">Review Class Result</h5>
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



        $('#scoreTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });
        
     
         $('#publishResult').click(function() {
            let param = $(this).attr('param')
             $.ajax({
                url: "{{route('lock.class.result')}}",
                type: "POST",
                data: {
                    param: param,
                    _token: "{{csrf_token()}}",
                },
                success: function(data) {
                    if(data.status == 1){
                        alert_toast(data.message, 'success')
                    }else{
                        alert_toast(data.message, 'error')
                    }
                },
                error: function(data) {
                    alert_toast('Weldone', 'error')
                }
            });
        });

        
    });
</script>
@endsection