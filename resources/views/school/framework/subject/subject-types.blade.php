@extends('layout.mainlayout')
@section('title','School Subject')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Subject  Types</h5>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSubjectTypeModal">
                    Create Subject Type
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="SubjectTypeTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Subject Type</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th width="5%">Action</th>
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
                {
                    "data": "description"
                },

                {
                    "data": "created_at"
                },
                {
                    "data": "action"
                },
            ],
        });
        

        
    });
</script>

@endsection