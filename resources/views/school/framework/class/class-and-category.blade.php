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
                            <th>Serial Number</th>
                            <th>Head</th>
                            <th>Description</th>
                            <!-- <th>Created By</th> -->
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
                            {{-- <th>Date</th> --}}
                            <!-- <th>Created By</th> -->
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
                            <th width="5%">S/N</th>
                            <th>Class</th>
                            <th>Class Arm</th>
                            <!-- <th>Status</th> -->
                            <!-- <th>Date</th> -->
                            <!-- <th>Class Teacher</th> -->
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
                            <!-- <th>Status</th> -->
                            <!-- <th>Date</th> -->
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


<script>
    $(document).ready(function() {
        // add more title 

        // load page content  
        // load school category
        loadCategory()

        function loadCategory(p = null){
            $('#classCategoryTable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                destroy:true,
                type: "GET",
            "ajax": "{{route('load.school.category')}}",
            "columns": [
                {
                    "data": "category"
                },
                {
                    "data": "number"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "description"
                },
                // {
                //     "data": "created_at"
                // },

                {
                    "data": "action"
                },
            ],
        });
        }
        // load school classes
        $('#classTable').DataTable({
            "processing": true,
            "serverSide": true,

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
                // {
                //     "data": "created_at"
                // },
                // {
                //     "data": "username"
                // },
                {
                    "data": "action"
                },
            ],
        });
        // load school class arm
        $('#classArmTable').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            type: "GET",
            "ajax": "{{route('load.class.arm')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    "data": "class"
                },
                {
                    "data": "arm"
                },
                // {
                //     "data": "status"
                // },
                // {
                //     "data": "created_at"
                // },
                // {
                //     "data": "fullname"
                // },
                {
                    "data": "action"
                },
            ],
            "columnDefs": [{
                    targets: [1],
                    visible: false
                },
                // {
                //     targets: [5],
                //     className: "align-right"
                // }
            ],
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
        
        loadSubject(cls = null)
        // load school class arm
        function loadSubject(cls = null) { //cls class
            $('#classArmSubjectTable').DataTable({
                "processing": true,
                "serverSide": true,

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
                    // {
                    //     "data": "status"
                    // },
                    // {
                    //     "data": "created_at"
                    // },

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
                                '<tr class="group"><td colspan="5"><b>' + group + '</b></td></tr>'
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

        $(document).on('click', '.updateClassArmBtn', function() {
            let pid = $(this).attr('pid');
            submitFormAjax('editClassArmFrom' + pid, 'id' + pid, "{{route('update.class.arm')}}");
        });

        $(document).on('click', '.deleteCategory', async function() {
            let pid = $(this).attr('pid');
            if(confirm('are you sure, you want to delete this category ?')){
                let param = {
                    pid:pid,
                    _token: "{{csrf_token()}}"
                }
               let  s = await postDataAjax(param , "{{route('delete.category')}}");
               if(s.status == 1){
                loadCategory(0)
               }
            }
        });

        $(document).on('click', '.deleleteClass', async function() {
            let pid = $(this).attr('pid');
            if(confirm('are you sure, you want to delete this class ?')){
                let param = {
                    pid:pid,
                    _token: "{{csrf_token()}}"
                }
               let  s = await postDataAjax(param , "{{route('delete.class')}}");
               if(s.status == 1){
                loadCategory(0)
               }
            }
        });
        
        $(document).on('click', '.deleleteClassArm', async function() {
            let pid = $(this).attr('pid');
            if(confirm('are you sure, you want to delete this class arm ?')){
                let param = {
                    pid:pid,
                    _token: "{{csrf_token()}}"
                }
               let  s = await postDataAjax(param , "{{route('delete.class.arm')}}");
               if(s.status == 1){
                loadCategory(0)
               }
            }
        });




        // create school class arm


    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->