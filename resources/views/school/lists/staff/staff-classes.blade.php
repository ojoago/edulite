@extends('layout.mainlayout')
@section('title','School Staff Classes')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Staff Classes <button class="btn-small btn btn-primary" data-bs-target="#cloneClassModal" data-bs-toggle="modal">Clone</button></h5>
        <div class="card-body shadow p-2">
            <div class="row p-3">
                <div class="col-md-4">
                    <label for="session" class="form-label">Session</label>
                    <select type="text" name="session" class="form-control" id="formSubjectSessionSelect2">
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="term" class="form-label">Term</label>
                    <select type="text" name="term" class="form-control" id="formSubjectTermSelect2">

                    </select>
                </div>
            </div>
            <table class="table table-hover table-responsive table-striped table-bordered mt-2 cardTable" id="staffClassesdataTable">
                <thead>
                    <tr>
                        <th width="5%">S/N</th>
                        <th>Names</th>
                        <th>Arms</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Date</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>
<div class="modal fade" id="cloneClassModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Re-assign previus term classes to teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="cloneClassForm">
                    @csrf
                    <select class="form-control select2-container" style="width: 100%;" id="cloneClassSessionSelect2" name="session_pid">
                    </select>
                    <p class="text-danger session_error"></p>
                    <select class="form-control select2-container" style="width: 100%;" id="cloneClassTermSelect2" name="term_pid">
                    </select>
                    <p class="text-danger term_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="cloneClassBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        let session = null;
        let term = null;
        FormMultiSelect2('#formSubjectTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#formSubjectSessionSelect2', 'session', 'Select Session', session)
        multiSelect2('#cloneClassTermSelect2', 'cloneClassModal', 'term', 'Select Term');
        multiSelect2('#cloneClassSessionSelect2', 'cloneClassModal', 'session', 'Select Session');
        $('#cloneClassBtn').click(function() {
            submitFormAjax('cloneClassForm', 'createClassBtn', "{{route('reassign.staff.class')}}");
        });
        $('#formSubjectSessionSelect2').change(function() {
            let session = $(this).val();
            let term = $('#formSubjectTermSelect2').val();
            loadAllStaffClasses(session, term)
        });

        $('#formSubjectTermSelect2').change(function() {
            let term = $(this).val()
            let session = $('#formSubjectSessionSelect2').val();
            loadAllStaffClasses(session, term)
        });
        loadAllStaffClasses()

        function loadAllStaffClasses(session = null, term = null) {
            $('#staffClassesdataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.all.staff.classes')}}",
                    data: {
                        session: session,
                        term: term,
                        _token: "{{csrf_token()}}",
                    },
                    type: "post",
                },
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
                        "data": "arm"
                    },
                    {
                        "data": "session"
                    },
                    {
                        "data": "term"
                    },
                    {
                        "data": "date"
                    },

                ],
            });
        }

    });
</script>
@endsection