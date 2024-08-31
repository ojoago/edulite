@extends('layout.mainlayout')
@section('title','Staff Attendance')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Attendance
            <button type="button" class="btn btn-primary btn-sm mb-2" id="takeAttendance"> Take Attendance</button>
        </h5>
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
                <table class="table display table-bordered table-striped table-hover mt-3 cardTable" id="attendanceTable">
                    <thead>
                        <tr>
                            <th width ="5%">SN</th>
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


        </div><!-- End Bordered Tabs Justified -->

  


<div class="modal fade" id="selfAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="captureAttendanceForm">
                    @csrf
                    
                    <!-- Video feed -->
                    <video id="video" width="320" height="240" autoplay></video>
                    
                    <!-- Capture button -->
                    <input type="hidden" name="latitude" id="latitude">                    
                    <input type="hidden" name="longitude" id="longitude">                    
                    <!-- Canvas element to hold the captured image -->
                    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                    
                    <!-- Hidden input to hold the image data -->
                    <input type="hidden" id="imageData" name="image">
                    <input type="hidden" id="browser" name="browser">
                    <input type="hidden" id="area" name="area">
                    
                    <!-- Display the captured image -->
                    <img id="capturedImage" src="">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="captureAttendance">Capture</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- End Basic Modal-->

<script>
    $(document).ready(function() {

    
        loadAttendance()

        function loadAttendance(){
             $('#attendanceTable').DataTable({
                "processing": true,
                "serverSide": true,
                destroy:true ,
                responsive: true,
            "ajax": "{{route('load.my.attendance')}}",
            "columns": [
                {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: false
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
       let latitude 
       let logitude 
       let radius 
        loadConfig()
        function loadConfig(){
            // 
            $.ajax({
                url: "{{route('load.config.staff.attendance')}}",
                success: function(data) {
                    latitude = data.latitude
                    longitude = data.longitude
                    radius = data.fence_radius
                }
            });
        }
    let stream;
        // validate signup form on keyup and submit
         // Get references to the video, canvas, and button elements
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const startCameraBtn = document.getElementById('takeAttendance');
    const captureButton = document.getElementById('captureAttendance');
    const imageDataInput = document.getElementById('imageData');
    const capturedImage = document.getElementById('capturedImage');

    // Capture the image when the button is clicked
    startCameraBtn.addEventListener('click', function() {
         // Get access to the user's webcam
        startCamera()
        getLocation()
        let brow = agent()
        $('#browser').val(brow)
        // show modal 
        $('#selfAttendanceModal').modal('show')
    });

    
    // Capture the image when the button is clicked
    captureButton.addEventListener('click', async function() {
         // Draw the video frame to the canvas
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Get the image data as a data URL (base64-encoded)
        const imageData = canvas.toDataURL('image/png');
        
        // Set the image data in the hidden input and show the captured image
        imageDataInput.value = imageData;
        capturedImage.src = imageData;
        capturedImage.style.display = 'block';
        stopCamera()
        
        canvas.style.display = 'none';
        video.style.display = 'none';
        await submitAttendance()

    });

    async function submitAttendance() {
        let s = await submitFormAjax('captureAttendanceForm', 'captureAttendance', "{{route('capture.attendance')}}");
        console.log(s);
    
    }


 function calculateDistance(lat1, lon1, lat2, lon2, fence) {
    // var R = 6371000; // Radius of the Earth in meters
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = 
        0.5 - Math.cos(dLat)/2 + 
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
        (1 - Math.cos(dLon))/2;

    return fence * 2 * Math.asin(Math.sqrt(a));
}


 // Get access to the user's webcam function
    const startCamera = () => {
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(mediaStream) {
            stream = mediaStream;
            video.srcObject = mediaStream;
        })
        .catch(function(error) {
            alert('Enable your browser camera')
            console.error('Error accessing webcam:', error);
        });
    }

    const stopCamera = () => {
        if (stream) {
            let tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
    }




         function getLocation() {
                if (navigator.geolocation) {
                    // $('#status').text('Getting your location...');
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else {
                    alert('Geolocation is not supported by this browser.')
                    // $('#status').text('Geolocation is not supported by this browser.');
                }
        }

            // Function to display the latitude and longitude
            function showPosition(position) {
                var lat = position.coords.latitude;
                var long = position.coords.longitude;
                if(radius){
                    var distance = calculateDistance(latitude, longitude, lat, long, radius);
                  if (distance <= fenceRadius) {
                        $('#latitude').val(lat)
                        $('#longitude').val(long)
                        reverseGeocode(lat, lat);
                    } else {
                        alert('You are outside the geo-fence.');
                    }
                }else{
                     $('#latitude').val(lat)
                    $('#longitude').val(long)
                    reverseGeocode(lat, long);
                }
                
                
                
            }

            // Function to handle errors
            function showError(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        alert('User denied the request for Geolocation.')
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert('Location information is unavailable.')
                        break;
                    case error.TIMEOUT:
                        alert('The request to get user location timed out.')
                        break;
                    case error.UNKNOWN_ERROR:
                        alert('An unknown error occurred.')
                }
            }


            function reverseGeocode(latitude, longitude) {
                var url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;
                $.get(url, function(data) {
                    if (data && data.display_name) {
                        $('#area').val(data.display_name)
                        return ;
                       // $('#locationName').text('Location Name: ' + data.display_name);
                    } else {
                         $('#area').val(null)
                        return null;
                        //$('#locationName').text('No address found for the given coordinates.');
                    }
                });
            }
       
    
            const agent = () => {
                const userAgent = navigator.userAgent;
                let brow;
                if (userAgent.includes('Chrome')) {
                    brow = 'Google Chrome';
                } else if (userAgent.includes('Firefox')) {
                    brow = 'Mozilla Firefox';
                } else if (userAgent.includes('Safari')) {
                    brow = 'Apple Safari';
                } else if (userAgent.includes('Edge')) {
                    brow = 'Microsoft Edge';
                } else if (userAgent.includes('Opera') || userAgent.includes('OPR/')) {
                    brow = 'Opera';
                } else if (userAgent.includes('Brave')) {
                    brow = 'Brave';
                } else {
                    brow = 'Unknown Browser';
                }
                return brow;
            }



    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->