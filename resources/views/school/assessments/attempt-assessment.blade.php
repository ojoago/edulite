@extends('layout.mainlayout')
@section('title','Attemt Assessment')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title mr-4">Assessment: {{$data->arm}} | {{$data->subject}} | {{$data->term}}, {{$data->session}}</h5>

        <fieldset class="border rounded-3 p-3">
            <legend class="float-none w-auto px-3">{{$data->title}} Deadline: <i class="text-danger">{{$data->end_date}}</i> </legend>

            <form class="row g-3 needs-validation" id="submitAssessmentForm">
                @csrf
                <div class="col-md-12" id="fieldQuestions">
                    <input type="hidden" value="{{$std}}" name="std">
                    @foreach($questions as $row)
                    <fieldset class="border rounded-3 px-2">
                        <legend class="float-none w-auto px-3">Question {{$loop->iteration}} | {{$row->mark}} Mark</legend>
                        @php $options = json_decode($row->options) @endphp
                        @if(isset($options))
                        {!!$row->question!!}
                        @php shuffle($options) @endphp
                        @foreach($options as $opn)
                        <input type="{{$row->type==2 ? 'checkbox': 'radio'}}" class="optionAnswer0 m-2 answer" value="{{$opn->id}}" name="answer[{{$row->pid}}][]">
                        {{$opn->option}}<br>
                        @endforeach
                        @else

                        <label class="form-label"> {!!$row->question!!}</label>
                        <input type="hidden" name="pid[]" value="{{$row->pid}}">
                        <textarea type="text" class="form-control form-control-sm summer-note" name="answer[{{$row->pid}}][]" id="newAssignmentNote" placeholder="Type answer"></textarea>
                        <p class="text-danger note_error"></p>
                        @endif
                    </fieldset>
                    @endforeach
                </div>

                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="submitAssessmentBtn">Submit</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </form>
        </fieldset>


    </div>
</div>



<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {
        $('.summer-note').summernote()



        $('#submitAssessmentBtn').click(function() {
            submitFormAjax('submitAssessmentForm', 'submitAssessmentBtn', "{{route('submit.assessment')}}")
        });

    });
</script>
@endsection