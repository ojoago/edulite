@extends('layout.mainlayout')
@section('title','lite')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Terms</h5>
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
                    New Term
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display table-bordered table-striped table-hover mt-3 cardTable" id="term-dataTable">
                    <thead>
                        <tr>
                            <!-- <th>SN</th> -->
                            <th>Term</th>
                            <th>Description</th>
                            <th>Date</th>
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

<!-- create school term modal  -->
<div class="modal fade" id="createTermModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Term</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createTermForm">
                    @csrf
                    <input type="text" name="term" autocomplete="off" class="form-control" placeholder="lite term e.g first term" required>
                    <p class="text-danger term_error"></p>
                    <textarea type="text" name="description" autocomplete="off" class="form-control" placeholder="lite term description"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createTermBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- set active active Modal -->
<div class="modal fade" id="setActiveTermModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Active active</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="setActiveTermForm">
                    @csrf
                    <select class="form-control select2-container" style="width: 100%;" id="sessionSelect2" name="active_session">
                    </select>
                    <p class="text-danger active_session_error"></p>
                    <select class="form-control select2-container" style="width: 100%;" id="setTermSelect2" name="active_term">
                    </select>
                    <p class="text-danger active_term_error"></p>
                    <label for="">Term Begin</label>
                    <input type="date" name="term_begin" autocomplete="off" class="form-control" placeholder="lite term e.g first term" required>
                    <p class="text-danger term_begin_error"></p>
                    <label for="">Term End</label>
                    <input type="date" name="term_end" autocomplete="off" class="form-control" placeholder="lite term e.g first term" required>
                    <p class="text-danger term_end_error"></p>
                    <textarea type="text" name="note" autocomplete="off" class="form-control" placeholder="lite term description"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="setActiveTermBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- End Basic Modal-->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // validate signup form on keyup and submit
        $('#createTermBtn').click(function() {
            submitFormAjax('createTermForm', 'createTermBtn', "{{route('school.term')}}");
            $('#' + formId)[0].reset();
        });
        $(document).on('click', '.createTermBtn', function() {
            let pid = $(this).attr('pid');
            let formId = 'termForm' + pid;
            let btnId = 'id' + pid;
            submitFormAjax(formId, btnId, "{{route('school.term')}}");
            $('#' + formId)[0].reset();
        })
        // load school session
        $('#term-dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            "ajax": "{{route('school.list.term')}}",
            "columns": [{
                    "data": "term"
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
        $('#active-term-table').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
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

        // session dropdown 
        multiSelect2('#sessionSelect2', 'setActiveTermModal', 'session', 'Select Session');
        multiSelect2('#setTermSelect2', 'setActiveTermModal', 'term', 'Select Term');

        // term dropdown 
        // set active session 
        $('#setActiveTermBtn').click(function() {
            submitFormAjax('setActiveTermForm', 'setActiveTermBtn', "{{route('school.term.active')}}");
            $('#' + formId)[0].reset();
        });
    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->