@extends('layout.mainlayout')
@section('title','Fee Config')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Fees</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill " role="presentation">
                <button class="nav-link w-100 active" id="unPaidInvoiceTab" data-bs-toggle="tab" data-bs-target="#unPaidInvoice" type="button" role="tab">Un-Paid Invoice</button>
            </li>
            <li class="nav-item flex-fill " role="presentation">
                <button class="nav-link w-100" id="paidInvoiceTab" data-bs-toggle="tab" data-bs-target="#paidInvoice" type="button" role="tab">Paid Invoice</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="unPaidInvoice" role="tabpanel">
                <!-- <div class="table-responsive mt-3"> -->
                <div class="row">
                    <div class="col-md-4">
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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="unPaidInvoiceTable">
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
                </table>
            </div>
            <div class="tab-pane fade " id="paidInvoice" role="tabpanel">
                <!-- <div class="table-responsive mt-3"> -->
                <div class="row">
                    <div class="col-md-4">
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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="paidInvoiceTable">
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
                </table>
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- modals  -->

<!-- create school category modal  -->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // generate all invoice 

        $('#termFeeSelect2').change(function() {
            let term = $(this).val();
            let session = $('#sessionFeeSelect2').val();
            if (term != null && session != null) {
                unPaidInvoice(term, session);
            }
        })

        unPaidInvoice()
        $('#unPaidInvoiceTab').click(function() {
            unPaidInvoice()
        })

        function unPaidInvoice(term = null, session = null) {
            $('#unPaidInvoiceTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
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
            });
        }
        $('#paidInvoiceTab').click(function() {
            paidInvoice()
        })

        function paidInvoice(term = null, session = null) {
            $('#paidInvoiceTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('load.student.paid.invoice')}}",
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
            });
        }


        // load dropdown on 
        FormMultiSelect2('#termFeeSelect2', 'term', 'Select Term');
        FormMultiSelect2('#sessionFeeSelect2', 'session', 'Select Session');
        multiSelect2('#feeItem', 'FeeConfigModal', 'fee-items', 'Select Fee');

        // create fee name 

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->