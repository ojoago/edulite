@extends('layout.mainlayout')
@section('title','Fee Config')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Fees</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab">Fee Items</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab">Item Fees</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="class-arm-tab" data-bs-toggle="tab" data-bs-target="#class-arm" type="button" role="tab">Event</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#createFeeModal">
                    Create Fee Name
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="feeNameTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#FeeConfigModal">
                    Fee Config
                </button>
                <!--  -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="class-arm" role="tabpanel" aria-labelledby="class-arm-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassArmModal">
                    Event
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classArmTable">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Class Arm</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Actions</th>
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
<div class="modal fade" id="FeeConfigModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fee Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createFeeForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <select name="fee_item" id="feeItem" class="form-control form-control-sm" style="width: 100%;">
                            </select>
                            <p class="text-danger fee_item_pid_error"></p>
                        </div>
                        <div class="col-md-3">
                            <select name="arm_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                <option disabled selected>Select Type</option>
                                <option value="1">General</option>
                                <option value="2">General Fixed</option>
                                <option value="3">Class base</option>
                                <option value="4">Four</option>
                                <option value="5">Five</option>
                                <option value="6">Six</option>
                                <option value="7">Seven</option>
                                <option value="8">Eight</option>
                                <option value="9">Nine</option>
                                <option value="10">Ten</option>
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                        <div class="col-md-3">
                            <select name="arm_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                <option disabled selected>Select Category</option>
                                <option value="1">Compulsary</option>
                                <option value="2">Optional</option>
                                <option value="3">Class base</option>
                                <option value="4">Four</option>
                                <option value="5">Five</option>
                                <option value="6">Six</option>
                                <option value="7">Seven</option>
                                <option value="8">Eight</option>
                                <option value="9">Nine</option>
                                <option value="10">Ten</option>
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                    </div>
                    <center>
                        prepend class name to class arm ? <input type="checkbox" name="prepend">
                        <button id="addMoreArm" type="button" class="btn btn-danger btn-sm btn-small mb-1">Add More Row</button><br>
                    </center>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="arm">Class Arm Name</label>
                            <input type="text" name="arm[]" placeholder="class arm" class="form-control form-control-sm" required>
                            <p class="text-danger arm_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Class Arm Serial Number</label>
                            <div class="input-group mb-3">
                                <select name="arm_number[]" id="classNumberSelect" class="form-control form-control-sm">
                                    <option disabled selected>Select Class Number</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="4">Four</option>
                                    <option value="5">Five</option>
                                    <option value="6">Six</option>
                                    <option value="7">Seven</option>
                                    <option value="8">Eight</option>
                                    <option value="9">Nine</option>
                                    <option value="10">Ten</option>
                                </select>
                                <i class="bi bi-x-circle-fill text-white m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger arm_number_error"></p>
                        </div>
                    </div>
                    <div id="addMoreArmRow"></div>
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

        $('#feeNameTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
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
        // add more title 

        // load dropdown on 

        // filter class subject 
        FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        multiSelect2('#feeItem', 'FeeConfigModal', 'fee-items', 'Select Fee');

        // create fee
        $('#createFeeBtn').click(function() {
            submitFormAjax('createFeeForm', 'createFeeBtn', "{{route('create.fee.name')}}");
        });
        $(document).on('click', '.createFeeBtn', function() {
            let pid = $(this).attr('pid');
            let formId = 'feeForm' + pid;
            let btnId = 'id' + pid;
            submitFormAjax(formId, btnId, "{{route('create.fee.name')}}");
        })

        // create school class arm
        $('#createClassArmSubjectBtn').click(function() {
            submitFormAjax('createClassArmSubjectForm', 'createArmSubjectBtn', "{{route('create.school.class.arm.subject')}}");
        });

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->