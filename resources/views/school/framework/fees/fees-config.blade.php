@extends('layout.mainlayout')
@section('title','Fee Config')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Fees</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab">Account Setup</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab">Fee Items</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="itemFeeAmount" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab">Item Fee Amount</button>
            </li>
            
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="itemConfig" data-bs-toggle="tab" data-bs-target="#class-arm" type="button" role="tab">Item Fee Config</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#accountSetupModal">
                    Create Account
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="feeAccountTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Account Bank</th>
                            <th>status</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade " id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#createFeeModal">
                    Create Fee Name
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="feeNameTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>status</th>
                            <th>Date</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <!-- <div class="row"> -->
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#FeeConfigModal">
                        Fee Config
                    </button>

                </div>

                <!-- </div> -->
                <!--  -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="feeAmountTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Class</th>
                            <th>Fee Name</th>
                            <th align="right">{!!NAIRA_UNIT!!} Amount</th>
                            <!-- <th>Term</th>
                            <th>Session</th> -->
                            <th>Model</th>
                            <th>Type</th>
                            <th>Condition</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            
            <div class="tab-pane fade" id="class-arm" role="tabpanel" aria-labelledby="class-arm-tab">
              
                <!-- <div class="table-responsive mt-3"> -->
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
<!-- create school category modal  -->
<div class="modal fade" id="accountSetupModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="bi bi-bank"></i>  Fee Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createFeeForm">
                    @csrf
                    <label for="account_number">Account Number</label>
                    <input type="text" name="account_number" class="form-control form-control-sm" placeholder="example school fee" required>
                    <p class="text-danger account_number_error"></p>

                    <!-- <input type="text" name="account_number" class="form-control form-control-sm" placeholder="example school fee" required>
                    <p class="text-danger account_number_error"></p> -->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createFeeBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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


<div class="modal fade" id="FeeConfigModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fee Configuration </h5>

                <div class="float-end">
                    <button id="addMoreArm" type="button" class="btn btn-danger btn-sm btn-sm mb-1 text-center">Add More Row</button><br>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger text-center">for {{activeTermName()}} {{activeSessionName()}}</p>
                <form method="post" class="" id="feeConfigForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <select name="fee_item_pid" id="feeItem" class="form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger fee_item_pid_error"></p>
                        </div>
                        <div class="col-md-3">
                            <select name="category" id="category" class="form-control form-control-sm">
                                <option disabled selected>Select Category</option>
                                <option value="1">Class base</option>
                                <option value="2">General</option>
                                <option value="3">Class Conditional</option>
                                <option value="4">General Conditional</option>
                            </select>
                            <p class="text-danger category_error"></p>
                        </div>
                        <div class="col-md-2">
                            <select name="type" id="feeType" class="form-control form-control-sm">
                                <option disabled selected>Select Type</option>
                                <option value="1">Compulsary</option>
                                <option value="2">On-demand</option>
                                <!-- <option value="3">Optional</option> -->
                            </select>
                            <p class="text-danger type_error"></p>
                        </div>
                        <div class="col-md-3">
                            <select name="payment_model" id="payment_model" class="form-control form-control-sm">
                                <option disabled selected>Select Model</option>
                                <option value="1">Termly</option>
                                <option value="2">Per Session</option>
                                <option value="3">One Time</option>
                                <option value="4">On-Demand</option>
                            </select>
                            <p class="text-danger payment_model_error"></p>
                        </div>
                    </div>
                    <fieldset id="conditional" style="display:none;">
                        <div class="row">
                            <div class=" col-md-6">
                                <label for="">Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="gender" id="gender" value="2" class="form-check-input">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Female
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="gender" id="gender" value="1" class="form-check-input">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="gender" id="gender" value="3" class="form-check-input">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Other
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Religion</label><br>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="religion" id="religion" value="2" class="form-check-input">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Christian
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="religion" id="religion" value="1" class="form-check-input">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Muslim
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="religion" id="religion" value="3" class="form-check-input">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Other
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- display this if general fixed is selected  -->
                    <div class="row" id="fixedAmount" style="display:none;">
                        <div class="col-md-12">
                            <label for="number">Amount</label>
                            <div class="input-group mb-1">
                                <input type="number" step="0.1" name="fixed_amount" id="itemAmount" placeholder="e.g 5000" class="form-control form-control-sm">
                            </div>
                            <p class="text-danger fixed_amount_error"></p>
                        </div>
                    </div>
                    <div class="row classParam">
                        <div class="col-md-6">
                            <label>Class Arm</label>
                            <select name="arm[]" id="classArmSelect0" class="form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger arm0_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Amount</label>
                            <div class="input-group mb-1">
                                <input type="number" step="0.1" name="amount[]" id="itemAmount" placeholder="e.g 5000" class="form-control form-control-sm">
                                <i class="bi bi-x-circle-fill hidden-item ml-2 mr-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger amount0_error"></p>
                        </div>
                    </div>
                    <div id="addMoreRow"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="feeConfigBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->

<script>
    $(document).ready(function() {

        // generate all invoice 
        $('#feeNameTable').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            // destroy: true,
            type: "GET",
            "ajax": "{{route('load.fee.items')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    "data": "fee_name"
                },
                {
                    "data": "fee_description"
                },
                {
                    "data": "status"
                },
                {
                    "data": "date",
                },
                {
                    "data": "action",
                },

            ],
        });
        $('#termFeeSelect2').change(function() {
            let term = $(this).val();
            let session = $('#sessionFeeSelect2').val();
            if (term != null && session != null) {
                loadInvoice(term, session);
            }
        })

        $('#itemFeeAmount').click(function() {
            loadFeeAmount()
        })

        function loadFeeAmount(term = null, session = null) {
            $('#feeAmountTable').DataTable({
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
                    // {
                    //     "data": "term"
                    // },
                    // {
                    //     "data": "session"
                    // },
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
            $('#FeeItemTable').DataTable({
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

        $('#feeType').change(function() {
            let type = $(this).val();
            if (type == 2) {
                $('#payment_model').val(4).trigger('change').attr('readonly', true);
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