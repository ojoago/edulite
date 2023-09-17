@extends('layout.mainlayout')
@section('title','Mark Assessment')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title mr-4">Assessment: {{$data->arm}} | {{$data->subject}} | {{$data->term}}, {{$data->session}}</h5>

        <fieldset class="border rounded-3 p-3">
            <legend class="float-none w-auto px-3">{{$data->title}} | Submitted: <span class="text-danger">{{$questions[0]->submitted_date}}</span> </legend>
            <form class="row g-3 needs-validation" id="submitAssessmentForm">
                @csrf
                <div class="col-md-12" id="fieldQuestions">
                    <input type="hidden" value="{{$questions[0]->student_pid}}" name="std">
                    @foreach($questions as $row)
                    <input type="hidden" name="question_pid[]" value="{{$row->question_pid}}">
                    <fieldset class="border rounded-3 px-2">
                        <legend class="float-none w-auto px-3">Question {{$loop->iteration}} {{$row->mark ? '| '.$row->mark .'Mark(s)' :''}}</legend>
                        @if($data->type == 1)
                        @php $path = $row->path ? $row->path : '#' @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{asset($path)}}" download>
                                    <button type="button" class="btn btn-success btn-sm m-2">
                                        Download Answer
                                    </button>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <input type="number" step="0.01" name="mark[]" value="" placeholder="enter Score" class="form-control from-control-sm">
                            </div>
                        </div>

                        @php $link = $row->link ? $row->link : '#' @endphp
                        <a href="{{asset($link)}}" download>
                            <button type="button" class="btn btn-secondary btn-sm m-2">
                                Download Question
                            </button>
                        </a>
                        @elseif($data->type == 2)
                        <p> {!!$row->question!!}</p>
                        <label class="form-label"> {!! $row->answer !!}</label>
                        <p class="text-danger note_error"></p>
                        <input type="number" step="0.01" name="mark[]" value="" placeholder="enter Score" class="form-control from-control-sm m-1">
                        @else
                        @php
                        $options = json_decode($row->options);
                        $answers = json_decode($row->answer);
                        $correct = false;
                        @endphp
                        @if(isset($options))
                        {!!$row->question!!}
                        <hr>
                        @foreach($answers as $an)

                        @foreach($options as $opn)
                        @if($opn->id == $an)
                        {{$opn->option}}
                        @if($opn->correct)
                        <i class="bi bi-check-circle text-success"></i>
                        @else
                        <i class="bi bi-asterisk text-danger"></i>
                        @endif
                        <br>

                        @endif
                        @endforeach
                        @endforeach
                        @endif
                        @endif
                    </fieldset>
                    @endforeach
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" id="submitAssessmentBtn">Submit</button>
                    <button type="button" class="btn btn-warning btn-sm"><a href="{{route('class.assignment.form')}}">Back</a></button>
                </div>
            </form>
        </fieldset>


    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {
        $('.summer-note').summernote({
            fontsize: '14'
        })



        $('#submitAssessmentBtn').click(function() {
            submitFormAjax('submitAssessmentForm', 'submitAssessmentBtn', "{{route('mark.student.assessment')}}")
        });

    });
</script>
@endsection