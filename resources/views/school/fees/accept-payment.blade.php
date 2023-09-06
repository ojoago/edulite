@extends('layout.mainlayout')
@section('title','Student Invoice')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Fees</h5>
        <form method="post" class="" id="processStudentInvoiceForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="hostel_pid" class="text-center">Select Student</label>
                    <select name="student_pid" id="psiStudentSelect2" class="form-control form-control-sm">
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="hostel_pid" class="text-center">Enter Student Reg Instead</label>
                    <div class="input-group">
                        <input type="text" name="" id="studentReg" class="form-control form-control-sm">
                        <span class="input-group-text pointer" id="findStudentByReg"> <i class="bi bi-search"></i> </span>
                    </div>
                </div>
            </div>
            <p class="text-danger student_pid_error"></p>
            <div id="studentUnPaidInvoices"></div>
            <hr>
            <div class="text m-3" style="display: none;" id="paymentBtn">
                <p>select mode of payment</p>
                <input type="radio" name="mode" class="big-check" value="1"> Online 
                <input type="radio" name="mode" class="big-check" value="2"> Direct 
                <!-- <input type="radio" name="mode" class="big-check" value="3"> Wallet -->
                <p class="text-danger mode_error"></p>
                <button class="btn btn-primary" type="button" id="acceptPaymentBtn">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- modals  -->
<!-- create school category modal  -->

<script>
    $(document).ready(function() {

        // load student on fee payment modal 
        FormMultiSelect2('#psiStudentSelect2', 'student', 'Select Student');
        $('#psiStudentSelect2').change(async function(e) {
            e.preventDefault()
            let pid = $(this).val();
            if (pid) {
                await loadStudentInvoiceById(pid)
            }
        });

        $('#findStudentByReg').click(async function() {
            let reg = $('#studentReg').val();
            if (reg != null) {
                let params = {
                    reg: reg,
                    _token: "{{csrf_token()}}"
                };
                let route = "{{route('find.student.by.reg')}}";
                let data = await loadDataAjax(route, params);
                if (data && data.pid) {
                    await loadStudentInvoiceById(data.pid);
                }
            }
        });

        
    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->