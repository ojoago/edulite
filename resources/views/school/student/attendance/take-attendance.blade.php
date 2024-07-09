@extends('layout.mainlayout')
@section('title','Take Student Attendance')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="card-title">{{--$class--}} <small>Attendance</small> <i class="bi bi-calendar-event-fill"></i> <span class="text-danger"> {{activeTermName()}} {{activeSessionName()}}</span></h5>
                    <p> </p>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm" data-bs-target="#changeClassModal" data-bs-toggle="modal">Filter Class</button>
                </div>
            </div>
            <!-- Primary Color Bordered Table -->
            @if(isset($data))
            {{-- <div class="row"> --}}
                {{-- <div class="col-md-9"> --}}
                    <form id="studentAttendanceForm">
                        @csrf
                        <table class="table table-bordered border-primary cardTable" id="resultTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th scope="col">Reg-Number</th>
                                    <th scope="col">Names</th>
                                    <th width="5%"> Present<input type="radio" name="checkAll" class="checkAll" id="allPresent"> </th>
                                    <th width="5%">Absent <input type="radio" name="checkAll" class="checkAll" id="allAbsent"> </th>
                                    <th width="5%"> Excused<input type="radio" name="checkAll" class="checkAll" id="allExcused"> </th>
                                    <th >Comments </th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$row->reg_number}}</td>
                                    <td>{{$row->fullname}}</td>
                                    <input type="hidden" name="student[]" value="{{$row->pid}}">
                                    <td> <input type="radio" class="allPresent" value="1" name="check[{{$row->pid}}]"></td>
                                    <td> <input type="radio" class="allAbsent" value="0" name="check[{{$row->pid}}]"></td>
                                    <td> <input type="radio" class="allExcused" value="2" name="check[{{$row->pid}}]"></td>
                                    <td> <input type="text" class="form-control form-control-sm" placeholder="comment" name="comment[{{$row->pid}}]"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                {{-- </div> --}}
                {{-- <div class="col-md-3 pt-4">
                    <label for="">Note</label> --}}

                    {{-- <textarea type="text" name="note" placeholder="attendance note" class="form-control form-control-sm" id="attnote"></textarea> --}}
                    <label>Date</label>
                    <input type="hidden" name="arm" value="{{$arm}}" required>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" name="date" class="form-control form-control-sm" id="attdate" required>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-2" type="button" id="studentAttendanceBtn">Submit</button>
                {{-- </div> --}}
                </form>
            {{-- </div> --}}
            @else
            <h5 class="card-title">Click on Filter Button Above to take Attendance</h5>

            @endif
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>

<!-- subject modal  -->
<div class="modal fade" id="changeClassModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" >
                    @csrf
                   <div class="row">
                        <div class="col-md-12">
                                <label for="category" class="form-label">Category</label>

                            <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                            </select>
                        </div>
                        <div class="col-md-12">
                                <label for="category" class="form-label">Class </label>

                            <select type="text" name="class" class="form-control form-control-sm" id="formClassSelect2">
                            </select>
                        </div>
                        <div class="col-md-12">
                                <label for="category" class="form-label">Class Arm</label>

                            <select type="text" name="arm" class="form-control" id="formArmSelect2">
                            </select>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#resultTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            "searchable": false,
        });

        // toggle checkbox 
        $('.checkAll').click(function(event) {
            let id = $(this).attr('id');
            if (this.checked) {
                // Iterate each checkbox
                $('.'+id).each(function() {
                    this.checked = true;
                });
            } else {
                $('.'+id).each(function() {
                    this.checked = false;
                });
            }
        });

        // submitFormAjax('studentAttendanceForm', 'studentAttendanceBtn', "{{route('submit.student.attendance')}}");

        $('#studentAttendanceBtn').click(async function() {
            let s = await submitFormAjax('studentAttendanceForm', 'studentAttendanceBtn', "{{route('submit.student.attendance')}}");
            // if (s.status === 1) {
            //     $('#setupStepForm').show(500)
            // }
        });
        // $('#studentAttendanceBtn').click(function() {
        //     $('.overlay').show();
        //     let formData = new FormData($('#studentAttendanceForm')[0]);

        //     $.ajax({
        //         url: "{{route('submit.student.attendance')}}",
        //         type: "POST",
        //         data: formData,
        //         dataType: "JSON",
        //         processData: false,
        //         contentType: false,
        //         beforeSend: function() {
        //             $('button').prop('disabled', true);
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             $('button').prop('disabled', false);
        //             $('.overlay').hide();
        //             if (data.status === 1) {
        //                 alert_toast(data.message, 'success');
        //                 $('#studentAttendanceForm')[0].reset();
        //             } else {
        //                 alert_toast(data.message, 'warning');
        //             }
        //         },
        //         error: function(data) {
        //             console.log(data);
        //             $('button').prop('disabled', false);
        //             $('.overlay').hide();
        //             alert_toast('Something Went Wrong', 'error');
        //         }
        //     })
        // });

       

        multiSelect2('#formCategorySelect2','changeClassModal', 'category', 'Select Category');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formClassSelect2','changeClassModal', 'class', id, 'Select Class');
        });
        $('#formClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formArmSelect2', 'changeClassModal','class-teacher-class', id, 'Select Class Arm');
        });
         
    });
</script>
@endsection