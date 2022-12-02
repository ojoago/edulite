@extends('layout.mainlayout')
@section('title','Payment Records')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Payment Records</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="completePaymentTab" data-bs-toggle="tab" data-bs-target="#completePayment" type="button" role="tab">Complete Payment</button>
            </li>

            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="paymentHistoryTab" data-bs-toggle="tab" data-bs-target="#paymentHistory" type="button" role="tab">Payment History</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="incompletePaymentTab" data-bs-toggle="tab" data-bs-target="#incompletePayment" type="button" role="tab">Incomplete Payment</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">

            <div class="tab-pane show active fade" id="completePayment" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <div class="row">
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
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="completePaymentTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Reg No.</th>
                            <th>Names</th>
                            <th>Invoice No.</th>
                            <th align="right">{!!NAIRA_UNIT!!} Total</th>
                            <th>Date</th>
                            <!-- <th width="5%">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="paymentHistory" role="tabpanel">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#acceptPaymentModal">
                    Pay Invoice(s)
                </button>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#payDirectModal">
                    Pay Fee(s)
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="paymentHistoryTable">
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

            <div class="tab-pane fade" id="incompletePayment" role="tabpanel" aria-labelledby="class-arm-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassArmModal">
                    Event
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="incompletePaymentTable">
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
<!-- create school category modal  -->
<div class="modal fade" id="createFeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Fee Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createFeeForm">
                    @csrf
                    <input type="text" name="fee_name" class="form-control form-control-sm" placeholder="example school fee" required>
                    <p class="text-danger fee_name_error"></p>
                    <textarea type="text" name="fee_description" class="form-control form-control-sm" placeholder="fee description" required></textarea>
                    <p class="text-danger fee_description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createFeeBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#completePaymentTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            // destroy: true,
            type: "GET",
            "ajax": "{{route('load.paid.invoice')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    "data": "reg_number"
                },
                {
                    "data": "fullname"
                },

                {
                    "data": "invoice_number"
                },
                {
                    "data": "total",
                },
                {
                    "data": "date",
                },
                // {
                //     "data": "action",
                // },
            ],
        });
        $('#termFeeSelect2').change(function() {
            let term = $(this).val();
            let session = $('#sessionFeeSelect2').val();
            if (term != null && session != null) {
                loadFeeAmount(term, session);
            }
        })
        loadFeeAmount()
        $('#itemFeeAmount').click(function() {
            loadFeeAmount()
        })

        function loadFeeAmount(term = null, session = null) {
            $('#paymentHistoryTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('load.fee.amount')}}",
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
                        "data": "model",
                    },
                    {
                        "data": "type",
                    },
                    {
                        "data": "condition",
                    },
                    {
                        "data": "action",
                    },

                ],
            });
        }

        $('#itemConfig').click(function() {
            loadFeeConfig()
        })

        function loadFeeConfig() {
            $('#incompletePaymentTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                type: "GET",
                "ajax": "{{route('load.fee.config')}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },

                    {
                        "data": "fee_name"
                    },
                    {
                        "data": "category",
                    },
                    {
                        "data": "model",
                    },
                    {
                        "data": "type",
                    },
                    {
                        "data": "condition",
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
        $('#createFeeBtn').click(function() {
            submitFormAjax('createFeeForm', 'createFeeBtn', "{{route('create.fee.name')}}");
        });
        // update fee item 
        $(document).on('click', '.createFeeBtn', function() {
            let pid = $(this).attr('pid');
            let formId = 'feeForm' + pid;
            let btnId = 'id' + pid;
            submitFormAjax(formId, btnId, "{{route('create.fee.name')}}");
        })

        // fee amount configuartion 
        $('#addMoreArm').click(function() {
            pid++;
            $('#addMoreRow').append(`
              <div class="row classParam">
                        <div class="col-md-6">
                            <label for="arm">Class Arm</label>
                            <select name="arm[]" id="classArmSelect${pid}" class="form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger arm${pid}_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Amount</label>
                            <div class="input-group mb-1">
                                <input type="number" step="0.1" name="amount[]" id="itemAmount" placeholder="e.g 5000" class="form-control form-control-sm">
                                <i class="bi bi-x-circle-fill text-danger ml-2 mr-2 removeRowBtn pointer"></i>
                            </div>
                            <p class="text-danger amount${pid}_error"></p>
                        </div>
                    </div>
            `);
            titleDropDown(pid);
        });
        var pid = 0;
        titleDropDown(pid)

        function titleDropDown(id) {
            var id = '#classArmSelect' + id;
            multiSelect2(id, 'FeeConfigModal', 'all-class-arm', 'Select Class Arm');
        }
        $(document).on('click', '.classParam .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });

        // toogle conditional input 
        $('#category').change(function() {
            let category = Number($(this).val());

            if (category === 1) {
                $('#fixedAmount').hide(500)
                $('#addMoreArm').show(500)
                $('.classParam').show(500)
                $('#conditional').hide(500)
            }
            if (category === 2) {
                $('#fixedAmount').show(500)
                $('#addMoreArm').hide(500)
                $('.classParam').hide(500)
                $('#conditional').hide(500)
            }
            if (category === 3) { //  class based with condition
                $('#fixedAmount').hide(500)
                $('#addMoreArm').show(500)
                $('.classParam').show(500)
                $('#conditional').show(500)
            }
            if (category === 4) { // general  with condition
                $('#fixedAmount').show(500)
                $('#addMoreArm').hide(500)
                $('.classParam').hide(500)
                $('#conditional').show(500)
            }
        });
        // configure fee
        $('#feeConfigBtn').click(function() {
            submitFormAjax('feeConfigForm', 'feeConfigBtn', "{{route('configure.fee')}}");
        });

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->