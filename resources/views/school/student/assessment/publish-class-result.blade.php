@extends('layout.mainlayout')
@section('title','Publish School Results')
@section('content')
<style>
    /* p {
        text-align: center;
        color: limegreen;
        font-size: 1.5em;
        font-weight: bold;
        text-shadow: 1px 1px 2px #000;
        margin-bottom: 1em;
    } */
    .studentTotal {
        border: none;
        background-color: transparent;
        color: #000;
        width: 100%;
        padding: 0;
        margin: 0;
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                     <i class="bi bi-calendar-event-fill"></i> {{activeTermName()}} {{activeSessionName()}}</small>
            </h5>
            
            <!-- Primary Color Bordered Table -->
               
                    <table class="table table-bordered border-primary  cardTable" id="resultTable">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">S/N</th>
                                <th scope="col">Category</th>
                                <th scope="col">Class</th>
                                <th scope="col">Class Arm</th>
                                <th scope="col">Students</th>
                                <th scope="col"> <input type="checkbox" name="" id="classResult"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                              
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <th  colspan="3"></th>
                                <th>Total</th>
                                <th scope="col"><span id="totalSelected">0</span></th>
                                <th scope="col"> <button class="btn btn-sm btn-primary" id="publishResultBtn">Publish</button> </th>
                            </tr>
                        </tfoot>
                       
                    </table>
                    
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {


       $('#resultTable').DataTable({
            fixedHeader: true,
            paging: false,
            "info": false,
            // "searchable": false,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            responsive: true,
            "ajax": "{{route('load.school.result')}}",
            "columns": [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    "data": "category"
                },
                {
                    "data": "class"
                },
                {
                    "data": "arm"
                },
                {
                    "data": "students"
                },
               
                {
                    "data": "action"
                },
            ],
        });


        $('#classResult').click(function(){
            if (this.checked) {
                // Iterate each checkbox
                $('.classResult').each(function() {
                    this.checked = true;
                });
            } else {
                $('.classResult').each(function() {
                    this.checked = false;
                });
            }
            sumChecked()
        })


         $(document).on('change', '.classResult', function() {
            sumChecked()
        })
       
        function sumChecked(){
            let total = 0;
            $('.classResult').each(function(i, obj) {
                if (obj.checked == true) {
                    total += Number($(this).val());
                }
                if (total > 0) {
                    $('#publishResultBtn').prop('disabled', false);
                } else {
                    $('#publishResultBtn').prop('disabled', true);
                }
                $('#totalSelected').text(total.toFixed(0));
            });
        }
     
         $('#publishResult').click(function() {
            let param = $(this).attr('param')
             $.ajax({
                url: "{{route('lock.class.result')}}",
                type: "POST",
                data: {
                    param: param,
                    _token: "{{csrf_token()}}",
                },
                success: function(data) {
                    if(data.status == 1){
                        alert_toast(data.message, 'success')
                    }else{
                        alert_toast(data.message, 'error')
                    }
                },
                error: function(data) {
                    alert_toast('Weldone', 'error')
                }
            });
        });

        
    });
</script>
@endsection