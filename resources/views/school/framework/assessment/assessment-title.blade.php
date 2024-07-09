@extends('layout.mainlayout')
@section('title','Assessment setup')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Assessment/Score</h5>
        <!-- Bordered Tabs Justified -->
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="assessment-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-assessment" type="button" role="tab" aria-controls="assessment" aria-selected="true">Assessment</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="scoreSetting-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-scoreSetting" type="button" role="tab" aria-controls="scoreSetting" aria-selected="false">Score Setting</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="bordered-justified-assessment" role="tabpanel" aria-labelledby="assessment-tab">
                <!-- Create assessment -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createAssessmentModal">
                    Create Assessment
                </button>
                <table class="table table-hover table-striped cardTable" id="title-dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            {{-- <th>Category</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="bordered-justified-scoreSetting" role="tabpanel" aria-labelledby="scoreSetting-tab">
                <!-- Create Session -->
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createScoreSettingModal">
                    Create Score Setting
                </button>
                <table class="table table-hover table-striped cardTable" id="scoreDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Class</th>
                            <th>Title</th>
                            <th>Order</th>
                            <th>Score</th>
                            <th>Category</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div><!-- End Bordered Tabs Justified -->

    </div>
</div>





</div><!-- End Basic Modal-->
<script>
    $(document).ready(function() {
        // load school session
        $('#title-dataTable').DataTable({
            "processing": true,
            "serverSide": true,
           
            responsive: true,
            "ajax": "{{route('load.school.assessment.title')}}",
            "columns": [{
                    "data": "title"
                },
                {
                    "data": "description"
                },
                // {
                //     "data": "category"
                // },

                {
                    "data": "action"
                },
                // {
                //     "data": "action"
                // },
            ],
        });
        $('#scoreDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            responsive: true,
            "ajax": "{{route('load.score.setting')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                }, {
                    "data": "class"
                },

                {
                    "data": "title"
                },
                {
                    "data": "order"
                },
                {
                    "data": "score"
                },
                {
                    "data": "type"
                },
                {
                    "data": "date"
                },

            ],
            "columnDefs": [{
                    targets: [1],
                    visible: false
                },
                // {
                //     targets: [5],
                //     className: "align-right"
                // }
            ],
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(1, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="4"><b>' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });



        // multiSelect2('categorySelect2', 'createClassArmModal', sbjCategoryselect2Url, 'Select Category');


        // 
        
        $(document).on('click', '.editAssessmentTitle', async function() {
            let pid = $(this).attr('pid');
            let s = await submitFormAjax('editAssessmentForm'+pid, 'editAssessmentBtn'+pid, "{{route('update.assessment.title')}}");
            // if (s.status === 1) {
            //    loadSubjectTable(null)
            // }
        })

         $(document).on('click', '.deleleteTitle', async function() {
            let pid = $(this).attr('pid');
            if(confirm('are you sure, you want to delete this title ?')){
                let param = {
                    pid:pid,
                    _token: "{{csrf_token()}}"
                }
               let  s = await postDataAjax(param , "{{route('delete.assessment.title')}}");
            //    if(s.status == 1){
            //     // loadCategory(0)
            //    }
            }
        });


    });
</script>
@endsection
<!-- <h1>education is light hence EduLite</h1> -->