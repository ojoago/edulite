@extends('layout.mainlayout')
@section('title','Extra Curricular Activities')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Extra Curricular Activities</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#psychomotor" type="button">Extra Curricular</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="psychomotoKey-tab" data-bs-toggle="tab" data-bs-target="#psychomotoKey" type="button" role="tab">Extra Curricular Keys</button>
            </li>
            {{-- <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#psychoGrade" type="button" role="tab">Grade Key</button>
            </li> --}}
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="psychomotor" role="tabpanel" aria-labelledby="home-tab">
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createPsychomotorBaseModal">
                    Create Extra Curricular
                </button>
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#clonePsychomotorBaseModal">
                    Clone Extra Curricular
                </button>
                <table class="table table-hover table-striped cardTable" id="psychomotorBaseDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Extra Curricular Names</th>
                            <th>Obtainable Score</th>
                            <th>Grade Style</th>
                            {{-- <th>Description</th> --}}
                            {{-- <th>Status</th> --}}
                            {{-- <th>Date</th> --}}
                           
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tab-pane fade" id="psychomotoKey" role="tabpanel" aria-labelledby="profile-tab">

                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createPsychomotorKeyModal">
                            Create Extra Curricular keys
                        </button>
                    </div>
                    <div class="col-md-4">
                        <select name="category_pid" id="psychomotorBaseSelect2" class="form-control form-control-sm">
                        </select>
                    </div>
                </div>
                <table class="table table-hover table-striped table-bordered cardTable" id="psychomotorKeyDataTable" width="100%">
                    <thead>
                        <tr>
                            <th width="5%" >S/N</th>
                            <th>Extra Curricular</th>
                            <th>Title</th>
                            {{-- <th>Score</th> --}}
                            {{-- <th>Status</th> --}}
                            {{-- <th>Date</th> --}}
                            <!-- <th>Created By</th> -->
                        </tr>
                    </thead>

                </table>
            </div>

            <div class="tab-pane fade" id="psychoGrade" role="tabpanel" aria-labelledby="contact-tab">
                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createPyschoGradeModal">
                    Create GD
                </button>
                <table class="table table-hover table-striped cardTable" id="psychoGradeDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Grade</th>
                            <th>Score</th>
                            <th>Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>

<!-- create psycho Base modal  -->
<div class="modal fade" id="createPsychomotorBaseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">Create Extra Curricular Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createPsychomotorBaseForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-7">
                            <label for="">School Category</label>
                            <select type="text" name="category" class="form-control" id="cpbfCategorySelect2" required>
                            </select>
                            <p class="text-danger category_error"></p>
                        </div>
                        <div class="col-md-5">
                            <label for="">Grade System</label>
                            <select type="text" name="grade" class="form-control form-control-sm" required>
                                <option disabled selected> Select Grade</option>
                                <option value="1" >Number</option>
                                <option value="2" >Alphabet</option>
                                <option value="3" >Checked</option>
                                <option value="4" >Sentence</option>
                            </select>
                            <p class="text-danger grade_error"></p> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <label for="">Extra Curricular Name</label>
                            <input type="text" name="psychomotor[]" class="form-control form-control-sm" placeholder="Create Base Psychomotor">
                            <p class="text-danger psychomotor_error"></p>
                        </div>
                        <div class="col-md-5">
                            <label for="">Maximum Score</label>
                            <div class="input-group">
                                <input type="number" name="score[]" class="form-control form-control-sm" placeholder="obtainable score" required>
                                <i class="bi bi-x-circle-fill text-danger hidden-item mx-1"></i>
                            </div>
                            <p class="text-danger score_error"></p> 
                        </div>
                    </div>

                     <div id="moreExtra"></div>
                    <button id="addMoreExtra" type="button" class="btn btn-danger btn-sm btn-sm m-1">Add More</button>
                    

                    {{-- <label for="">Description</label>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="Description"></textarea>
                    <p class="text-danger description_error"></p> --}}
                    
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createPsychomotorBaseBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Psychomotro Modal-->

<!-- create psycho Base modal  -->
<div class="modal fade" id="clonePsychomotorBaseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">CLone Extra Curricular Name and Keys</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="clonePsychomotorBaseForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Category</label>
                            <select type="text" class="form-control" id="cloneFromCategorySelect2" required>
                            </select>
                            <p class="text-danger category_error"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="">Extra Curricular Name</label>
                            <select type="text" name="psychomotor[]" multiple class="form-control" id="clonePsychomotorSelect2" required>
                            </select>
                            <p class="text-danger psychomotor_error"></p>
                        </div>

                        <div class="col-md-12">
                            <label for="">School Category</label>
                            <select type="text" name="category[]" multiple class="form-control" id="cloneToCategorySelect2" required>
                            </select>
                            <p class="text-danger category_error"></p>
                        </div>
                    </div>
                    
                    {{-- <label for="">Description</label>
                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="Description"></textarea>
                    <p class="text-danger description_error"></p> --}}
                    
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="clonePsychomotorBaseBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Psychomotro Modal-->




<!-- create psycho modal  -->
<div class="modal fade" id="createPsychomotorKeyModal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">Create Extra Curricular Keys</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createPsychomotorkeyForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <select type="text" name="category" class="form-control" id="cpkCategorySelect2" required>
                            </select>
                            <p class="text-danger category_error"></p>
                            
                        </div>
                        <div class="col-md-6">
                            <select name="psychomotor_pid" id="psychomotorkeySelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger psychomotor_pid_error"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                             <input type="text" name="title[]" class="form-control form-control-sm" placeholder="Enter Key">
                            <i class="bi bi-x-circle-fill text-danger hidden-item mx-1"></i>
                        </div>
                        <p class="text-danger title_error"></p>
                    </div>
                    <div id="moreKeys"></div>
                    <button id="addMoreKey" type="button" class="btn btn-danger btn-sm btn-sm m-1">Add More</button>
                    
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="createPsychomotorkeyBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Psychomotro Modal-->

<!-- psycho grade modal  -->
<div class="modal fade" id="createPyschoGradeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create GD</h5>
                <div class="text-center">
                    <button id="addMore" type="button" class="btn btn-danger btn-sm btn-small m-3">Add More Row</button><br>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="createPyschoGradeForm">
                    @csrf
                    <i id="moreRows"></i>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="title">Grade</label>
                            <input type="text" name="grade[]" class="form-control form-control-sm" placeholder="CY grade">
                            <p class="text-danger grade_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="score">Score</label>
                            <div class="input-group mb-3">
                                <input type="number" name="score[]" class="form-control form-control-sm" placeholder="obtainable score" required>
                                <p class="text-danger score_error"></p>
                                <i class="bi bi-x-circle-fill text-white m-2"></i>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createPyschoGradeBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End psycho grade Modal-->


<script>
    $(document).ready(function() {
        $('#addMoreExtra').click(function(){
            $('#moreExtra').append(`
                 <div class="row">
                        <div class="col-md-7">
                            <label for="">Extra Curricular Name</label>
                            <input type="text" name="psychomotor[]" class="form-control form-control-sm" placeholder="Create Base Psychomotor">
                            <p class="text-danger psychomotor_error"></p>
                        </div>
                        <div class="col-md-5">
                            <label for="">Maximum Score</label>
                            <div class="input-group">
                                <input type="number" name="score[]" class="form-control form-control-sm" placeholder="obtainable score" required>
                                <i class="bi bi-x-circle-fill text-danger pointer removeExtraKey mx-1"></i>
                            </div>
                            <p class="text-danger score_error"></p> 
                        </div>
                    </div>
            `)
        })

         $(document).on('click', '.removeExtraKey', function() {
            $(this).parent().parent().parent().remove();
        });


        $('#addMoreKey').click(function(){
            $('#moreKeys').append(`
                <div class="form-group">
                        <div class="input-group">
                             <input type="text" name="title[]" class="form-control form-control-sm" placeholder="Enter Key">
                            <i class="bi bi-x-circle-fill text-danger removeKey pointer mx-1"></i>
                        </div>
                        <p class="text-danger title_error"></p>
                    </div>
            `)
        })

         $(document).on('click', '.removeKey', function() {
            $(this).parent().parent().remove();
        });

        multiSelect2('#cpbfCategorySelect2', 'createPsychomotorBaseModal', 'category', 'Select Category');
        multiSelect2('#cpkCategorySelect2', 'createPsychomotorKeyModal', 'category', 'Select Category');
        $('#cpkCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#psychomotorkeySelect2', 'createPsychomotorKeyModal', 'psychomotors', id, 'Select Psychomotor');
        });


        multiSelect2('#cloneToCategorySelect2', 'clonePsychomotorBaseModal', 'category', 'Select Category');
        multiSelect2('#cloneFromCategorySelect2', 'clonePsychomotorBaseModal', 'category', 'Select Category');

        $('#cloneFromCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#clonePsychomotorSelect2', 'clonePsychomotorBaseModal', 'psychomotors', id, 'Select Psychomotor');
        });
        // psychomotor-dataTable
        loadBase()
        function loadBase(){
            $('#psychomotorBaseDataTable').DataTable({
            "processing": true,
            "serverSide": true,
           
            // ->rawColumns(['data', 'action'])
            responsive: true,
            "ajax": "{{route('load.psychomotor.base')}}",
            "columns": [
                
            
                {
                    "data": "category"
                },
               
                {
                    "data": "psychomotor"
                },
               
                // {
                //     "data": "status"
                // },
                {
                    "data": "obtainable_score"
                },
                {
                    "data": "grade"
                },
                //  {
                //     "data": "description"
                // },
                // {
                //     "data": "created_at"
                // },

                // {
                //     "data": "username"
                // },
                // {
                //     "data": "action"
                // },
            ],
        });
        }
        // psychomotor-dataTable

        $('#psychomotoKey-tab').click(function() {
            loadPsychomotorKeys()
        })

        $('#psychomotorBaseSelect2').change(function() {
            let id = $(this).val();
            loadPsychomotorKeys(id)
        })

        // psychomotor-dataTable
        $('#psychoGradeDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            // ->rawColumns(['data', 'action'])
            responsive: true,
            "ajax": "{{route('load.psycho-grade')}}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    // orderable: false,
                    // searchable: false
                },
                {
                    "data": "grade"
                },
                {
                    "data": "score"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "username"
                },

            ],
        });

        // create psychomotor  
        $('#createPsychomotorBaseBtn').click(async function() {
            let sts = await  submitFormAjax('createPsychomotorBaseForm', 'createPsychomotorBaseBtn', "{{route('create.psychomotor.base')}}")
            if(sts.status ===1){
                loadBase(id)
            }
        });
        
        // clone psychomotor  
        $('#clonePsychomotorBaseBtn').click(async function() {
            let sts = await  submitFormAjax('clonePsychomotorBaseForm', 'clonePsychomotorBaseBtn', "{{route('clone.psychomotor.base')}}")
            if(sts.status ===1){
                loadBase(id)
            }
        });

        $('#createPsychomotorkeyBtn').click(function(e) {
            e.preventDefault()
            submitFormAjax('createPsychomotorkeyForm', 'createPsychomotorkeyBtn', "{{route('create.psychomotor.key')}}")
        });

        FormMultiSelect2('#psychomotorBaseSelect2', 'psychomotors-all', 'Select Psychomotor name');//load all psycho
        multiSelect2('#psychomotorkeySelect2', 'createPsychomotorKeyModal', 'psychomotors', 'Select Psychomotor name');


        // add more title 
        $('#addMore').click(function() {
            $('#moreRows').prepend(
                `
                 <div class="row addedRow">
                        <div class="col-md-6">
                            <label for="title">Grade</label>
                            <input type="text" name="grade[]" class="form-control form-control-sm" placeholder="CY grade">
                            <p class="text-danger grade_error"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="score">Score</label>
                           <div class="input-group mb-3">
                            <input type="number" name="score[]" class="form-control form-control-sm" placeholder="obtainable score" required>
                            <i class="bi bi-x-circle-fill text-danger m-2 removeRowBtn"></i>
                            </div>
                            <p class="text-danger score_error"></p>
                        </div>
                    </div>
                `
            );
            // init select2 again 
        });

        $(document).on('click', '.addedRow .removeRowBtn', function() {
            $(this).parent().parent().parent().remove();
        });
        // create psycho grade  
        $('#createPyschoGradeBtn').click(function(e) {
            e.preventDefault()
            submitFormAjax('createPyschoGradeForm', 'createPyschoGradeBtn', "{{route('create.psycho.grade')}}")
        });

    });

    function loadPsychomotorKeys(pid = null) {
        $('#psychomotorKeyDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            // ->rawColumns(['data', 'action'])
            responsive: true,
            destroy: true,
            "ajax": {
                url: "{{route('load.psychomotor.key')}}",
                type: "post",
                data: {
                    _token: "{{csrf_token()}}",
                    pid: pid
                }
            },
            "columns": [
                
                {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                {
                    "data": "category"
                },
                {
                    "data": "title"
                },
                // {
                //     "data": "max_score"
                // },
                // {
                //     "data": "status"
                // },
                // {
                //     "data": "created_at"
                // },
                // {
                //     "data": "username"
                // },
                // {
                //     "data": "action"
                // },
            ],
            "columnDefs": [{
                    "visible": false,
                    "targets": 1
                }],
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
                                '<tr class="group"><td colspan="5"><b>' + group + '</b></td></tr>'
                            );

                            last = group;
                        }
                    });
                }
        });
    }
</script>
@endsection