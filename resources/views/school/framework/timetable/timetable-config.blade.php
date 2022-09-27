@extends('layout.mainlayout')
@section('title','Exam Timetable')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Exam Timetable</h5>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createTimetableModal">
            Create
        </button>
        <div class="row mb-3">
            <div class="col-md-3">
                <select name="category_pid" id="timetableCategorySelect2" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-md-3">
                <select name="class_pid" id="timetableClassSelect2" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-md-3">
                <select name="arm_pid" id="timetableArmSelect2" class="classSelect2 form-control form-control-sm">
                </select>
            </div>
            <div class="col-md-3">
                <select name="session_pid" id="timetableSessionSelect2" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select name="term_pid" id="timetableTermSelect2" class="form-control form-control-sm">
                </select>
            </div>
        </div>
        <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="timetableDatatable">
            <thead>
                <tr>
                    <th width="5%">S/N</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- modals  -->


<!-- create school category modal  -->
<div class="modal fade" id="createTimetableModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Term Timetable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createTimetableForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <select name="category_pid" id="ctCategorySelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                        </div>
                        <div class="col-md-6">
                            <select name="class_pid" id="ctClassSelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                        <div class="col-md-12">
                            <select name="arm_pid[]" multiple="multiple" id="ctArmSelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger arm_pid_error"></p>
                        </div>
                    </div>
                    <center>
                        <button id="addMoreSubject" type="button" class="btn btn-danger btn-sm btn-small mb-1">Add More Row</button><br>
                    </center>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="arm">Subject</label>
                            <select type="text" name="subject[]" id="ctArmSubjects0" placeholder="class arm" class="form-control form-control-sm" required>
                            </select>
                            <p class="text-danger subject_error"></p>
                        </div>
                        <div class="col-md-3">
                            <label for="arm">Date</label>
                            <input type="date" name="date[]" onkeydown="return false" class="form-control form-control-sm" required>
                            <p class="text-danger date0_error"></p>
                        </div>
                        <div class="col-md-3">
                            <label for="number">Time</label>
                            <div class="input-group mb-3">
                                <input type="time" name="time[]" onkeydown="return false" placeholder="class arm" class="form-control form-control-sm" required>
                                <i class="bi bi-x-circle-fill text-white m-2 removeRowBtn pointer"></i>
                            </div>
                            <p class="text-danger time0_error"></p>
                        </div>
                    </div>
                    <div id="moreSubjectRow"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createTimetableBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // add more title 

        $(document).on('click', '.addedRow .removeRowccaBtn', function() {
            $(this).parent().parent().parent().remove();
        });
        var psp = 0;
        $('#addMoreSubject').click(function() {
            psp++;
            $('#moreSubjectRow').append(
                `
                 <div class="addedRow">
                       <div class="row">
                        <div class="col-md-6">
                            <label for="arm">Subject</label>
                            <select type="text" name="subject[]" id="ctArmSubjects${psp}" placeholder="class subject" class="form-control form-control-sm" required>
                            </select>
                            <p class="text-danger subject${psp}_error"></p>
                        </div>
                        <div class="col-md-3">
                            <label for="arm">Date</label>
                            <input type="date" name="date[]" onkeydown="return false" placeholder="class date" class="form-control form-control-sm" required>
                            <p class="text-danger date${psp}_error"></p>
                        </div>
                        <div class="col-md-3">
                            <label for="number">Time</label>
                            <div class="input-group mb-3">
                                <input type="time" name="time[]" onkeydown="return false" placeholder="class time" class="form-control form-control-sm" required>
                                <i class="bi bi-x-circle-fill text-danger m-2 removeRowBtn pointer"></i>
                            </div>
                            <p class="text-danger time${psp}_error"></p>
                        </div>
                    </div>
                `
            );
            // init select2 again 
            subjectsDropDown(psp)
        });

        // subjectsDropDown(psp)
        function subjectsDropDown(psp) {
            let pid = $('#ctClassSelect2').val();
            multiSelect2Post('#ctArmSubjects' + psp, 'createTimetableModal', 'all-arms-subject', pid, 'Select Class Subject');
        }


        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });
        $('#timetableArmSelect2').change(function() {
            let arm = $(this).val();
            let session = $('#timetableSessionSelect2').val();
            let term = $('#timetableTermSelect2').val();
            if(arm !=null){

                loadTimetable(arm, session, term);
            }
        })
        $('#timetableSessionSelect2').change(function() {
            let session = $(this).val();
            let arm = $('#timetableArmSelect2').val();
            let term = $('#timetableTermSelect2').val();
            if(session != null){

                loadTimetable(arm, session, term);
            }
        })
        $('#timetableTermSelect2').change(function() {
            let term = $(this).val();
            let arm = $('#timetableArmSelect2').val();
            let session = $('#timetableSessionSelect2').val();
            if(term != null){

                loadTimetable(arm, session, term);
            }
        })



        // load page content  
        loadTimetable();
        // load school timetable
        function loadTimetable(arm = null, session = null, term = null) {
            $('#timetableDatatable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('load.school.timetable')}}",
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: session,
                        term_pid: term,
                        arm_pid: arm,
                    },
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "arm"
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "exam_date"
                    },
                    {
                        "data": "exam_time",
                    },
                    {
                        "data": "date"
                    },
                ],
            });
        }

        // filter class subject 
        FormMultiSelect2('#timetableCategorySelect2', 'category', 'Select Category');
        FormMultiSelect2('#timetableTermSelect2', 'term', 'Select Term');
        FormMultiSelect2('#timetableSessionSelect2', 'session', 'Select Session');
        $('#timetableCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#timetableClassSelect2', 'class', id, 'Select Class');
        });
        $('#timetableClassSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#timetableArmSelect2', 'class-arm', id, 'Select Class Arm');
        });


        multiSelect2('#ctCategorySelect2', 'createTimetableModal', 'category', 'Select Category');
        $('#ctCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#ctClassSelect2', 'createTimetableModal', 'class', id, 'Select Class');
        });
        $('#ctClassSelect2').on('change', function(e) {
            var pid = $(this).val();
            multiSelect2Post('#ctArmSelect2', 'createTimetableModal', 'class-arm', pid, 'Select Class Arm');
            // var id = ;
            multiSelect2Post('#ctArmSubjects0', 'createTimetableModal', 'all-arms-subject', pid, 'Select Class Subject');
        });


        // create school class arm
        $('#createTimetableBtn').click(function() {
            submitFormAjax('createTimetableForm', 'createTimetableBtn', "{{route('create.school.timetable')}}");
        });

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->