@extends('layout.mainlayout')
@section('title','Attemt Assessment')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <h5 class="card-title mr-4">Assessment: {{$data->arm}} | {{$data->subject}} | {{$data->term}}, {{$data->session}}</h5>

        <fieldset class="border rounded-3 p-3">
            <legend class="float-none w-auto px-3">{{$data->title}} Deadline: <i class="text-danger">{{$data->end_date}}</i> </legend>

            <form class="row g-3 needs-validation" id="automatedAssignmentForm">
                @csrf


                <div class="col-md-12" id="fieldQuestions">
                    @foreach($questions as $row)
                    <fieldset class="border rounded-3 px-2">
                        <legend class="float-none w-auto px-3">Question {{$loop->iteration}}</legend>
                        {!!$row->question!!}
                        @php $options = json_decode($row->options) @endphp
                        @foreach($options as $opn)
                            <input type="{{$row->type==2 ? 'checkbox': 'radio'}}" class="optionAnswer0 m-2 answer" name="answer[{{$row->pid}}][]">
                            {{$opn->option}}<br>
                        @endforeach
                    </fieldset>
                    @endforeach
                </div>

                <div class="text-center">
                    <button class="btn btn-primary" type="button" id="automatedAssignmentBtn">Submit</button>
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



        // $('#automatedAssignmentBtn').click(function() {
        //     submitFormAjax('automatedAssignmentForm', 'automatedAssignmentBtn', "{{route('submit.automated.assignment')}}")
        // });

    });
</script>
@endsection