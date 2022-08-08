@extends('layout.mainlayout')
@section('title','lite G S')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Lite Grade</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab" aria-controls="home" aria-selected="true">CC</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">CL</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-justified" type="button" role="tab" aria-controls="contact" aria-selected="false">CLA</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-subject-tab" data-bs-toggle="tab" data-bs-target="#class-subject" type="button" role="tab" aria-controls="class-subject" aria-selected="false">CLA SB</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassCategoryModal">
                    Create CC
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="classCategoryTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassModal">
                    Create CL
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="classTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassArmModal">
                    Create CLA
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="classArmTable">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>CLass Arm</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="class-subject" role="tabpanel" aria-labelledby="class-subject">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassArmModal">
                    Create CLA
                </button>
                List sson lca arm    
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="classArmTable">
                    <thead>
                        <tr>
                            <th>sbj</th>
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

<!-- modals  -->
<!-- create school category modal  -->
<div class="modal fade" id="createClassCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Lite Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassCategoryForm">
                    @csrf
                    <input type="text" name="category" class="form-control form-control-sm" placeholder="school category" required>
                    <p class="text-danger category_error"></p>
                    <select name="staff_pid" id="staffSelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger staff_pid_error"></p>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required></textarea>
                    <p class="text-danger description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createClassCategoryBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->
<div class="modal fade" id="createClassModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Lite Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassForm">
                    @csrf
                    <select name="category_pid" id="classCategorySelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <input type="text" name="class" placeholder="class e.g JSS 1" class="form-control form-control-sm" required>
                    <p class="text-danger class_error"></p>
                    <input type="number" name="class_number" placeholder="class number e.g 1,2,3 e.t.c" class="form-control form-control-sm" required>
                    <p class="text-danger class_number_error"></p>
                    <p>class number is used to promote student to the next class automatically by the system if need be</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createClassBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->
<div class="modal fade" id="createClassArmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Lite Class Arm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassArmForm">
                    @csrf
                    <select name="category_pid" id="categorySelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <select name="class_pid" id="classSelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <input type="text" name="arm" placeholder="class arm" class="form-control form-control-sm" required>
                    <p class="text-danger arm_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createClassArmBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // load page content  
        // load school category
        $('#classCategoryTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "GET",
            "ajax": "{{route('load.school.category')}}",
            "columns": [{
                    "data": "category"
                },
                {
                    "data": "description"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "username"
                },
            ],
        });
        // load school classes
        $('#classTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "GET",
            "ajax": "{{route('load.school.classes')}}",
            "columns": [{
                    "data": "category"
                },
                {
                    "data": "class"
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
            ],
        });
        // load school class arm
        $('#classArmTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            type: "GET",
            "ajax": "{{route('load.school.class.arm')}}",
            "columns": [{
                    "data": "class"
                },
                {
                    "data": "arm"
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
            ],
        });
        // load dropdown on 

        $('#classCategorySelect2').select2({
            placeholder: 'Select Category',
            dropdownParent: $('#createClassModal'),
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
        $('#categorySelect2').select2({
            placeholder: 'Select Category',
            dropdownParent: $('#createClassArmModal'),
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

        $('#classSelect2').select2({
            placeholder: 'Select CLass',
            dropdownParent: $('#createClassArmModal'),
            ajax: {
                url: "{{route('load.available.class')}}",
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
        // create school category 
        $('#createClassCategoryBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.category')}}",
                type: "POST",
                data: new FormData($('#createClassCategoryForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createClassCategoryForm').find('p.text-danger').text('');
                    $('#createClassCategoryBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
                    $('#createClassCategoryBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createClassCategoryForm')[0].reset();
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('#createClassCategoryBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // create school class 
        $('#createClassBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.class')}}",
                type: "POST",
                data: new FormData($('#createClassForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createClassForm').find('p.text-danger').text('');
                    $('#createClassBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
                    $('#createClassBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createClassForm')[0].reset();
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('#createClassBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // create school class arm
        $('#createClassArmBtn').click(function() {
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.school.class.arm')}}",
                type: "POST",
                data: new FormData($('#createClassArmForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createClassArmForm').find('p.text-danger').text('');
                    $('#createClassArmBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
                    $('#createClassArmBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createClassArmForm')[0].reset();
                    }
                },
                error: function(data) {
                    // console.log(data);
                    $('#createClassArmBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->