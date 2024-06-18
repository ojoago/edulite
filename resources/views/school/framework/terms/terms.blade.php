@extends('layout.mainlayout')
@section('title','Term Setup')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Term Setup</h5>
        <!-- Bordered Tabs Justified -->
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <!-- <a href="#term-tab"> -->
                <button class="nav-link w-100 active" data-bs-toggle="tab" data-bs-target="#term-tab" type="button" role="tab">Term</button>
                <!-- </a> -->
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <!-- <a href="#active-tab"> -->
                <button class="nav-link w-100" id="active-tab" data-bs-toggle="tab" data-bs-target="#set-active-tab" type="button" role="tab">Active Term</button>
                <!-- </a> -->
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <!-- <a href="#active-tab"> -->
                <button class="nav-link w-100" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab">Term Details</button>
                <!-- </a> -->
            </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="term-tab" role="tabpanel" aria-labelledby="term-tab">
                <!-- Create term -->
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createTermModal">
                    Create Term
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display table-bordered table-striped table-hover mt-3 cardTable" id="term-dataTable">
                    <thead>
                        <tr>
                            <!-- <th>SN</th> -->
                            <th>Term</th>
                            <th>Description</th>
                            {{-- <th>Date</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

            <div class=" tab-pane fade" id="set-active-tab" role="tabpanel" aria-labelledby="set-active-tab">

                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#setActiveTermModal">
                    Set Active Term
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="active-term-table">
                    <thead>
                        <tr>
                            <th>Active term</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>
            <div class=" tab-pane fade" id="detail" role="tabpanel">

                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="detailDatatable">
                    <thead>
                        <tr>
                            <!-- <th>SN</th> -->
                            <th>Session</th>
                            <th>Active term</th>
                            <th>Begin</th>
                            <th>End</th>
                            <th>Note</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

        </div><!-- End Bordered Tabs Justified -->

    </div>
</div>






<!-- End Basic Modal-->

<script>
    $(document).ready(function() {
       
        // validate signup form on keyup and submit
       
        $(document).on('click','.createTermBtn', async function(){ 
            let id = $(this).attr('pid')       
           let s = await submitFormAjax('createTermForm'+id, 'createTermBtn'+id, "{{route('create.term')}}");
        })
        // load school session
        $('#term-dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            
            responsive: true,
            "ajax": "{{route('school.list.term')}}",
            "columns": [{
                    "data": "term"
                },
                {
                    "data": "description"
                },
                // {
                //     "data": "created_at"
                // },
                {
                    "data": "action"
                },
            ],
        });
        $('#active-term-table').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            responsive: true,
            "ajax": "{{route('load.school.active.term')}}",
            "columns": [{
                    "data": "term"
                },
                {
                    "data": "date"
                }
            ],
        });

        // load active session 
        $('#detailDatatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('load.school.active.term.details')}}",
            "columns": [{
                    "data": "session"
                },
                {
                    "data": "term"
                },
                {
                    "data": "begin"
                },
                {
                    "data": "end"
                },
                {
                    "data": "note"
                },
            ],
        });

       
    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->