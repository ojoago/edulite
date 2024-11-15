@extends('layout.mainlayout')
@section('title','Parent/Guardian Lists')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Parent/Guardian List</h5>
        <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="parentDataTable">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Names</th>
                    <th>Phone Number</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Student(s)</th>
                    {{-- <th>Date</th> --}}
                    <!-- <th>Status</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

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
                // {
                //     "data": "date"
                // },
                // {
                //     "data": "status"
                // },

                {
                    "data": "action"
                },
            ],
        });

        $(document).on('click', '.toggleParentStatus', function() {
            let pid = $(this).attr('pid');
            let token = "{{csrf_token()}}"
            $('.overlay').show();
            $.ajax({
                url: "{{route('toggle.parent.status')}}",
                type: "post",
                data: {
                    pid: pid,
                    _token: token
                },
                success: function(data) {
                    alert_toast(data, 'success');
                    $('.overlay').hide();
                },
                error: function() {
                    alert_toast('Something Went Wrong', 'warning');
                    $('.overlay').hide();
                }
            });
        });
    });
</script>
@endsection