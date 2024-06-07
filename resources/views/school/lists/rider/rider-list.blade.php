@extends('layout.mainlayout')
@section('title','Rider Lists')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Rider List</h5>
        <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="riderDataTable">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Names</th>
                    <th>Phone Number</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Number Of Student</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#riderDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            responsive: true,
            "ajax": "{{route('load.rider.list')}}",
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
                    "data": "address"
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