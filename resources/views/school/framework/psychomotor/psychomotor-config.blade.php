@extends('layout.mainlayout')
@section('title','Psychomotor & Affective Domain')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Psychomotor & Affective Domain</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#psychomotor" type="button" role="tab" aria-controls="home" aria-selected="true">Psychomotor</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#effectiveDomain" type="button" role="tab" aria-controls="profile" aria-selected="false">Affective</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#psychoGrade" type="button" role="tab" aria-controls="contact" aria-selected="false">Grade Key</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="psychomotor" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createPsychomotorModal">
                    Create Psychomotor
                </button>
                <table class="table table-hover table-striped" id="psychomotorDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tab-pane fade" id="effectiveDomain" role="tabpanel" aria-labelledby="profile-tab">
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createEffectiveDomainModal">
                    Create Affective
                </button>
                <table class="table table-hover table-striped" id="affectiveDomainDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="tab-pane fade" id="psychoGrade" role="tabpanel" aria-labelledby="contact-tab">
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createPyschoGradeModal">
                    Create GD
                </button>
                <table class="table table-hover table-striped" id="psychoGradeDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Grade</th>
                            <th>Score</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create psycho modal  -->
<div class="modal fade" id="createPsychomotorModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create CY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createPsychomotorForm">
                    @csrf
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="CY title">
                    <p class="text-danger title_error"></p>
                    <input type="number" name="score" class="form-control form-control-sm" placeholder="obtainable score" required>
                    <p class="text-danger score_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createPsychomotorBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Psychomotro Modal-->


<!-- effective domain  -->
<div class="modal fade" id="createEffectiveDomainModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create EF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createEffectiveDomainForm">
                    @csrf
                    <input type="text" name="title" class="form-control form-control-sm" placeholder="CY title">
                    <p class="text-danger title_error"></p>
                    <input type="number" name="score" class="form-control form-control-sm" placeholder="obtainable score" required>
                    <p class="text-danger score_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createEffectiveDomainBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End effective domain Modal-->
<!-- psycho grade modal  -->
<div class="modal fade" id="createPyschoGradeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create GD</h5>
                <div class="text-center">
                    <button id="addMore" type="button" class="btn btn-danger btn-sm btn-small m-3">Add More Row</button><br>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createPyschoGradeForm">
                    @csrf
                    <i id="moreRows"></i>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="title">Grade</label>
                            <input type="text" name="grade[]" class="form-control form-control-sm" placeholder="CY grade">
                            <p class="text-danger grade_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="score">Score</label>
                            <div class="input-group mb-3">
                                <input type="number" name="score[]" class="form-control form-control-sm" placeholder="obtainable score" required>
                                <p class="text-danger score_error"></p>
                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createPyschoGradeBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End psycho grade Modal-->


<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // psychomotor-dataTable
        $('#psychomotorDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            // ->rawColumns(['data', 'action'])
            responsive: true,
            "ajax": "{{route('load.psychomotor')}}",
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "max_score"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "username"
                },
                // {
                //     "data": "action"
                // },
            ],
        });
        // psychomotor-dataTable
        $('#affectiveDomainDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            // ->rawColumns(['data', 'action'])
            responsive: true,
            "ajax": "{{route('load.effective-domain')}}",
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "max_score"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "username"
                },
                // {
                //     "data": "action"
                // },
            ],
        });
        // psychomotor-dataTable
        $('#psychoGradeDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            // ->rawColumns(['data', 'action'])
            responsive: true,
            "ajax": "{{route('load.psycho-grade')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    // orderable: false,
                    // searchable: false
                },
                {
                    "data": "grade"
                },
                {
                    "data": "score"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "username"
                },

            ],
        });

        // create psychomotor  
        $('#createPsychomotorBtn').click(function(e) {
            e.preventDefault()
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.psychomotor')}}",
                type: "POST",
                data: new FormData($('#createPsychomotorForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createPsychomotorForm').find('p.text-danger').text('');
                    $('#createPsychomotorBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
                    $('#createPsychomotorBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly, Note (Specail Character is not allowed)', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 2) {
                        alert_toast(data.message, 'warning');
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createPsychomotorForm')[0].reset();
                    }
                },
                error: function(data) {
                    $('#createPsychomotorBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
        // create psychomotor  
        $('#createEffectiveDomainBtn').click(function(e) {
            e.preventDefault()
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.effective.domain')}}",
                type: "POST",
                data: new FormData($('#createEffectiveDomainForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createEffectiveDomainForm').find('p.text-danger').text('');
                    $('#createEffectiveDomainBtn').prop('disabled', true);
                },
                success: function(data) {
                    // console.log(data);
                    $('#createEffectiveDomainBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly Note (Specail Character is not allowed)', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 2) {
                        alert_toast(data.message, 'warning');
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createEffectiveDomainForm')[0].reset();
                    }
                },
                error: function(data) {
                    $('#createEffectiveDomainBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });

        // add more title 
        $('#addMore').click(function() {
            $('#moreRows').prepend(
                `
                 <div class="row addedRow">
                        <div class="col-md-6">
                            <label for="title">Grade</label>
                            <input type="text" name="grade[]" class="form-control form-control-sm" placeholder="CY grade">
                            <p class="text-danger grade_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="score">Score</label>
                           <div class="input-group mb-3">
                            <input type="number" name="score[]" class="form-control form-control-sm" placeholder="obtainable score" required>
                            <i class="bi bi-x-circle-fill text-danger m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger score_error"></p>
                        </div>
                    </div>
                `
            );
            // init select2 again 
        });

        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });
        // create psycho grade  
        $('#createPyschoGradeBtn').click(function(e) {
            e.preventDefault()
            $('.overlay').show();
            $.ajax({
                url: "{{route('create.psycho.grade')}}",
                type: "POST",
                data: new FormData($('#createPyschoGradeForm')[0]),
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#createPyschoGradeForm').find('p.text-danger').text('');
                    $('#createPyschoGradeBtn').prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#createPyschoGradeBtn').prop('disabled', false);
                    $('.overlay').hide();
                    if (data.status === 0) {
                        alert_toast('Fill in form correctly Note (Specail Character is not allowed)', 'warning');
                        $.each(data.error, function(prefix, val) {
                            $('.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.status === 2) {
                        alert_toast(data.message, 'warning');
                    } else {
                        alert_toast(data.message, 'success');
                        $('#createPyschoGradeForm')[0].reset();
                    }
                },
                error: function(data) {
                    $('#createPyschoGradeBtn').prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });
    });
</script>
@endsection