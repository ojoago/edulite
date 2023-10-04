@extends('layout.mainlayout')
@section('title','Notifications')
@section('content')
<section class="section d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Notifications </h5>

                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="notificationTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Message</th>
                            <th>When (Time)</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
</section>

<script>
    $(document).ready(function() {
        $('#notificationTable').DataTable({
            "processing": true,
            "serverSide": true,

            responsive: true,
            destroy: true,
            "ajax": "{{route('load.all.my.notification')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    // orderable: false,
                    // searchable: false
                },
                {
                    "data": "message"
                },
                // {
                //     "data": "type"
                // },
              

                {
                    "data": "created_at"
                },
                
            ],
            
        });
    })
</script>
@endsection