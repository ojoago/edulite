@extends('layout.mainlayout')
@section('title','School Subject')
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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="SubjectTypeTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Subject Type</th>
                            {{-- <th>Date</th> --}}
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
                        <button type="button" class="btn btn-primary mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#createTypeSubjectModal">
                            Create Subject
                        </button>
                        {{-- <button type="button" class="btn btn-primary mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#dupSubjectTypeModal">
                            Copy Subject Type
                        </button> --}}
                    </div>
                    <div class="col-md-6">
                        <select name="class_pid" id="categorySubjectSelect2" class="form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="SubjectTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Category</th>
                            <th>Subject Type</th>
                            <th>Subject</th>
                            <th>Status</th>
                            {{-- <th>Date</th> --}}
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
<!-- subject modal  -->
<div class="modal fade" id="createTypeSubjectModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="createGroupSubjectForm">
                    @csrf
                    <div class="input-group">
                        <select name="category_pid[]" multiple style="width:100%" class="form-control form-control-sm createSubjectCategorySelect2" id="subjectCategorySelect2">
                        </select>
                    <i class="bi bi-x-circle-fill text-danger hidden-item "></i>
                    </div>
                    <p class="text-danger category_pid_error"></p>
                    <select name="subject_type_pid" style="width:100%" class="form-control form-control-sm createSubjectSubjectTypeSelect2" id="subjectSubjectTypeSelect2">
                    </select>
                    <p class="text-danger subject_type_pid_error"></p>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="subject[]" id="subject" class="form-control form-control-sm" placeholder="subject name" required>
                            <i class="bi bi-x-circle-fill text-danger hidden-item "></i>
                        </div>
                        <input type="hidden" name="pid" id="pid">
                        <p class="text-danger subject.0_error"></p>
                    </div>
                    <div id="moreSubject"></div>
                    {{-- <textarea type="text" name="description" id="description" class="form-control form-control-sm" placeholder="description" required></textarea>
                    <p class="text-danger description_error"></p> --}}
                    </form>
                <div class="text-center">
                    <button id="addMoreSubject" type="button" class="btn btn-info btn-sm btn-sm m-1">Add More</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createGroupSubjectBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- create school term modal  -->

<script>
    $(document).ready(function() {

        multiSelect2('#subjectSubjectTypeSelect2', 'createTypeSubjectModal', 'subject-type', 'Select Subject Type');
        multiSelect2('#subjectCategorySelect2', 'createTypeSubjectModal', 'category', 'Select Category');
        // load school subject type
        $('#SubjectTypeTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            responsive: true,
            type: "GET",
            "ajax": "{{route('load.school.subject.type')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    // orderable: false,
                    // searchable: false
                },
                {
                    "data": "subject_type"
                },

                // {
                //     "data": "description"
                // },

                // {
                //     "data": "created_at"
                // },
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
                // rowReorder: {
                //     selector: 'td:nth-child(2)'
                // },
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
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                     {
                        "data": "category"
                    },
                     {
                        "data": "subject_type"
                    },
                    {
                        "data": "subject"
                    },
                    // {
                    //     "data": "description"
                    // },
                    {
                        "data": "status"
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
        // load subject for a particular category on change  
        $('#categorySubjectSelect2').change(function() {
            var pid = $(this).val();
            if (pid != null) {
                loadSubjectTable(pid)
            }
        })
        // load dropdown on 
        

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


         // create subject 
        $('#createGroupSubjectBtn').click(async function() {
            
            let s = await submitFormAjax('createGroupSubjectForm', 'createGroupSubjectBtn', "{{route('create.group.subject')}}");
            if (s.status === 1) {
                loadSubjectTable()
            }
        });

        

    });
</script>

@endsection