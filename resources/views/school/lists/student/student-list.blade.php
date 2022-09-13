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
                <button class="nav-link w-100" id="nonActiveStudent-tab" data-bs-toggle="tab" data-bs-target="#nonActiveStudent" type="button" role="tab" aria-controls="nonActiveStudent" aria-selected="false">Non-active</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="graduatedStudent-tab" data-bs-toggle="tab" data-bs-target="#graduatedStudent" type="button" role="tab" aria-controls="graduatedStudent" aria-selected="false">Grad</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="activeStudent" role="tabpanel" aria-labelledby="activeStudent-tab">
                <table class="table table-hover table-responsive table-striped table-bordered" id="activeStudentDataTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Names</th>
                            <th>Reg No.</th>
                            <th>Current Class</th>
                            <th>Date</th>
                            <th>Parent/Guardian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nonActiveStudent" role="tabpanel" aria-labelledby="nonActiveStudent-tab">
                Ex
            </div>
            <div class="tab-pane fade" id="graduatedStudent" role="tabpanel" aria-labelledby="graduatedStudent-tab">
                Alumni
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>


<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {

        $('#activeStudentDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.school.student.list')}}",
            "columns": [
                {
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
        $('#active-dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
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
                    "data": "role_id"
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