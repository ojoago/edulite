@extends('layout.mainlayout')
@section('title','lite G S')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Lite Grade</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab" aria-controls="home" aria-selected="true">Type</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">Sub</button>
            </li>

        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSubjectTypeModal">
                    Create S T
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="SubjectTypeTable">
                    <thead>
                        <tr>
                            <th>Subject Type</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <button type="button" class="btn btn-primary mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#createSubjectModal">
                    Create S
                </button>
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
                <h5 class="modal-title">Create Lite S T</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="createSubjectTypeForm">
                    @csrf
                    <input type="text" name="subject" class="form-control form-control-sm" placeholder="name of Subject" required>
                    <p class="text-danger subject_error"></p>
                    <input type="text" name="description" class="form-control form-control-sm" placeholder="Subject Description" required>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createSubjectTypeBtn">Submit</button>
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
                <h5 class="modal-title">Create Lite S</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="createSchoolCategortSubjectForm">
                    @csrf
                    <select name="category_pid" style="width:100%" class="form-control form-control-sm" id="categorySelect2">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <select name="subject_type_pid" style="width:100%" class="form-control form-control-sm" id="subjectTypeSelect2">
                    </select>
                    <p class="text-danger subject_type_pid_error"></p>
                    <input type="text" name="subject" class="form-control form-control-sm" placeholder="subject name" required>
                    <p class="text-danger subject_error"></p>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required></textarea>
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
        $('#SubjectTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "GET",
            "ajax": "{{route('load.school.subject')}}",
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

                // {
                //     "data": "action"
                // },
            ],
        });

        // load dropdown on 
        $('#subjectTypeSelect2').select2({
            placeholder: 'Select Subject Category',
            dropdownParent: $('#createSubjectModal'),
            ajax: {
                url: "{{ route('load.available.subject.type') }}",
                'type': 'GET',
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $('#categorySelect2').select2({
            placeholder: 'Select School Category',
            dropdownParent: $('#createSubjectModal'),
            ajax: {
                url: "{{route('load.available.category')}}",
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $('#createSubjectTypeBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.subject.type')}}",
                type: "POST",
                data: new FormData($('#createSubjectTypeForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createSubjectTypeForm').find('p.text-danger').text('');
                    $('#createSubjectTypeBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#createSubjectTypeBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createSubjectTypeForm')[0].reset();
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('#createSubjectTypeBtn').prop('disabled', false);
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