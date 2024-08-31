@extends('layout.mainlayout')
@section('title','Staff Attendance')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Staff Attendance</h5>
        <!-- Bordered Tabs Justified -->
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <!-- <a href="#term-tab"> -->
                <button class="nav-link w-100 active" data-bs-toggle="tab" data-bs-target="#term-tab" type="button" role="tab">Attendance</button>
                <!-- </a> -->
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <!-- <a href="#active-tab"> -->
                <button class="nav-link w-100" id="active-tab" data-bs-toggle="tab" data-bs-target="#set-active-tab" type="button" role="tab">Config</button>
                <!-- </a> -->
            </li>
            
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="term-tab" role="tabpanel" aria-labelledby="term-tab">
                <!-- Create term -->
                <div class="row">
                    
                    <div class="col-md-4">
                        <select name="class_pid" id="categoryClassSubjectSelect2" class="form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="class_pid" id="classSubjectSelect2" class="classSelect2 form-control form-control-sm" style="width: 100%;">
                        </select>
                    </div>
                   
                </div>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display table-bordered table-striped table-hover mt-3 cardTable" id="staffAttendanceTable">
                    <thead>
                        <tr>
                            <th width ="5%">SN</th>
                            <th>Names</th>
                            <th>Clocked in</th>
                            <th>Status </th>
                            <th>Clocked out</th>
                            {{-- <th>platform</th>
                            <th>device</th> --}}
                            <th>browser</th>
                           
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

            <div class=" tab-pane fade" id="set-active-tab" role="tabpanel" aria-labelledby="set-active-tab">

                <fieldset>
                     <form action="" class="row g-3" method="post" id="configForm">
                        @csrf
                        <div class="col-md-4">
                            <label for="school_name"> clock in start <span class="text-danger">*</span> </label>
                            <input type="time" name="clock_in_begin" id="clock_in_begin" class=" form-control form-control-sm" required>
                            <p class="text-danger clock_in_begin_error"></p>
                        </div>
                        <div class="col-md-4">
                            <label for="late_time">Lateness time <span class="text-danger">*</span></label>
                            <input type="time" name="late_time" id="late_time" class="form-control form-control-sm" required>
                            <p class="text-danger late_time_error"></p>

                        </div>
                        <div class="col-md-4">
                            <label for="clock_in_end">Clock in stop <span class="text-danger">*</span></label>
                            <input type="time" name="clock_in_end" id="clock_in_end" class=" form-control form-control-sm" required>
                            <p class="text-danger clock_in_end_error"></p>

                        </div>
                       
                        <hr>
                        <div class="col-md-6">
                            <label for="office_resume_time">Office Resume <span class="text-danger">*</span></label>
                            <input type="time" name="office_resume_time" id="office_resume_time" class="form-control form-control-sm"  required>
                            <p class="text-danger office_resume_time_error"></p>

                        </div>
                        <div class="col-md-6">
                            <label for="office_close_time">Office Close <span class="text-danger">*</span></label>
                            <input type="time" name="office_close_time" id="office_close_time" class="form-control form-control-sm" required>
                            <p class="text-danger office_close_time_error"></p>

                        </div>

                        <div class="col-md-4">
                            <label for="latitude">latitude </label>
                            <input type="text" name="latitude" id="latitude" readonly class="form-control form-control-sm"  required>
                            <p class="text-danger latitude_error"></p>

                        </div>
                        <div class="col-md-4">
                            <label for="longitude">longitude </label>
                            <input type="text" name="longitude" id="longitude" readonly class="form-control form-control-sm"  required>
                            <p class="text-danger longitude_error"></p>

                        </div>

                        <div class="col-md-4">
                            <label for="school_email">Fence Radius </label>
                            <input type="number" name="fence_radius" id="fence_radius" placeholder="e.g 30" class="form-control form-control-sm"  required>
                            <p class="text-danger fence_radius_error"></p>

                        </div>
                        
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" id="configBtn">Submit</button>
                            
                        </div>
                    </form>
                </fieldset>
                <!-- </div> -->
            </div>
        

        </div><!-- End Bordered Tabs Justified -->

    </div>
</div>


<!-- End Basic Modal-->

<script>
    $(document).ready(function() {
       
        // validate signup form on keyup and submit
       
        $(document).on('click','#configBtn', async function(){ 
           let s = await submitFormAjax('configForm', 'configBtn', "{{route('config.staff.attendance')}}");
        })
        loadConfig()
        function loadConfig(){
            // 
            $.ajax({
                url: "{{route('load.config.staff.attendance')}}",
                success: function(data) {
                    // console.log(data);
                    $('#clock_in_begin').val(data.clock_in_begin);
                    $('#late_time').val(data.late_time);
                    $('#clock_in_end').val(data.clock_in_end);
                    $('#office_resume_time').val(data.office_resume_time);
                    $('#office_close_time').val(data.office_close_time) //.attr('disabled', true);
                    $('#latitude').val(data.latitude);
                    $('#longitude').val(data.longitude);
                    $('#fence_radius').val(data.fence_radius);
                }
            });
        }
       

        

        
        loadAttendance()

        function loadAttendance(){
             $('#staffAttendanceTable').DataTable({
                "processing": true,
                "serverSide": true,
                destroy:true ,
                responsive: true,
                "ajax": "{{route('load.staff.attendance')}}",
                "columns": [
                    {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            // orderable: false,
                            // searchable: false
                        },
                    
                    {
                        "data": "fullname"
                    },
                    {
                        "data": "clock_in"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "clock_out"
                    },
                    {
                        "data": "browser"
                    },
                    {
                        "data": "image"
                    },
                    
                ],
            });
        }
 
     
       

       
    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->