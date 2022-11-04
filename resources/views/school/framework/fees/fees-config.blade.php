@extends('layout.mainlayout')
@section('title','School Events')
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
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassCategoryModal">
                    Create Notification
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="classCategoryTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
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
<div class="modal fade" id="createClassCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Fee Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="createClassCategoryForm">
                    @csrf
                    <input type="text" name="fee_item" class="form-control form-control-sm" placeholder="example school fee" required>
                    <p class="text-danger fee_item_error"></p>
                    <textarea type="text" name="fee_description" class="form-control form-control-sm" placeholder="fee description" required></textarea>
                    <p class="text-danger fee_description_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createClassCategoryBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // add more title 

        // load dropdown on 

        // filter class subject 
        FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        FormMultiSelect2('#categoryClassSubjectSelect2', 'category', 'Select Category');
        // create school class arm
        $('#createClassArmBtn').click(function() {
            submitFormAjax('createClassArmForm', 'createClassArmBtn', "{{route('create.school.class.arm')}}");
        });


        // create school class arm
        $('#createClassArmSubjectBtn').click(function() {
            submitFormAjax('createClassArmSubjectForm', 'createArmSubjectBtn', "{{route('create.school.class.arm.subject')}}");
        });

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->