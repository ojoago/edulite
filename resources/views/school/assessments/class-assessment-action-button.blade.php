@if(schoolTeacher())
<button type="button" class="btn btn-warning btn-sm text-white">
    Edit
</button>
<button type="button" class="btn btn-danger btn-sm deleteAssessment" key="{{$data->pid}}">
    <i class="bi bi-trash"></i>
</button>
@else

    @if($data->end_date >= justDate())
    <a href="{{route('load.questions',['key'=>$data->pid,'std'=>$data->std])}}">
        <button type="button" class="btn btn-success btn-sm ">
            Submit
        </button>
    </a>
    @endif
@endif