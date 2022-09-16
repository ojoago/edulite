@extends('layout.mainlayout')
@section('title','Hostels config')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Hostels </h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="hostel-config-tab" data-bs-toggle="tab" data-bs-target="#hostel-config" type="button" role="tab">Hostels</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="hostel-tab" data-bs-toggle="tab" data-bs-target="#hostel-student" type="button" role="tab">Hostel Portal</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="ex-tab" data-bs-toggle="tab" data-bs-target="#ex-student" type="button" role="tab">Ex Student</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="hostel-config" role="tabpanel">
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createHostelModal">
                    Create Hostel
                </button>
                <table class="table table-hover table-striped" id="hostelDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Date Created</th>
                            <!-- <th>Created By</th> -->
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tab-pane fade" id="hostel-student" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-hover table-striped" id="hostel-studentDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Hostel</th>
                            <th>Portal</th>
                            <th>Session</th>
                            <th>Term</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="tab-pane fade" id="ex-student" role="tabpanel" aria-labelledby="contact-tab">
                <table class="table table-hover table-striped" id="ex-studentDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Hostel</th>
                            <th>Fullname</th>
                            <th>Reg</th>
                            <th>Class</th>
                            <th>Portal</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create psycho modal  -->
<div class="modal fade" id="createHostelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Hostel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createHostelForm">
                    @csrf
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Hostel Name">
                    <p class="text-danger name_error"></p>
                    <input type="number" name="capacity" class="form-control form-control-sm" placeholder="Capacity" required>
                    <p class="text-danger capacity_error"></p>
                    <textarea type="text" name="location" class="form-control form-control-sm" placeholder="Location" required></textarea>
                    <p class="text-danger location_error"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createHostelBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Psychomotro Modal-->



<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {

        // hostels
        $('#createHostelBtn').click(function() {
            var route = "{{route('create.hostel')}}";
            submitFormAjax('createHostelForm', 'createHostelBtn', route);
        });
        $('#hostelDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            // ->rawColumns(['data', 'action'])
            responsive: true,
            type: "get",
            "ajax": "{{route('load.hostels')}}",
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "capacity"
                },
                {
                    "data": "location"
                },
                {
                    "data": "date"
                },
                // {
                //     "data": "username"
                // },
                {
                    "data": "action"
                },
            ],
        });


    });
</script>
@endsection