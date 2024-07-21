@extends('layout.mainlayout')
@section('title','Student List')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Lists</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="activeStudent-tab" data-bs-toggle="tab" data-bs-target="#activeStudent" type="button" role="tab" aria-controls="activeStudent" aria-selected="true">Active</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="inActiveStudent-tab" data-bs-toggle="tab" data-bs-target="#inActiveStudent" type="button" role="tab" aria-controls="nonActiveStudent" aria-selected="false">Non-active</button>
            </li>
            <!-- <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="graduatedStudent-tab" data-bs-toggle="tab" data-bs-target="#graduatedStudent" type="button" role="tab">Ex Student</button>
            </li> -->
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="activeStudent" role="tabpanel" aria-labelledby="activeStudent-tab">
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="activeStudentDataTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Names</th>
                            <th>Reg No.</th>
                            <th>Current Class</th>
                            <th>Date of Birth</th>
                            <th>Parent/Guardian</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="inActiveStudent" role="tabpanel" aria-labelledby="nonActiveStudent-tab">
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="inActiveStudentDataTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Names</th>
                            <th>Reg No.</th>
                            <th>Current Class</th>
                            <th>Date of Birth</th>
                            <th>Parent/Guardian</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="graduatedStudent" role="tabpanel" aria-labelledby="graduatedStudent-tab">
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" width="100%" id="exStudentDataTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Names</th>
                            <th>Reg No.</th>
                            <th>Current Class</th>
                            <th>Date of Birth</th>
                            <th>Parent/Guardian</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>


<script>
    $(document).ready(function() {

        $('#activeStudentDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            
            responsive: true,
            "ajax": "{{route('load.staff.active.student.list')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    // orderable: false,
                    // searchable: false
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "reg_number"
                },
                {
                    "data": "arm"
                },

                {
                    "data": "dob"
                },
                {
                    "data": "parent"
                },


                {
                    "data": "action"
                },
            ],
            "columnDefs": [{
                "visible": false,
                "targets": 3
            }],
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(3, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="6"><b>' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });
        $('#inActiveStudent-tab').click(function() {
            $('#inActiveStudentDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                
                responsive: true,
                destroy: true,
                "ajax": "{{route('load.in.active.student')}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "fullname"
                    },
                    {
                        "data": "reg_number"
                    },
                    {
                        "data": "arm"
                    },

                    {
                        "data": "created_at"
                    },
                    {
                        "data": "parent"
                    },


                    {
                        "data": "action"
                    },
                ],
                "columnDefs": [{
                    "visible": false,
                    "targets": 3
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(3, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="6">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        });
        $('#graduatedStudent-tab').click(function() {
            $('#exStudentDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                
                responsive: true,
                destroy: true,
                "ajax": "{{route('load.ex.student')}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        "data": "fullname"
                    },
                    {
                        "data": "reg_number"
                    },
                    {
                        "data": "arm"
                    },

                    {
                        "data": "created_at"
                    },
                    {
                        "data": "parent"
                    },


                    {
                        "data": "action"
                    },
                ],
            });
        });


    });
</script>
@endsection