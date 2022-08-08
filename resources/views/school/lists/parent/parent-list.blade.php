@extends('layout.mainlayout')
@section('title','Parent Lists')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Default Tabs Justified</h5>
        <table class="table table-hover table-responsive table-striped table-bordered" id="parentDataTable">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Names</th>
                    <th>Phone Number</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Number of Student</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#parentDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('load.school.parent.list')}}",
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
                    "data": "gsm"
                },
                {
                    "data": "username"
                },

                {
                    "data": "email"
                },
                {
                    "data": "count"
                },
                {
                    "data": "date"
                },

                {
                    "data": "action"
                },
            ],
        });
    });
</script>
@endsection