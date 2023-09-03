@extends('layout.mainlayout')
@section('title','Fee Config')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Fees</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="generateInvoiceTab" data-bs-toggle="tab" data-bs-target="#generatedInvoice" type="button" role="tab">School Invoice</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid" type="button" role="tab">Paid Invocie</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="unpad-tab" data-bs-toggle="tab" data-bs-target="#unpaid" type="button" role="tab">Un Paid Invoice</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="">

            <div class="tab-pane fade show active" id="generatedInvoice" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary mb-3 btn-sm" id="generateInvoice">
                            Generate Invoice
                        </button>
                        <!-- <button type="button" class="btn btn-primary mb-3 btn-sm" id="reGenerateInvoice">
                            ReGenerate Invoice
                        </button> -->
                    </div>
                    <div class="col-md-4">
                        <select name="session_pid" id="sessionFeeSelect2" class="form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="term_pid" id="termFeeSelect2" class="form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <!--  -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="generatedInvoiceTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Class</th>
                            <th>Reg No.</th>
                            <th>Names</th>
                            <th>Fee</th>
                            <th align="right">{!!NAIRA_UNIT!!} Amount</th>
                            <th>Term</th>
                            <th>Session</th>
                            <th>Type</th>
                            <th>Date</th>
                            <!-- <th width="5%">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <td colspan="5"></td>
                        <td></td>
                    </tfoot>
                </table>
            </div>
            <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="FeeItemTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Fee Name</th>
                            <th>Category</th>
                            <th>Model</th>
                            <th>Type</th>
                            <th>Condition</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="unpaid" role="tabpanel" aria-labelledby="unpaid-tab">
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="FeeItemTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Fee Name</th>
                            <th>Category</th>
                            <th>Model</th>
                            <th>Type</th>
                            <th>Condition</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- modals  -->

<script>
    $(document).ready(function() {

        // generate all invoice 
        $('#generateInvoice').click(function() {
            if (confirm("Are you sure you want to generate invoice for {{activeTermName()}} {{activeSessionName()}}")) {
                $.ajax({
                    url: "{{route('generate.all.invoice')}}", // generate invoice for active term
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    beforeSend: function() {
                        $('.overlay').show();
                        $(this).prop('disabled', true);
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status === 1) {
                            alert_toast(data.message, 'success');
                        } else {
                            alert_toast(data.message, 'warning');
                        }
                        $(this).prop('disabled', false);
                        $('.overlay').hide();
                    },
                    error: function(data) {
                        $(this).prop('disabled', false);
                        $('.overlay').hide();
                        alert_toast('Something Went Wrong', 'error');
                    }
                });
            }
        });
        // regenerate all invoice 
        $('#reGenerateInvoice').click(function() {
            $.ajax({
                url: "{{route('re.generate.all.invoice')}}",
                type: "post",
                data: {
                    _token: "{{csrf_token()}}",
                },
                beforeSend: function() {
                    $('.overlay').show();
                    $(this).prop('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $(this).prop('disabled', false);
                    $('.overlay').hide();
                },
                error: function(data) {
                    $(this).prop('disabled', false);
                    $('.overlay').hide();
                    alert_toast('Something Went Wrong', 'error');
                }
            });
        });



        loadInvoice()
        $('#generateInvoiceTab').click(function() {
            loadInvoice()
        })

        function loadInvoice(term = null, session = null) {
            $('#generatedInvoiceTable').DataTable({
                "processing": true,
                "serverSide": true,

                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('load.student.invoice')}}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: session,
                        term_pid: term,
                        // arm_pid: arm,
                    }
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "arm"
                    },
                    {
                        "data": "reg_number"
                    },
                    {
                        "data": "fullname"
                    },

                    {
                        "data": "fee_name"
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "term"
                    },
                    {
                        "data": "session"
                    },

                    {
                        "data": "type",
                    },

                    {
                        "data": "date",
                    },

                ],

                "columnDefs": [{
                        targets: [1],
                        visible: false
                    },
                    {
                        targets: [5],
                        className: "align-right"
                    }
                ],
                "footerCallback": function() {
                    var api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // computing column Total of the complete result 

                    var price = api
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column(0).footer()).html('<b>Total');
                    $(api.column(5).footer()).html('<b>' + numberFormat(price));
                },
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(1, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="9"><b>' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
        }



        // load dropdown on 
        FormMultiSelect2('#termFeeSelect2', 'term', 'Select Term');
        FormMultiSelect2('#sessionFeeSelect2', 'session', 'Select Session');

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->