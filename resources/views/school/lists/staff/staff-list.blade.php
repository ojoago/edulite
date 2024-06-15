@extends('layout.mainlayout')
@section('title','School Staff List')
@section('content')
<div class="card">
    <div class="card-body">
            <h5 class="card-title mr-4">Staff List <a href="{{route('create.staff.form')}}"> <button class="btn btn-primary ml-3 btn-sm">New Staff</button> </a></h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="active-staff-tab" data-bs-toggle="tab" data-bs-target="#active-staff" type="button" role="tab" aria-controls="active" aria-selected="true">Active Staff</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="in-active-staff-tab" data-bs-toggle="tab" data-bs-target="#in-active-staff" type="button" role="tab" aria-controls="in-active" aria-selected="false">In-Active Staff</button>
            </li>
            <!-- <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="admin-user-tab" data-bs-toggle="tab" data-bs-target="#admin-user" type="button" role="tab" aria-controls="admin" aria-selected="false">Admin User</button>
            </li> -->
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="active-staff" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="list-active-staff-dataTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Names</th>
                            <th>Username</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Primary Role</th>
                            {{-- <th>Date</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="in-active-staff" role="tabpanel" aria-labelledby="in-active-staff-tab">
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="disabledTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Names</th>
                            <th>Username</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Primary Role</th>
                            {{-- <th>Date</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="admin-user" role="tabpanel" aria-labelledby="admin-tab">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered cardTable" id="admin-list-dataTable">

                    </table>
                </div>
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<script>
    $(document).ready(function() {

        $('#list-active-staff-dataTable').DataTable({
            "processing": true,
            "serverSide": true,
           
            responsive: true,
            "ajax": "{{route('load.staff.list')}}",
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
                    "data": "username"
                },
                {
                    "data": "gsm"
                },

                {
                    "data": "email"
                },
                {
                    "data": "role"
                },

                // {
                //     "data": "created_at"
                // },
                {
                    "data": "action"
                },
            ],
        });
        $('#in-active-staff-tab').click(function() {
            disabledStaff()
        });

        function disabledStaff(){
                $('#disabledTable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "{{route('load.inactive.staff.list')}}",
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
                        "data": "username"
                    },
                    {
                        "data": "gsm"
                    },

                    {
                        "data": "email"
                    },
                    {
                        "data": "role"
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
        
    });

    
</script>
@endsection