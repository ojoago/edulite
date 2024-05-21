@extends('layout.mainlayout')
@section('title','School Setup')
@section('content')
<div class="container-fluid">

    <fieldset class="border rounded-3 p-1">
        <legend class="float-none w-auto px-3 text-danger">Stage {{session('stage')}} of {{session('total')}} </legend>
        <span class="text-info text-center">{{SETUP_STAGE[session('stage')]}} </span>
        <!-- <hr> -->
        @if(session('stage')==1)
        @include('layout.forms.principal-form')
        @endif
        <div class=" min-vh-50 d-flex flex-column align-items-center justify-content-center">
            @if(session('stage')==2)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createTermModal">
                Create Term
            </button>
            @endif
            @if(session('stage')==3)
            <!-- <p class="bg-info text-white"> </p> -->
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createSessionModal">
                Create Session
            </button>
            @endif
            @if(session('stage')==4)
            <p class="bg-info text-white"> </p>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#setActiveSessionModal">
                Set Active Session
            </button>
            @endif
            @if(session('stage')==5)
            <!-- <p class="bg-info text-white"> this is where you will set school Active/Current Session</p> -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#setActiveTermModal">
                Set Active Term
            </button>
            @endif
            @if(session('stage')==6)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassCategoryModal">
                Create Category
            </button>
            @endif

            @if(session('stage')==7)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassModal">
                Create Class
            </button>

            @endif
            @if(session('stage')==8)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassArmModal">
                Create Class Arm
            </button>
            @endif
            {{-- @if(session('stage')==9)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSubjectTypeModal">
                Create Subject Type
            </button>
            @endif --}}
            @if(session('stage')==9)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-3 " data-bs-toggle="modal" data-bs-target="#createSubjectModal">
                Create Subject
            </button>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#dupSubjectTypeModal">
                Copy Subject Type
            </button>
            @endif
            @if(session('stage')==10)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createArmSubjectModal">
                Add Subjects to Class Arm
            </button>

            @endif
            @if(session('stage')==11)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createAssessmentModal">
                Create Assessment
            </button>

            @endif
            @if(session('stage')==12)
            <!-- <p class="bg-info text-white p-2"> </p> -->
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createScoreSettingModal">
                Create Score Setting
            </button>

            @endif

            <form id="setupStepForm" style="display: none;">
                @csrf
                <input type="hidden" name="stage" value="{{session('stage')}}">
                <h3>Completed Step {{session('stage')}} ?</h3>
                <button type="button" id="setupStepBtn" class="btn btn-small btn-success">Yes</button>
            </form>
        </div>
    </fieldset>

</div>



<script type="text/javascript">
    $(window).on('load', function() {
        $('#setupModal').modal('show');
    });
</script>

<script>
    $(document).ready(function() {

        // step 1 create principal 
        $('#createStaffBtn').click(async function() {
            let s = await submitFormAjax('createStaffForm', 'createStaffBtn', "{{route('create.staff')}}");
            if (s.status === 1) {
                nextStep()
            }
        });
        // step 2 create terms 
        // $('#createTermBtn').click(async function() {
        //     let s = await submitFormAjax('createTermForm', 'createTermBtn', "{{route('school.term')}}");
        //     if (s.status === 1) {
        //         $('#setupStepForm').show(500)
        //     }
        // });

        // step 3 create session 

        // step 4 create session 
        // $('#createClassCategoryBtn').click(async function() {
        //     let s = await submitFormAjax('createClassCategoryForm', 'createClassCategoryBtn', "{{route('create.school.category')}}");

        //     if (s.status === 1) {
        //         $('#setupStepForm').show(500)
        //     }
        // });

        // step 7 create session 
        // $('#createSubjectTypeBtn').click(async function() {
        //     let s = await submitFormAjax('createSubjectTypeForm', 'createSubjectTypeBtn', "{{route('create.school.subject.type')}}");

        //     if (s.status === 1) {
        //         $('#setupStepForm').show(500)
        //     }
        // });
        // step 7 create session 
        // $('#createSubjectBtn').click(async function() {
        //     let s = await submitFormAjax('createSchoolCategortSubjectForm', 'createSubjectBtn', "{{route('create.school.subject')}}");

        //     if (s.status === 1) {
        //         $('#setupStepForm').show(500)
        //     }
        // });
        // step 7 create session 
        $('#setupStepBtn').click(async function() {
            nextStep()
        });


        function nextStep(){
            let s = await submitFormAjax('setupStepForm', 'setupStepBtn', "{{route('update.setup.stage')}}");
            if (s.status === 1) {
                location.reload()
            }
        }

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

        // state();


        state();

        function state(id = null) {
            FormMultiSelect2('#stateSelect2', 'state', 'Select State of Origin', id)
        }

        function lga(id, pid = null) {
            FormMultiSelect2Post('#lgaSelect2', 'state-lga', id, 'Select Lga of Origin', pid)
        }

        $('#stateSelect2').change(function() {
            var id = $(this).val();
            lga(id);
        });


        // FormMultiSelect2('#createSubjectSubjectTypeSelect2',  'subject-type', 'Select Subject Type');
        // FormMultiSelect2('#createSubjectCategorySelect2',  'category', 'Select Category');
        // FormMultiSelect2('#categorySubjectSelect2', 'category', 'Select Category');
        // multiSelect2('#subjectTeacherSelect2', 'createClassSubjectToTeacherModal', 'school-teachers', 'Select Subject Teacher');

    });
</script>
@endsection

<!-- <h1>education is light hence EduLite</h1> -->