@if(schoolTeacher())
<button type="button" class="btn btn-primary btn-sm ">
    <!-- <i class="bi bi-tools"></i> -->
    Edit
</button>
@else
<a href="{{route('load.questions',['query'=>$data->pid])}}">
    <button type="button" class="btn btn-primary btn-sm ">
        Submit
    </button>
</a>
@endif