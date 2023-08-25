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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classCategoryTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Action</th>
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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classTable">
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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classArmTable">
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
                            Add Subjects to Class Arm
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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classArmSubjectTable">
                    <thead>
                        <tr>
                            <th width="3%">S/N</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <!-- <th>Created By</th> -->
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

<!-- create school category modal  -->

<!-- create class subject  -->

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // add more title 
       
        
        
        
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
                {
                    "data": "action"
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
                destroy: true,
                // type: "post",
                "ajax": {
                    url: "{{route('load.school.class.arm.subject')}}",
                    data: {
                        param: cls,
                        _token: "{{csrf_token()}}",
                    },
                    type: "post",
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
                        "data": "status"
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
            if (id != null) {
                loadSubject(id);
            }
        });

        multiSelect2('#assignClassToteacherSelect2', 'createArmTeacherModal', 'school-teachers', 'Select Class Teacher');
        // createArmTeacherModal
        multiSelect2('#termSelect24t', 'createArmTeacherModal', 'term', 'Select Term');
        multiSelect2('#sessionSelect24t', 'createArmTeacherModal', 'session', 'Select Session');
        multiSelect2('#sessionSelect2', 'createArmSubjectModal', 'session', 'Select Session');
        multiSelect2('#editClassCategorySelect2', 'createClassModal', 'category', 'Select Category');

        
        // load principal/ head 

        

        

        // edit class category goes here  
        $(document).on('click', '.editCategory', async function() {
            let pid = $(this).attr('pid');
            let params = {
                pid: pid,
                _token: "{{csrf_token()}}"
            };
            let route = "{{route('load.school.category.by.pid')}}";
            let data = await loadDataAjax(route, params);
            if (data) {
                $('#categoryName').val(data.category);
                $('#categoryPid').val(data.pid);
                $('#categoryDescription').val(data.description);
                $('.overlay').hide();
                $('#createClassCategoryModal').modal('show');
            } else {
                showTipMessage('cluod not load category');
            }
        });
       

        $(document).on('click', '.updateClassBtn', function() {
            let pid = $(this).attr('pid');
            submitFormAjax('updateClassForm' + pid, 'id' + pid, "{{route('update.class')}}");
        });

        // create school class arm
        


        // create school class arm
        

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->