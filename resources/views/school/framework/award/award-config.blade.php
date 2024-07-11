@extends('layout.mainlayout')
@section('title','Student Awards')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Awards</h5>
        <!-- Default Tabs -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#hieConfigModal">
                    Create Award
                </button>
                <!-- <div class="table-responsive mt-3"> -->
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="awardTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Award</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
     
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
                            <input type="text" class="form-control form-control-sm" name="award" id="award" placeholder="e.g overrall best student">
                            <p class="text-danger award_error"></p>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Award Type</label>
                            <select name="type" id="type" class="form-control form-control-sm">
                                <option disabled selected>Select Type</option>
                                <option value="1">One per Class</option>
                                <option value="2">One per School</option>
                                <option value="3">General</option>
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

<script>
    $(document).ready(function() {
        // add more title 

        // create school class arm
        $('#createAwardBtn').click(async function() {
           let sts = await submitFormAjax('awardForm', 'createAwardBtn', "{{route('create.student.award')}}");
           if(sts.status == 1){
                loadAwardKeys()
            }
        });
       
        // load page content  
        loadAwardKeys();
        // load school Notification
        function loadAwardKeys(session = null, term = null) {
            $('#awardTable').DataTable({
                "processing": true,
                "serverSide": true,
                // rowReorder: {
                //     selector: 'td:nth-child(2)'
                // },
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
                        "data": "type"
                    },

                ],
            });
        }
       
      
    });
</script>

@endsection

<!-- <h1>education is light hence EduLite</h1> -->