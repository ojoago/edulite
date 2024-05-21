@extends('layout.mainlayout')
@section('title','School Subject')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Subjects</h5>

        <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#createSubjectModal">
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
                            <th>Description</th>
                            <th>Status</th>
                            {{-- <th>Date</th> --}}
                            <th align="center"><i class="bi bi-tools"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

    </div>
</div>

<!-- create school term modal  -->

<!-- create school term modal  -->

<script>
    $(document).ready(function() {

        
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
                    {
                        "data": "description"
                    },
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
        

    });
</script>

@endsection