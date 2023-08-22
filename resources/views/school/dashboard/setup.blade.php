@extends('layout.mainlayout')
@section('title','School Setup')
@section('content')
<div class="container">

    <div class="modal fade" id="setupModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase text-info">Setup Page </h5>
                </div>
                <div class="modal-body">

                    @if(session('stage')==1)
                    <p class="bg-info text-white">Stage {{session('stage')}} of 6: this is where you will create school head teacher!!</p>
                    @include('layout.forms.principal-form')
                    @endif
                    <div class=" min-vh-50 d-flex flex-column align-items-center justify-content-center">
                        @if(session('stage')==2)
                        <p class="bg-info text-white">Stage {{session('stage')}} of 6: this is where you will create school Term. e.g First term, second term etc</p>
                        <form action="" method="post" class="col-md-6 d-flex flex-column align-items-center justify-content-center" id="createTermForm">
                            @csrf
                            <input type="text" name="term" autocomplete="off" class="form-control" placeholder="lite term e.g first term" required>
                            <p class="text-danger term_error"></p>
                            <textarea type="text" name="description" autocomplete="off" class="form-control" placeholder="lite term description"></textarea>
                            <button type="button" class="btn btn-primary btn-sm" id="createTermBtn">Submit</button>
                        </form>
                        @endif
                        @if(session('stage')==3)
                        <p class="bg-info text-white">Stage {{session('stage')}} of 6: this is where you will create school Session</p>
                        <form action="" method="post" class="" id="createSessionForm">
                            @csrf
                            <input type="text" name="session" autocomplete="off" class="form-control" placeholder="lite session e.g 2021/2022" required>
                            <p class="text-danger session_error"></p>
                        </form>

                        <button type="button" class="btn btn-primary" id="createSessionBtn">Submit</button>
                        @endif
                        @if(session('stage')==4)
                        <p class="bg-info text-white">Stage {{session('stage')}} of 6: this is where you will create Categories. e.g Primary, Nursery etc</p>
                        <form action="" method="post" class="" id="createClassCategoryForm">
                            @csrf
                            <input type="text" name="category" id="categoryName" class="form-control form-control-sm" placeholder="school category" required>
                            <input type="hidden" name="pid" id="categoryPid">
                            <p class="text-danger category_error"></p>
                            <label for="head_pid">Principal/Head</label>
                            <select name="head_pid" id="staffSelect2" style="width: 100%;">
                            </select>
                            <p class="text-danger head_pid_error"></p>
                            <textarea type="text" name="description" id="categoryDescription" class="form-control form-control-sm" placeholder="description" required></textarea>
                            <p class="text-danger description_error"></p>
                        </form>

                        <button type="button" class="btn btn-primary btn-sm" id="createClassCategoryBtn">Submit</button>
                        @endif



                        @if(session('stage')==5)
                        <p class="bg-info text-white">Stage {{session('stage')}} of 6: Here you will create school Subject Types/groups</p>
                        <form method="post" class="createSubjectTypeForm" id="createSubjectTypeForm">
                            @csrf
                            <input type="text" name="subject_type" class="form-control form-control-sm" placeholder="name of Subject" required>
                            <p class="text-danger subject_type_error"></p>
                            <input type="text" name="description" class="form-control form-control-sm" placeholder="Subject Description" required>
                            <p class="text-danger description_error"></p>
                        </form>

                        <button type="button" class="btn btn-primary btn-sm createSubjectTypeBtn" id="createSubjectTypeBtn">Submit</button>
                        @endif
                        @if(session('stage')==6)
                        <p class="bg-info text-white">Stage {{session('stage')}} of 6: Here you will create school Subject Types/groups</p>
                        <form method="post" class="" id="createSchoolCategortSubjectForm">
                            @csrf
                            <select name="category_pid" style="width:100%" class="form-control form-control-sm createSubjectCategorySelect2" id="createSubjectCategorySelect2">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                            <select name="subject_type_pid" style="width:100%" class="form-control form-control-sm createSubjectSubjectTypeSelect2" id="createSubjectSubjectTypeSelect2">
                            </select>
                            <p class="text-danger subject_type_pid_error"></p>
                            <input type="text" name="subject" id="subject" class="form-control form-control-sm" placeholder="subject name" required>
                            <input type="hidden" name="pid" id="pid">
                            <p class="text-danger subject_error"></p>
                            <textarea type="text" name="description" id="description" class="form-control form-control-sm" placeholder="description" required></textarea>
                            <p class="text-danger description_error"></p>
                        </form>

                        <button type="button" class="btn btn-primary btn-sm" id="createSubjectBtn">Submit</button>
                        @endif

                        <form id="setupStepForm" style="display: none;">
                            @csrf
                            <input type="hidden" name="stage" value="{{session('stage')}}">
                            <h3>Completed Step {{session('stage')}} ?</h3>
                            <button type="button" id="setupStepBtn" class="btn btn-small btn-success">Yes</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        $('#setupModal').modal('show');
    });
</script>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // step 1 create principal 
        $('#createStaffBtn').click(async function() {
            let s = await submitFormAjax('createStaffForm', 'createStaffBtn', "{{route('create.staff')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // step 2 create terms 
        $('#createTermBtn').click(async function() {
            let s = await submitFormAjax('createTermForm', 'createTermBtn', "{{route('school.term')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });

        // step 3 create session 
        $('#createSessionBtn').click(async function() {
            let s = await submitFormAjax('createSessionForm', 'createSessionBtn', "{{route('school.session')}}");
            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // step 4 create session 
        $('#createClassCategoryBtn').click(async function() {
            let s = await submitFormAjax('createClassCategoryForm', 'createClassCategoryBtn', "{{route('create.school.category')}}");

            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });

        // step 7 create session 
        $('#createSubjectTypeBtn').click(async function() {
            let s = await submitFormAjax('createSubjectTypeForm', 'createSubjectTypeBtn', "{{route('create.school.subject.type')}}");

            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // step 7 create session 
        $('#createSubjectBtn').click(async function() {
            let s = await submitFormAjax('createSchoolCategortSubjectForm', 'createSubjectBtn', "{{route('create.school.subject')}}");

            if (s.status === 1) {
                $('#setupStepForm').show(500)
            }
        });
        // step 7 create session 
        $('#setupStepBtn').click(async function() {
            let s = await submitFormAjax('setupStepForm', 'setupStepBtn', "{{route('update.setup.stage')}}");

            if (s.status === 1) {
                location.reload()
            }
        });



        // load page content  
        $('#passport').change(function() {
            previewImg(this, '#staffPassport');
        });
        // load page content  
        $('#signature').change(function() {
            previewImg(this, '#staffSignature');
        });
        $('#stamp').change(function() {
            previewImg(this, '#staffStamp');
        });

        state();

        function state(id = null) {
            multiSelect2('#stateSelect2', 'setupModal', 'state', 'Select State of Origin', id);

        }

        function lga(id, pid = null) {
            multiSelect2Post('#lgaSelect2', 'setupModal', 'state-lga', id, 'Select Lga of Origin', pid);
        }
        multiSelect2('#staffSelect2', 'setupModal', 'school-category-head', 'Select Category Head');

        $('#stateSelect2').change(function() {
            var id = $(this).val();
            lga(id);
        });

        multiSelect2('#createSubjectSubjectTypeSelect2', 'setupModal', 'subject-type', 'Select Subject Type');
        multiSelect2('#createSubjectCategorySelect2', 'setupModal', 'category', 'Select Category');
        // FormMultiSelect2('#categorySubjectSelect2', 'category', 'Select Category');
        // multiSelect2('#subjectTeacherSelect2', 'createClassSubjectToTeacherModal', 'school-teachers', 'Select Subject Teacher');

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->