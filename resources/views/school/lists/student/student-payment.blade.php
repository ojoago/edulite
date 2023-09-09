@extends('layout.mainlayout')
@section('title','Student Payment')
@section('content')
<link href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Student Payment</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">

            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="fees-tab" data-bs-toggle="tab" data-bs-target="#fees" type="button" role="tab">Fees</button>
            </li>

            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="reciept-tab" data-bs-toggle="tab" data-bs-target="#reciepts" type="button" role="tab">Reciept</button>
            </li>

        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">

            <div class="tab-pane fade show active" id="fees" role="tabpanel">
                <!--  -->
                <button class="btn btn-primary btn-sm m-2" id="payWardFee">Pay Fee</button>
                List of unpaid fees
                <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="studentUnPaidInvoice">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Class</th>
                            <th>Fee</th>
                            <th align="right">{!!NAIRA_UNIT!!} Amount</th>
                            <th>Term</th>
                            <th>Session</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3"></th>
                            <th colspan="5"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>


            <div class="tab-pane fade" id="reciepts" role="tabpanel">
                <table class="table table-hover table-striped table-bordered cardTable" id="recieptDataTable">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th>Invoice Number</th>
                            <th align="right">{!!NAIRA_UNIT!!} Total</th>
                            <th align="right">{!!NAIRA_UNIT!!} Amount paid</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <td colspan="2"></td>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>



<!-- student invoice payment -->
<div class="modal fade" id="processStudentInvoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Make Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="" id="processStudentInvoiceForm">
                    @csrf
                    <input type="hidden" name="student_pid" id="wardStudentSelect2">
                    <div id="studentUnPaidInvoices"></div>
                    <input type="hidden" name="mode" class="big-check" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" type="button" id="acceptPaymentBtn" style="display: none;">Submit</button>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        let term = "{{activeTerm()}}"
        let session = "{{activeSession()}}"
        FormMultiSelect2('#formTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#formSessionSelect2', 'session', 'Select Session', session)


        FormMultiSelect2('#timetableTermSelect2', 'term', 'Select Term', term)
        FormMultiSelect2('#timetableSessionSelect2', 'session', 'Select Session', session)

        FormMultiSelect2('#resultTermSelect2', 'term', 'Select Term');
        FormMultiSelect2('#resultSessionSelect2', 'session', 'Select Session');

        $('#reciept-tab').click(function() {
            $('#recieptDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.particular.student.payment')}}",
                    data: {
                        pid: "{{studentPid()}}",
                        _token: "{{csrf_token()}}"
                    },
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "invoice_number"
                    },
                    {
                        "data": "total"
                    },
                    {
                        "data": "paid"
                    },
                    {
                        "data": "date"
                    },
                ],
                "footerCallback": function() {
                    var api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // computing column Total of the complete result 
                    var total = api
                        .column(2)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var paid = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column(0).footer()).html('Total');
                    $(api.column(2).footer()).html(numberFormat(total));
                    $(api.column(3).footer()).html(numberFormat(paid));
                }
            });
        });


        function studentUnPaidInvoice(term = null, session = null) {
            $('#studentUnPaidInvoice').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                destroy: true,
                "ajax": {
                    url: "{{route('load.particular.student.invoice')}}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: session,
                        term_pid: term,
                        pid: "{{studentPid()}}",
                    }
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "arm"
                    },

                    {
                        "data": "fee_name"
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "term"
                    },
                    {
                        "data": "session"
                    },

                    {
                        "data": "type",
                    },

                    {
                        "data": "date",
                    },
                ],
                "footerCallback": function() {
                    var api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // computing column Total of the complete result 
                    var total = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column(0).footer()).html('Total');
                    $(api.column(3).footer()).html(numberFormat(total));
                }
            });

        }
        studentUnPaidInvoice()
        $('#fees-tab').click(function() {
            studentUnPaidInvoice()
        })
        $('#payWardFee').click(async function() {
            let pid = "{{studentPid()}}";
            if (pid) {
                await loadStudentInvoiceById(pid) // this function is inside mainjs.blade.php
                $('#wardStudentSelect2').val(pid); // 
                $('#processStudentInvoiceModal').modal('show');
            }
        })
        // load page content  
        $('#timetable-tab').click(function() {
            loadTimetable();
        })


        $('#timetableTermSelect2').change(function() {
            let term = $(this).val();
            let session = $('#timetableSessionSelect2').val();
            if (session != null) {
                loadTimetable(session, term);
            } else {
                loadTimetable(null, term);
            }
        })
        // load school timetable
        function loadTimetable(session = null, term = null) {
            $('#timetableDatatable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                // type: "GET",
                "ajax": {
                    url: "{{route('load.student.timetable')}}",
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        session_pid: session,
                        term_pid: term,
                        pid: "{{studentPid()}}",
                    },
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    // {
                    //     "data": "arm"
                    // },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "exam_date"
                    },
                    {
                        "data": "exam_time",
                    },
                    {
                        "data": "date"
                    },
                ],
                // drawCallback: function(settings) {
                //     var api = this.api();
                //     var rows = api.rows({
                //         page: 'current'
                //     }).nodes();
                //     var last = null;

                //     api.column(4, {
                //         page: 'current'
                //     }).data().each(function(group, i) {

                //         if (last !== group) {

                //             $(rows).eq(i).before(
                //                 '<tr class="group"><td colspan="8">' + 'GRUPO ....' + group + '</td></tr>'
                //             );

                //             last = group;
                //         }
                //     });
                // }
            });
        }

        // load student riders 
        $('#rider-tab').click(function() {
            $('#riderDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                "ajax": {
                    method: "POST",
                    url: "{{route('load.student.riders')}}",
                    data: {
                        pid: "{{studentPid()}}",
                        _token: "{{csrf_token()}}"
                    },
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "fullname"
                    },
                    {
                        "data": "gsm"
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "address"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "date"
                    },
                ],
            });
        });

    });
</script>

@endsection