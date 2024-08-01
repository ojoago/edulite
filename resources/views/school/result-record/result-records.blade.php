@extends('layout.mainlayout')
@section('title','Student Profile')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Results</h5>

        <!-- Default Tabs -->
         {{-- <div class="row m-2">
                    <div class="col-md-6">
                        <select name="session_pid" id="resultSessionSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="term_pid" id="resultTermSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                </div> --}}
                <table class="table table-hover table-striped table-bordered cardTable" width="100%" id="resultDataTable">
                    <thead>
                        <tr>

                            <th width="5%">S/N</th>
                            <th>Session</th>
                            <th>Term</th>
                            <th>Students</th>
                            <th>Fee</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th> <i class="bi bi-gear"></i>  </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
    
    </div>
</div>

<script>
    $(document).ready(function() {
        
        loadResultDataTable()
        function loadResultDataTable() {
            $('#resultDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                destroy: true,
                "ajax" :  "{{route('load.result.records')}}",
               
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },

                    {
                        "data": "session"
                    },
                    {
                        "data": "term"
                    },
                    
                    {
                        "data": "total_students",
                    },
                    {
                        "data": "fee",
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "action"
                    },
                  
                ],
                
// fee
// discount



                // drawCallback: function(settings) {
                //     var api = this.api();
                //     var rows = api.rows({
                //         page: 'current'
                //     }).nodes();
                //     var last = null;

                //     api.column(4, {
                //         page: 'current'
                //     }).data().each(function(group, i) {

                //         if (last !== group) {

                //             $(rows).eq(i).before(
                //                 '<tr class="group"><td colspan="8">' + 'GRUPO ....' + group + '</td></tr>'
                //             );

                //             last = group;
                //         }
                //     });
                // }
            });
        }



    });
</script>


@endsection