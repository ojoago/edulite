@extends('layout.mainlayout')
@section('title','School Staff Classes')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Staff Classes</h5>
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
            <table class="table table-hover table-responsive table-striped table-bordered mt-2" id="staffClassesdataTable">
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

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        let session = null;
        let term = null;
        FormMultiSelect2('#formSubjectTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#formSubjectSessionSelect2', 'session', 'Select Session', session)
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