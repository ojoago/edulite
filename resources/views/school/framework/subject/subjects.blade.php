@extends('layout.mainlayout')
@section('title','lite G S')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Subjects & Types</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab">Subject Type</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab">Subjects</button>
            </li>

        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSubjectTypeModal">
                    Create Subject Type
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="SubjectTypeTable">
                    <thead>
                        <tr>
                            <th>Subject Type</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Date</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#createSubjectModal">
                            Create Subject
                        </button>
                    </div>
                    <div class="col-md-6">
                        <select name="class_pid" id="categorySubjectSelect2" class="form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="SubjectTable">
                    <thead>
                        <tr>
                            <th>Subject Type</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th align="center"><i class="bi bi-tools"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create school term modal  -->
<div class="modal fade" id="createSubjectTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Subject Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="createSubjectTypeForm" id="createSubjectTypeForm">
                    @csrf
                    <input type="text" name="subject_type" class="form-control form-control-sm" placeholder="name of Subject" required>
                    <p class="text-danger subject_type_error"></p>
                    <input type="text" name="description" class="form-control form-control-sm" placeholder="Subject Description" required>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary createSubjectTypeBtn" id="createSubjectTypeForm">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- create school term modal  -->
<div class="modal fade" id="createSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="createSchoolCategortSubjectForm">
                    @csrf
                    <select name="category_pid" style="width:100%" class="form-control form-control-sm createSubjectCategorySelect2" id="createSubjectCategorySelect2">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <select name="subject_type_pid" style="width:100%" class="form-control form-control-sm createSubjectSubjectTypeSelect2" id="createSubjectSubjectTypeSelect2">
                    </select>
                    <p class="text-danger subject_type_pid_error"></p>
                    <input type="text" name="subject" id="subject" class="form-control form-control-sm" placeholder="subject name" required>
                    <input type="hidden" name="pid" id="pid">
                    <p class="text-danger subject_error"></p>
                    <textarea type="text" name="description" id="description" class="form-control form-control-sm" placeholder="description" required></textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // load school subject type
        $('#SubjectTypeTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "GET",
            "ajax": "{{route('load.school.subject.type')}}",
            "columns": [{
                    "data": "subject_type"
                },
                {
                    "data": "description"
                },
                {
                    "data": "username"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "action"
                },
            ],
        });
        // load school subjects
        loadSubjectTable();

        function loadSubjectTable(ctg = null) {
            $('#SubjectTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.school.subject')}}",
                    data: {
                        param: ctg,
                        _token: "{{csrf_token()}}",
                    },
                    type: "post",
                },
                "columns": [{
                        "data": "subject_type"
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "username"
                    },

                    {
                        "data": "action"
                    },
                ],
            });
        }
        // load subject for a particular category on change  
        $('#categorySubjectSelect2').change(function() {
            var pid = $(this).val();
            if (pid != null) {
                loadSubjectTable(pid)
            }
        })
        // load dropdown on 
        multiSelect2('#createSubjectSubjectTypeSelect2', 'createSubjectModal', 'subject-type', 'Select Subject Type');
        multiSelect2('#createSubjectCategorySelect2', 'createSubjectModal', 'category', 'Select Category');
        FormMultiSelect2('#categorySubjectSelect2', 'category', 'Select Category');

        $(document).on('click', '.edit-subject', function() {
            var pid = $(this).attr('pid');
            var token = "{{csrf_token()}}"
            $('.modal-title').text('Edit Subject').addClass('text-info');
            $('#createSubjectBtn').text('Edit').addClass('btn-warning');

            $.ajax({
                url: "{{route('load.subject.by.id')}}",
                type: "POST",
                data: {
                    pid: pid,
                    _token: token
                },
                dataType: "JSON",
                beforeSend: function() {
                    $('.overlay').show();
                },
                success: function(data) {
                    console.log(data);
                    $('.overlay').hide();
                    if (data.status === 1) {
                        $('#subject').val(data.data.subject)
                        $('#description').val(data.data.description)
                        $('#pid').val(data.data.pid)
                        multiSelect2('#createSubjectSubjectTypeSelect2', 'createSubjectModal', 'subject-type', 'Select Subject Type', data.data.subject_type_pid);
                        multiSelect2('#createSubjectCategorySelect2', 'createSubjectModal', 'category', 'Select Category', data.data.category_pid);
                        $('#createSubjectModal').modal('show')
                    } else {
                        alert_toast('failed not load subject', 'warning');
                        $('.modal-title').text('Create Lite S').removeClass('text-info');
                        $('#createSubjectBtn').text('Submit').removeClass('btn-warning');
                    }
                },
                error: function(data) {
                    console.log(data);
                    $('.overlay').hide();
                    $('.modal-title').text('Create Subject type').removeClass('text-info');
                    $('#createSubjectBtn').text('Submit').removeClass('btn-warning');
                    alert_toast('Something Went Wrong', 'error');
                }
            });

        });
        $(document).on('click', '.createSubjectTypeBtn', function() {
            let form = $(this).attr('id');
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.subject.type')}}",
                type: "POST",
                data: new FormData($('#' + form)[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.createSubjectTypeForm').find('p.text-danger').text('');
                    $('.createSubjectTypeBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('.createSubjectTypeBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#' + form)[0].reset();
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('.createSubjectTypeBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });

        // create subject 
        $('#createSubjectBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.subject')}}",
                type: "POST",
                data: new FormData($('#createSchoolCategortSubjectForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createSchoolCategortSubjectForm').find('p.text-danger').text('');
                    $('#createSubjectBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#createSubjectBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form, correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createSchoolCategortSubjectForm')[0].reset();
                    }
                },
                error: function(data) {
                    console.log(data);
                    $('#createSubjectBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });

    });
</script>

@endsection