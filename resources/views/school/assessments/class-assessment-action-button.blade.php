@if(schoolTeacher())
<button type="button" class="btn btn-warning btn-sm text-white">
    Edit
</button>
<button type="button" class="btn btn-danger btn-sm deleteAssessment" key="{{$data->pid}}">
    <i class="bi bi-trash"></i>
</button>
@else

<!-- if deadline never pass  -->
@if($data->end_date >= justDate())
<a href="{{route('load.questions',['key'=>$data->pid,'std'=>$data->std])}}">
    <button type="button" class="btn btn-success btn-sm ">
        Submit
    </button>
</a>
<!-- if assignment is upload  -->
@if($data->type==1)
@php $path = $data->path ? $data->path : '#' @endphp
<a href="{{asset($path)}}" download>
    <button type="button" class="btn btn-secondary btn-sm mt-1">
        Download
    </button>
</a>
@endif
@endif
@endif