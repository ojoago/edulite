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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAssessmentModal">
                    Create Assessment
                </button>
            </div>
            <div class="tab-pane fade" id="bordered-justified-scoreSetting" role="tabpanel" aria-labelledby="scoreSetting-tab">
                <!-- Create Session -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createscoreSettingModal">
                    Create Score Setting
                </button>
            </div>

        </div><!-- End Bordered Tabs Justified -->

    </div>
</div>
<div class="modal fade" id="createAssessmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Assessment Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <input type="text" name="title" placeholder="ass title" required><br>
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <input type="text" name="category" placeholder="ass cat" required><br>
                    @error('category')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <input type="text" name="description" placeholder="ass dsc" required><br>
                    @error('description')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <button type="submit">Create</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->


<div class="modal fade" id="createscoreSettingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Active Academic Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('school.score.settings')}}" method="post">

                    @csrf
                    <select type="text" name="assessment_type_pid" placeholder="" required>
                        <option disabled selected>Select Title</option>
                        @foreach($data as $row)
                        <option value="{{$row->pid}}">{{$row->title}}</option>
                        @endforeach
                    </select><br>
                    @error('assessment_type_pid')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <select type="text" name="session_pid" placeholder="" required>
                        <option disabled selected>Select Title</option>
                        @foreach($session as $row)
                        <option value="{{$row->pid}}">{{$row->session}}</option>
                        @endforeach
                    </select><br>
                    @error('session_pid')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <select type="text" name="class_arm_pid" placeholder="" required>
                        <option disabled selected>Select Title</option>
                        @foreach($arm as $row)
                        <option value="{{$row->pid}}">{{$row->arm}}</option>
                        @endforeach
                    </select><br>
                    @error('class_arm_pid')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <select type="text" name="term_pid" placeholder="" required>
                        <option disabled selected>Select Title</option>
                        @foreach($term as $row)
                        <option value="{{$row->pid}}">{{$row->term}}</option>
                        @endforeach
                    </select><br>
                    @error('term_pid')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <input type="text" name="score" required><br>
                    <input type="text" name="type" required><br>
                    <input type="text" name="order" required><br>
                    <button type="submit">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

@endsection
<!-- <h1>education is light hence EduLite</h1> -->