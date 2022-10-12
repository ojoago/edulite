@extends('layout.mainlayout')
@section('title','Rider Profile')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Rider Profile</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab">Students</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="activeStudent-tab">
                <div id="profileDetail"></div>
            </div>
            <div class="tab-pane fade" id="student" role="tabpanel">
                <div id="studentDetail"></div>
                <h5 class="card-title">Rider List</h5>
                <table class="table table-hover table-responsive table-striped table-bordered cardTable" id="studentDataTable">
                    <thead>
                        <tr>
                            <!-- <th>S/N</th> -->
                            <th>Names</th>
                            <th>Reg Number</th>
                            <!-- <th>Phone Number</th> -->
                            <!-- <th>Username</th>
                            <th>Email</th> -->
                            <th>Address</th>
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
            let pid = "{{$pid}}";
            loadRiderPorfile(pid);

            function loadRiderPorfile(pid) {
                $('.overlay').show();
                $.ajax({
                    url: "{{route('view.rider.profile')}}",
                    data: {
                        pid: pid,
                        _token: "{{csrf_token()}}",
                    },
                    type: "post",
                    success: function(data) {
                        $('.overlay').hide();
                        $('#profileDetail').html(data)
                    },
                    error: function() {
                        $('.overlay').hide();
                    }
                });
            }
            $('#student-tab').click(function() {
                $('#studentDataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    destroy: true,
                    "ajax": {
                        url: "{{route('load.rider.student')}}",
                        type: "post",
                        data: {
                            pid: pid,
                            _token: "{{csrf_token()}}",
                        },
                    },
                    "columns": [
                        // {
                        //     data: 'DT_RowIndex',
                        //     name: 'DT_RowIndex',
                        //     // orderable: false,
                        //     // searchable: false
                        // },
                        {
                            "data": "fullname"
                        },
                        {
                            "data": "reg_number"
                        },
                        // {
                        //     "data": "username"
                        // },
                        // {
                        //     "data": "email"
                        // },
                        {
                            "data": "address"
                        },


                        // {
                        //     "data": "date"
                        // },


                    ],
                });

            })
        });
    </script>
    @endsection