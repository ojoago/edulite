@extends('layout.mainlayout')
@section('title','Take Student Attendance')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <select type="text" name="category" class="form-control form-control-sm mb-1" id="formCategorySelect2" required>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select type="text" name="class" class="form-control form-control-sm mb-1" id="formClassSelect2">
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select type="text" name="arm" class="form-control form-control-sm mb-1" id="formArmSelect2">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <select type="text" name="term" class="form-control form-control-sm" id="formTermSelect2">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select type="text" name="session" class="form-control form-control-sm" id="formSessionSelect2">
                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title"> <small>Attendance Count</small></h5>
                </div>
            </div>
            <!-- Primary Color Bordered Table -->

            <table class="table table-bordered border-primary  cardTable" id="attendanceTable">
                <thead>
                    <tr>
                        <th width="5%">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th width="10%"> Present </th>
                        <th width="10%"> Absent </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // toggle checkbox 


        FormMultiSelect2('#formCategorySelect2', 'category', 'Select Category');
        FormMultiSelect2('#formSessionSelect2', 'session', 'Select Session');
        FormMultiSelect2('#formTermSelect2', 'term', 'Select Term');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formClassSelect2', 'class', id, 'Select Class');
        });
        $('#formClassSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#formArmSelect2', 'class-teacher-arm', id, 'Select Class Arm');
        });

        $('#formArmSelect2').on('change', function(e) {
            var arm = $(this).val();
            if (arm != null) {
                loadAttendanceHistory(arm, session = null, term = null, date = null);
            }
        });
        FormMultiSelect2('#formSessionSelect2', 'session', 'Select Session');

        $('#formTermSelect2').on('change', function(e) {
            var arm = $('#formArmSelect2').val();
            term = $(this).val();
            if (arm != null || term != null) {
                loadAttendanceHistory(arm, term, session = null, date = null);
            } else {
                alert_toast('select Arm and Term to filter', 'warning');
            }
        });
        $('#formSessionSelect2').on('change', function(e) {
            session = $(this).val();
            var arm = $('#formArmSelect2').val();
            var term = $('#formTermSelect2').val();
            if (arm != null && term != null && session != null) {
                loadAttendanceHistory(arm, term, session, date = null);
            } else {
                alert_toast('select Arm and Term to filter', 'warning');
            }
        });
    });


    function loadAttendanceHistory(arm, term = null, session = null, date = null) {

        $('#attendanceTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            responsive: true,
            destroy: true,
            "ajax": {
                method: "POST",
                url: "{{route('load.student.attendance.count')}}",
                data: {

                    _token: "{{csrf_token()}}",
                    term_pid: term,
                    session_pid: session,
                    arm_pid: arm,
                    date: date,
                },
            },

            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    "data": "reg_number"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "present"
                },
                {
                    "data": "absent"
                },
            ],
        });
    }
</script>
@endsection