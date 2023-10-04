@extends('layout.mainlayout')
@section('title','Attempt Assessment')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title mr-4">Assessment: {{$data->arm}} | {{$data->subject}} | {{$data->term}}, {{$data->session}}</h5>

        <fieldset class="border rounded-3 p-3">
            <legend class="float-none w-auto px-3">{{$data->title}} | Deadline: <span class="text-danger">{{$data->end_date}}</span> </legend>

            <form class="row g-3 needs-validation" id="submitAssessmentForm">
                @csrf
                <div class="col-md-12" id="fieldQuestions">

                    @foreach($questions as $row)
                    <fieldset class="border rounded-3 px-2">
                        <legend class="float-none w-auto px-3">Question {{$loop->iteration}} {{$row->mark ? '| '.$row->mark .' Mark(s)' :''}}</legend>
                        @if($data->type ==1)

                        @php continue @endphp
                        @endif
                        @php
                        $options = json_decode($row->options);
                        $answers = json_decode($row->answer);
                        
                        @endphp
                        @if(isset($options))
                        {!!$row->question!!}
                        <hr>
                        @foreach($options as $key => $opn)
                        @foreach($answers->choice as $an)
                        @if($opn->id == $an)
                        <input type="{{$row->type==2 ? 'checkbox': 'radio'}}" class="optionAnswer0 m-2 answer big-check" checked>
                        {{$opn->option}}

                        @if($answers->correct)
                        <i class="bi bi-check-circle text-success"></i>
                        @else
                        <big><i class="bi bi-x text-danger"></i></big>
                        @endif
                        <br>

                        @php continue 2 @endphp
                        @endif
                        @endforeach
                        <input type="{{$row->type==2 ? 'checkbox': 'radio'}}" class="optionAnswer0 m-2 answer big-check">
                        {{$opn->option}} <br>
                        @endforeach

                        @else

                        <label class="form-label"> {!!$row->question!!}</label>
                        <p class="form-label"> {!!$row->answer!!}</p>

                        @endif
                    </fieldset>
                     
                    @endforeach
                    array_sum($questions->score)
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close"><a href="{{route('student.assessment')}}">Cancel</a></button>
                </div>
            </form>
        </fieldset>


    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.min.js" defer></script> -->

<script>
    $(document).ready(function() {
        // $('.summer-note').summernote({
        //     fontsize: '14'
        // })



        $('#submitAssessmentBtn').click(function() {
            submitFormAjax('submitAssessmentForm', 'submitAssessmentBtn', "{{route('submit.assessment')}}")
        });

    });
</script>
@endsection