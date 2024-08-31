<a >
    @if ($data->type == 1)
        <button type="button" class="btn btn-info btn-sm ">
            Download
        </button>
    @else
        <button type="button" class="btn btn-info btn-sm ">
            View
        </button>
    @endif
    
   
</a>

<a >
   
    <button type="button" class="btn btn-warning btn-sm " data-bs-toggle="modal" data-bs-target="#lessonPlanModal{{ $data->pid }}">
        Edit
    </button>
   
</a>

<a >
   
    <button type="button" class="btn btn-danger btn-sm deletePlan" pid="{{ $data->pid }}">
        Delete
    </button>
</a>



<div class="modal fade" id="lessonPlanModal{{ $data->pid }}" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lesson Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="" id="lessonPlanForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <select name="category_pid" id="planCategorySelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger category_pid_error"></p>
                        </div>
                        <div class="col-md-4">
                            <select name="class_pid" id="planClassSelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger class_pid_error"></p>
                        </div>
                        <div class="col-md-4">
                            <select name="arm_pid" id="planArmSelect2" class="form-control form-control-sm">
                            </select>
                            <p class="text-danger arm_pid_error"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="arm">Subject</label>
                            <select type="text" name="subject_pid" id="planArmSubjectSelect2" placeholder="class arm" class="form-control form-control-sm" required>
                            </select>
                            <p class="text-danger subject_pid_error"></p>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Week</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $data->week }}" name="week" id="week" placeholder="e.g 3">
                            <p class="text-danger week_error"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Period</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $data->period }}" name="period" id="period" placeholder="e.g 3">
                            <p class="text-danger period_error"></p>
                        </div>
                    
                        <div class="col-md-4">
                            <label class="form-label">Type</label><br>
                            Upload <input type="radio" class="radio assessmentType" {{ $data->type == 1 ? 'checked' : '' }} name="type" id="planType" value="1">
                            In App <input type="radio" class="radio assessmentType" {{ $data->type == 2 ? 'checked' : '' }} name="type" id="planType" value="2">
                            <p class="text-danger type_error"></p>
                        </div>

                    </div>
                    <div class="col-md-12" id="lessonText" style="display:none">
                            <label class="form-label">Lesson Plan</label>
                            <textarea name="plan" class="form-control form-control-sm summer-note">{{ $data->plan }}</textarea>
                            <p class="text-danger plan_error"></p>
                        </div>
                      
                        <div class="col-md-12" style="display:none" id="lessonFile">
                            <label class="form-label">File</label>
                            <input type="file" accept=".pdf,.docs,.doc" name="file" class="form-control form-control-sm">
                            <p class="text-danger file_error"></p>
                        </div>
                </form>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="lessonPlanBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>