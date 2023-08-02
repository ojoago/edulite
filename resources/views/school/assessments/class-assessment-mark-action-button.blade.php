@if(schoolTeacher())
<a href="{{route('mark.assessment',['key'=>$data->pid,'std'=>$data->std])}}">
    <button type="button" class="btn btn-primary btn-sm ">
        Mark
    </button>
</a>
<a href="{{route('mark.assessment',['key'=>$data->pid,'std'=>$data->std])}}">
    <button type="button" class="btn btn-success btn-sm ">
        View
    </button>
</a>
@else
<a href="{{route('load.questions',['key'=>$data->pid,'std'=>$data->std])}}">
    <button type="button" class="btn btn-warning btn-sm ">
        <i class="bi bi-edit"></i>
    </button>
</a>

@endif