@extends('layout.mainlayout')
@section('title','Student Awards')
@section('content')
<link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Award</h5>
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="hire-tab" data-bs-toggle="tab" data-bs-target="#hire-home" type="button" role="tab">Awards</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="applicant-tab" data-bs-toggle="tab" data-bs-target="#applicant" type="button" role="tab">Applied</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="available-tab" data-bs-toggle="tab" data-bs-target="#available" type="button" role="tab">Available Applicant</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="hire-home" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#hieConfigModal">
                    Create Award
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="awardTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Award</th>
                            <th>Date</th>
                            <!-- <th>Field</th> -->
                            <!-- <th>Expirence</th> -->
                            <!-- <th>Subjects</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="applicant" role="tabpanel" aria-labelledby="profile-tab">
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="applicantTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Title</th>
                            <th>Fullname</th>
                            <th>Qualification</th>
                            <!-- <th>Field</th>
                            <th>Expirence</th>
                            <th>Subjects</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="available" role="tabpanel">
                <div class="row mb-3">

                    <div class="col-md-4">
                        <select name="class_pid" id="timetableClassSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="arm_pid" id="timetableArmSelect2" class="classSelect2 form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="session_pid" id="timetableSessionSelect2" class="form-control form-control-sm">
                        </select>
                    </div>

                </div>
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="availableHire">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Names</th>
                            <th>Contact</th>
                            <th>Qualification</th>
                            <th>Field</th>
                            <th>Expirence</th>
                            <th>About</th>
                            <th>Subjects</th>
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
<div class="modal fade" id="hieConfigModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create School Award</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="awardForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Award</label>
                            <input type="text" class="form-control form-control-sm" name="award" id="award" placeholder="e.g teacher">
                            <p class="text-danger award_error"></p>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Award Type</label>
                            <select name="type" id="type" class="form-control form-control-sm">
                                <option disabled selected>Select Type</option>
                                <option value="1">Class</option>
                                <option value="2">School</option>
                                <option value="3">okay</option>
                            </select>
                            <p class="text-danger type_error"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createAwardBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- create school category modal  -->
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {
        // add more title 

        // create school class arm
        $('#createAwardBtn').click(function() {
            submitFormAjax('awardForm', 'createAwardBtn', "{{route('create.student.award')}}");
        });
       
        // load page content  
        loadAwardKeys();
        // load school Notification
        function loadAwardKeys(session = null, term = null) {
            $('#awardTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                ajax: "{{route('load.student.award')}}",
                "columns": [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "award"
                    },
                    {
                        "data": "date"
                    },

                    // {
                    //     "data": "course"
                    // },
                    // {
                    //     "data": "years"
                    // },

                    // {
                    //     "data": "subjects"
                    // },

                ],
            });
        }
       
      
    });
</script>

@endsection

<!-- <h1>education is light hence EduLite</h1> -->