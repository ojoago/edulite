@extends('layout.mainlayout')
@section('title','School class & category')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Class & Category</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab">Class Category</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab">Class</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-arm-tab" data-bs-toggle="tab" data-bs-target="#class-arm" type="button" role="tab">Class Arm</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-subject-tab" data-bs-toggle="tab" data-bs-target="#class-subject" type="button" role="tab">Class Subject</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassCategoryModal">
                    Create Category
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
                    Create Class
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="classTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="class-arm" role="tabpanel" aria-labelledby="class-arm-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassArmModal">
                    Create Class Arm
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="classArmTable">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Class Arm</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="class-subject" role="tabpanel" aria-labelledby="class-subject">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createArmSubjectModal">
                            Create Class Arm Subjects
                        </button>
                    </div>
                    <div class="col-md-3">
                        <select name="class_pid" id="categoryClassSubjectSelect2" class="form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="class_pid" id="classSubjectSelect2" class="classSelect2 form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="class_pid" id="classArmSubjectSelect2" class="form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3" width="100%" id="classArmSubjectTable">
                    <thead>
                        <tr>
                            <th>Session</th>
                            <th>CLass</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Action</th>
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
                <h5 class="modal-title">Create School Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassCategoryForm">
                    @csrf
                    <input type="text" name="category" class="form-control form-control-sm" placeholder="school category" required>
                    <p class="text-danger category_error"></p>
                    <label for="head_pid">Principal/Head</label>
                    <select name="head_pid" id="staffSelect2" style="width: 100%;">
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
                <h5 class="modal-title">Create School Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassForm">
                    @csrf
                    <select name="category_pid" id="classCategorySelect2" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <button id="addMore" type="button" class="btn btn-danger btn-sm btn-small m-3">Add More Row</button><br>
                    <i id="addMoreRow"></i>
                    <div class="row">
                        <div class="col-md-7">
                            <input type="text" name="class[]" placeholder="class e.g JSS 1" class="form-control form-control-sm" required>
                            <p class="text-danger class_error"></p>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <select name="class_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                    <option disabled selected>Select Class Number</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="4">Four</option>
                                    <option value="5">Five</option>
                                    <option value="6">Six</option>
                                    <option value="7">Seven</option>
                                    <option value="8">Eight</option>
                                    <option value="9">Nine</option>
                                    <option value="10">Ten</option>
                                </select>
                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                            </div>
                            <p class="text-danger class_number_error"></p>
                        </div>
                    </div>
                    <p>[Class equivalence in number] is used to promote student to the next class automatically by the system if need be</p>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Class Arm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassArmForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <select name="category_pid" id="ccaCategorySelect2" class="ccaCategorySelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                        </div>
                        <div class="col-md-6">
                            <select name="class_pid" id="ccaClassSelect2" class="ccaclassSelect2 form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                    </div>
                    <center>
                        prepend class name to class arm ? <input type="checkbox" name="prepend">
                        <button id="addMoreArm" type="button" class="btn btn-danger btn-sm btn-small mb-1">Add More Row</button><br>
                    </center>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="arm">Class Arm Name</label>
                            <input type="text" name="arm[]" placeholder="class arm" class="form-control form-control-sm" required>
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Class Arm Serial Number</label>
                            <div class="input-group mb-3">
                                <select name="arm_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                    <option disabled selected>Select Class Number</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="4">Four</option>
                                    <option value="5">Five</option>
                                    <option value="6">Six</option>
                                    <option value="7">Seven</option>
                                    <option value="8">Eight</option>
                                    <option value="9">Nine</option>
                                    <option value="10">Ten</option>
                                </select>
                                <i class="bi bi-x-circle-fill text-white m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger arm_number_error"></p>
                        </div>
                    </div>
                    <div id="addMoreArmRow"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createClassArmBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create class subject  -->
<div class="modal fade" id="createArmSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Class Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassArmSubjectForm">
                    @csrf
                    <label for="category_pid">Category</label>
                    <select name="category_pid" id="casfCategorySelect2" class="form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger category_pid_error"></p>
                    <label for="session_pid">Session</label>
                    <select name="session_pid" id="casfSessionSelect2" placeholder="select" class=" " style="width: 100%;">
                    </select>
                    <p class="text-danger session_pid_error"></p>
                    <label for="class_pid">Class</label>
                    <select name="class_pid" id="casfClassSelect2" class="classSelect2 form-control form-control-sm" style="width: 100%;">
                    </select>
                    <p class="text-danger class_pid_error"></p>
                    <label for="arm_pid">Arm</label>
                    <select name="arm_pid[]" id="casfArmSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger arm_pid_error"></p>
                    <label for="subject_pid">Subjects</label>
                    <select name="subject_pid[]" id="casfSubjectSelect2" multiple="multiple" style="width: 100%;" class="form-control form-control-sm">
                    </select>
                    <p class="text-danger subject_pid_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createClassArmSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // add more title 
        $('#addMore').click(function() {
            $('#addMoreRow').prepend(
                `
                 <div class="row addedRow">
                        <div class="col-md-7">
                            <input type="text" name="class[]" placeholder="class e.g JSS 1" class="form-control form-control-sm" required>
                            <p class="text-danger class_error"></p>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <select name="class_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                <option disabled selected>Select Class Number</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                <option value="4">Four</option>
                                <option value="5">Five</option>
                                <option value="6">Six</option>
                                <option value="7">Seven</option>
                                <option value="8">Eight</option>
                                <option value="9">Nine</option>
                                <option value="10">Ten</option>
                            </select>
                            <i class="bi bi-x-circle-fill text-danger m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger class_number_error"></p>
                        </div>
                    </div>
                `
            );
            // init select2 again 
        });

        $(document).on('click', '.addedRow .removeRowccaBtn', function() {
            $(this).parent().parent().parent().remove();
        });
        var psp = 2;
        $('#addMoreArm').click(function() {
            psp++;
            $('#addMoreArmRow').append(
                `
                 <div class="row addedRow">
                        <div class="col-md-6">
                        <label for="number">Class Arm Name</label>
                            <input type="text" name="arm[]" placeholder="class arm" class="form-control form-control-sm" required>
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-6">
                        <label for="number">Class Arm Serial Number</label>
                            <div class="input-group mb-3">
                                <select name="arm_number[]" id="classNumberSelect2" class="form-control form-control-sm">
                                    <option disabled selected>Arm serial number</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="4">Four</option>
                                    <option value="5">Five</option>
                                    <option value="6">Six</option>
                                    <option value="7">Seven</option>
                                    <option value="8">Eight</option>
                                    <option value="9">Nine</option>
                                    <option value="10">Ten</option>
                                </select>
                                <i class="bi bi-x-circle-fill text-danger m-2 removeRowccaBtn pointer"></i>
                            </div>
                            <p class="text-danger arm_number_error"></p>
                        </div>
                    </div>
                `
            );
            // init select2 again 
        });

        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });
        $("#classNumberSelect2").select2({
            tags: true,
            dropdownParent: $('#createClassModal'),
            width: "100%",
        });
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
                {
                    "data": "action"
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
                {
                    "data": "action"
                },
            ],
        });
        loadSubject(cls = null)
        // load school class arm
        function loadSubject(cls = null) { //cls class
            $('#classArmSubjectTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                type: "post",
                "ajax": {
                    url: "{{route('load.school.class.arm.subject')}}",
                    data: {
                        param: cls,
                        _token: "{{csrf_token()}}",
                    },
                    type: "post",
                },
                "columns": [{
                        "data": "session"
                    },
                    {
                        "data": "arm"
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "fullname"
                    },
                    {
                        "data": "action"
                    },
                ],
            });
        }

        // load dropdown on 

        // filter class subject 
        FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        $('#categoryClassSubjectSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#classSubjectSelect2', 'class', id, 'Select Class');
        });
        $('#classSubjectSelect2').on('change', function(e) {
            var id = $(this).val();
            FormMultiSelect2Post('#classArmSubjectSelect2', 'class-arm', id, 'Select Class Arm');
        });
        $('#classArmSubjectSelect2').on('change', function(e) {
            var id = $(this).val();
            loadSubject(id);
        });
        // createArmTeacherModal
        multiSelect2('#termSelect24t', 'createArmTeacherModal', 'term', 'Select Term');
        multiSelect2('#sessionSelect24t', 'createArmTeacherModal', 'session', 'Select Session');
        multiSelect2('#sessionSelect2', 'createArmSubjectModal', 'session', 'Select Session');
        multiSelect2('#classCategorySelect2', 'createClassModal', 'category', 'Select Category');
        multiSelect2('.ccaCategorySelect2', 'createClassArmModal', 'category', 'Select Category');
        $('#ccaCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#ccaClassSelect2', 'createClassArmModal', 'class', id, 'Select Class');
        });
        // load principal/ head 
        multiSelect2('#staffSelect2', 'createClassCategoryModal', 'school-category-head', 'Select Category Head');

        multiSelect2('#casfCategorySelect2', 'createArmSubjectModal', 'category', 'Select Category');
        multiSelect2('#casfSessionSelect2', 'createArmSubjectModal', 'session', 'Select Category');
        $('#casfCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#casfClassSelect2', 'createArmSubjectModal', 'class', id, 'Select Class');
        });
        $('#casfCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#casfSubjectSelect2', 'createArmSubjectModal', 'category-subject', id, 'Select Subject');
        });
        $('#casfClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#casfArmSelect2', 'createArmSubjectModal', 'class-arm', id, 'Select Class Arm');
        });


        // create school category
        $('#createClassCategoryBtn').click(function() {
            submitFormAjax('createClassCategoryForm', 'createClassCategoryBtn', "{{route('create.school.category')}}");
        });
        // create school class 
        $('#createClassBtn').click(function() {
            submitFormAjax('createClassForm', 'createClassBtn', "{{route('create.school.class')}}");
        });

        // create school class arm
        $('#createClassArmBtn').click(function() {
            submitFormAjax('createClassArmForm', 'createClassArmBtn', "{{route('create.school.class.arm')}}");
        });


        // create school class arm
        $('#createClassArmSubjectBtn').click(function() {
            submitFormAjax('createClassArmSubjectForm', 'createArmSubjectBtn', "{{route('create.school.class.arm.subject')}}");
        });

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->