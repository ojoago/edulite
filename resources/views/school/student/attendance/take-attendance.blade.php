@extends('layout.mainlayout')
@section('title','Take Student Attendance')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('load.class.student')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select type="text" name="class" class="form-control form-control-sm" id="formClassSelect2">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select type="text" name="arm" class="form-control" id="formArmSelect2">
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-primary btn-sm" type="submit">Continue</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title">{{--$class--}} <small>Attendance</small></h5>
                    <p> <i class="bi bi-calendar-event-fill"></i> <span class="text-danger"> {{activeTermName()}} {{activeSessionName()}}</span></p>
                </div>
            </div>
            <!-- Primary Color Bordered Table -->
            @if(isset($data))
            <div class="row">
                <div class="col-md-8">
                    <form id="studentAttendanceForm">
                        @csrf
                        <table class="table table-bordered border-primary cardTable" id="resultTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th scope="col">Reg-Number</th>
                                    <th scope="col">Names</th>
                                    <th width="5%"> Present<input type="checkbox" class="checkAll" id="preantAll"> </th>
                                    <th width="5%">Absent <input type="checkbox" class="checkAll" id="absentAll"> </th>
                                    <th width="5%"> Excused<input type="checkbox" class="checkAll" id="excusedAll"> </th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$row->reg_number}}</td>
                                    <td>{{$row->fullname}}</td>
                                    <input type="hidden" name="student[]" value="{{$row->pid}}">
                                    <td> <input type="radio" class="preantAll" value="1" name="check[{{$row->pid}}]"></td>
                                    <td> <input type="radio" class="absentAll" value="0" name="check[{{$row->pid}}]"></td>
                                    <td> <input type="radio" class="excusedAll" value="2" name="check[{{$row->pid}}]"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="col-md-4 pt-4">
                    <label for="">Note</label>

                    <textarea type="text" name="note" placeholder="attendance note" class="form-control form-control-sm" id="attnote"></textarea>
                    <label>Date</label>
                    <input type="hidden" name="arm" value="{{$arm}}" required>
                    <input type="date" name="date" class="form-control form-control-sm" id="attdate" required>

                    <button class="btn btn-primary mt-2" type="button" id="studentAttendanceBtn">Submit</button>
                </div>
                </form>
            </div>
            @else
            <h5 class="card-title">Select Class to take Attendance</h5>

            @endif
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

        // toggle checkbox 
        $('.checkAll').click(function(event) {
            let id = $(this).attr('id');
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

        $('#studentAttendanceBtn').click(function() {
            $('.overlay').show();
            let formData = new FormData($('#studentAttendanceForm')[0]);

            $.ajax({
                url: "{{route('submit.student.attendance')}}",
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('button').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('button').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 1) {
                        alert_toast(data.message, 'success');
                        $('#studentAttendanceForm')[0].reset();
                    } else {
                        alert_toast(data.message, 'warning');
                    }
                },
                error: function(data) {
                    console.log(data);
                    $('button').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            })
        });

        // var arm = "{{session('arm')}}";
        // if (arm != null) {
        //     getArmSubject(arm)
        // }
        // var class_pid = "{{session('class')}}";
        // if (class_pid != null) {
        //     getClassArms(class_pid)
        // }
        FormMultiSelect2('#formCategorySelect2', 'category', 'Select Category');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formClassSelect2', 'class', id, 'Select Class');
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

        // function getArmSubject(id) {
        //     FormMultiSelect2Post('#formArmSubjectSelect2', 'class-arm-subject', id, 'Select Class Arm Subject');
        // }
    });
</script>
@endsection