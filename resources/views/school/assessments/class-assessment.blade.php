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
        <h5 class="card-title mr-4">Assignments</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="submitted-tab" data-bs-toggle="tab" data-bs-target="#submitted" type="button" role="tab" aria-controls="submitted" aria-selected="false">Assessments</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="mark-tab" data-bs-toggle="tab" data-bs-target="#mark" type="button" role="tab" aria-controls="mark" aria-selected="false">Submitted</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            
            <div class="tab-pane fade show active" id="submitted" role="tabpanel" aria-labelledby="submitted-tab">
                <div class="row p-2">
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentSessionSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentTermSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="assignmentTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Subject</th>
                            <th>TItle</th>
                            <!-- <th>Date</th> -->
                            <th>Deadline</th>
                            <!-- <th></th> -->
                            <th>Date</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="mark" role="tabpanel" aria-labelledby="mark-tab">
                <div class="row p-2">
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentSessionSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="session" id="newAssignmentTermSelect2" style="width: 100%;" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="markTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Subject</th>
                            <th>Student</th>
                            <!-- <th>Date</th> -->
                            <th>Date Submitted</th>
                            <th>Mark</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div><!-- End Default Tabs -->
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {

        loadAssessment()
        $('#submitted-tab').click(function() {
            loadAssessment()
        })
        $('#mark-tab').click(function() {
            loadSubmittedAssessments()
        })

        function loadSubmittedAssessments() {
            $('#markTable').DataTable({
                "processing": true,
                "serverSide": true,

                responsive: true,
                destroy: true,
                "ajax": "{{route('load.class.submitted.assessments')}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "fullname"
                    },

                    {
                        "data": "created_at"
                    },
                    {
                        "data": "mark"
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
                                '<tr class="group"><td colspan="4">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }

        function loadAssessment() {
            $('#assignmentTable').DataTable({
                "processing": true,
                "serverSide": true,

                responsive: true,
                destroy: true,
                "ajax": "{{route('load.assignment')}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "end_date"
                    },


                    {
                        "data": "created_at"
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
                                '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }

       
        // delete assessment 
        $(document).on('click', '.deleteAssessment', function() {

            Swal.fire({
                title: 'Delete Assessment',
                text: "Are you sure, you want to delete this ?",
                type: "warning",
                confirmButtonText: 'Yes Delete',
                confirmButtonColor: '#DD6B55',
                cancelButtonText: "No, Cancel!",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result) => {
                if (result['isConfirmed']) {
                    // Put your function here
                    const key = $(this).attr('key');
                    $('.overlay').show();
                    $.ajax({
                        url: "{{route('delete.assessment')}}", //"url,
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            key: key
                        },
                        success: function(data) {
                            console.log(data);
                            $('.overlay').hide();
                            if (data.status === 1) {
                                alert_toast(data.message);
                                loadAssessment()
                            } else {
                                alert_toast(data.message, 'error');
                            }
                        },
                        error: function(data) {

                            $('.overlay').hide();
                            alert_toast('Something Went Wrong', 'error');
                        }
                    });
                }
            })

        })
       
      

      
        $('.summer-note').summernote({
            fontsize: '14'
        })
        // remove question 
        $(document).on('click', '.removeFieldsetBtn', function() {
            $(this).parent().parent().remove()
        });

     
    });
</script>
@endsection