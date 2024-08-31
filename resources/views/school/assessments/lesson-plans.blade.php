@extends('layout.mainlayout')
@section('title','Assignment')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet"> -->
<style>
    .formController {
        right: 0 !important;
        position: fixed;
        z-index: 1;
        padding: 5px;
        border: 1px solid #f1f1f1;
    }

    .non-visible {
        visibility: hidden;
    }
</style>
<div class="card">
    <div class="card-body">
        <h5 class="card-title mr-4">Lesson Plan 
            <button type="button" class="btn btn-primary mb-2 btn-sm" data-bs-toggle="modal" data-bs-target="#lessonPlanModal">
                    Add New
                </button>
        </h5>
        
        <div class="row mb-3">
            {{-- <div class="col-md-3">
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
            </div> --}}
            <div class="col-md-3">
                <select name="session_pid" id="timetableSessionSelect2" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <select name="term_pid" id="timetableTermSelect2" class="form-control form-control-sm">
                </select>
            </div>
        </div>
        <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="planDatatable">
            <thead>
                <tr>
                    <th width="5%">S/N</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Week</th>
                    <th>Period</th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        
    </div>
    <!-- create school category modal  -->
<div class="modal fade" id="lessonPlanModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lesson Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="lessonPlanForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <select name="category_pid" id="planCategorySelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                        </div>
                        <div class="col-md-4">
                            <select name="class_pid" id="planClassSelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                        <div class="col-md-4">
                            <select name="arm_pid" id="planArmSelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger arm_pid_error"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="arm">Subject</label>
                            <select type="text" name="subject_pid" id="planArmSubjectSelect2" placeholder="class arm" class="form-control form-control-sm" required>
                            </select>
                            <p class="text-danger subject_pid_error"></p>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Week</label>
                            <input type="text" class="form-control form-control-sm" name="week" id="week" placeholder="e.g 3">
                            <p class="text-danger week_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Period</label>
                            <input type="text" class="form-control form-control-sm" name="period" id="period" placeholder="e.g 3">
                            <p class="text-danger period_error"></p>
                        </div>
                    
                        <div class="col-md-4">
                            <label class="form-label">Type</label><br>
                            Upload <input type="radio" class="radio assessmentType" name="type" id="planType" value="1">
                            In App <input type="radio" class="radio assessmentType" name="type" id="planType" value="2">
                            <p class="text-danger type_error"></p>
                        </div>

                    </div>
                    <div class="col-md-12" id="lessonText" style="display:none">
                            <label class="form-label">Lesson Plan</label>
                            <textarea name="plan" class="form-control form-control-sm summer-note"></textarea>
                            <p class="text-danger plan_error"></p>
                        </div>
                      
                        <div class="col-md-12" style="display:none" id="lessonFile">
                            <label class="form-label">File</label>
                            <input type="file" accept=".pdf,.docs,.doc" name="file" class="form-control form-control-sm">
                            <p class="text-danger file_error"></p>
                        </div>
                </form>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="lessonPlanBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {

        multiSelect2('#planCategorySelect2', 'lessonPlanModal', 'category', 'Select Category');
        $('#planCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#planClassSelect2', 'lessonPlanModal', 'class', id, 'Select Class');
        });

        $('#planClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#planArmSelect2', 'lessonPlanModal', 'class-teacher-arm', id, 'Select Class');
        });

        $('#planArmSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#planArmSubjectSelect2', 'lessonPlanModal',  'class-arm-subject', id, 'Select Class Subject');
        });
  
        $('.assessmentType').click(function() {
            const type = $(this).val();
            if (type == 1) {
                $('#lessonFile').show(500);
                $('#lessonText').hide(500);
            } else if(type  == 2 ) {
                $('#lessonFile').hide(500);
                $('#lessonText').show(500);
            }
        });
       
        $('#lessonPlanBtn').click(async function() {

           let s = await submitFormAjax('lessonPlanForm', 'lessonPlanBtn', "{{route('add.lesson.plan')}}");
           if(s.status == 1){
               $('.summer-note').val('')
            loadTimetable();
           }

        });


        
        $('.summer-note').summernote({
            fontsize: '14'
        })
       
        
        // load page content  
        loadTimetable();
        // load school timetable

        function loadTimetable(arm = null, session = null, term = null) {
            $('#planDatatable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.lesson.plan')}}",
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
                        "data": "week"
                    },
                    {
                        "data": "period",
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "action"
                    },
                ],

             
                "columnDefs": [{
                    "visible": false,
                    "targets": 1
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(1, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="15">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }


   
    });
</script>
@endsection