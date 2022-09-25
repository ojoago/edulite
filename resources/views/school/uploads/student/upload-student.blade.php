@extends('layout.mainlayout')
@section('title','Upload Students')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Upload Student</h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" id="createStudentForm">
            @csrf
            <div class="col-md-6">
                <label for="state" class="form-label">Session </label>
                <select name="session_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="sessionSelect2" required>
                </select>
                <p class="text-danger session_pid_error"></p>
            </div>
            <div class="col-md-6">
                <label for="term_pid" class="form-label">Term</label>
                <select name="term_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="tmSelect2" required>
                </select>
                <p class="text-danger term_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="category_pid" class="form-label">Category</label>
                <select name="category_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="cateSelect2" required>
                </select>
                <p class="text-danger category_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="class_pid" class="form-label">Class</label>
                <select name="class_pid" style="width: 100%;" class="form-select form-select-sm readOnlyProp" id="classSelect2" required>
                </select>
                <p class="text-danger class_pid_error"></p>
            </div>
            <div class="col-md-4">
                <label for="arm_pid" class="form-label">Class Arm</label>
                <select name="arm_pid" class="form-select form-select-sm readOnlyProp" style="width: 100%;" id="armSelect2" required>
                </select>
                <p class="text-danger arm_pid_error"></p>
            </div>
            
            <div class="text-center">
                <button type="button" class="btn btn-primary" id="createStudentBtn">Create</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
        <!-- End Multi Columns Form -->

    </div>
</div>

@endsection