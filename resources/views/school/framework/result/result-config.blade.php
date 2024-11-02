@extends('layout.mainlayout')
@section('title','Result Configuration')
@section('content')
<style>
    .template-img{
        height: 200px;
        width: auto;
    }
    .chart-img{
        max-height: 90%;
        width:auto;
        max-width: 90%;
    }
    .template-img:hover{
        height: auto;
        width: auto;
    }
</style>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Result Configuration</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="template-tab" data-bs-toggle="tab" data-bs-target="#template-justified" type="button" role="tab">Template</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-justified" type="button" role="tab">Content</button>
            </li>

        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="template-justified" role="tabpanel" aria-labelledby="template-tab">
                @php
                    $k = 0
                @endphp
                @foreach ($categories as $item)
                     <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-heading{{$item->pid}}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapse{{$item->pid}}" aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseOne">
                                                {{$item->category}}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapse{{$item->pid}}"
                                            class="accordion-collapse collapse {{$k==0 ?'show' : ''}}"
                                            aria-labelledby="panelsStayOpen-headingOne">
                                            <div class="accordion-body">
                                                <form action="" id="tempForm{{$item->pid}}">
                                                    @csrf 
                                                    @php
                                                        $n = 0;
                                                    @endphp
                                                    @foreach ($files as $file)
                                                    @php
                                                        echo ++$n
                                                    @endphp
                                                        <input type="radio" name="template" {{$file['name'] == $item->file_name ? 'checked': '' }} value="{{$file['name']}}">
                                                        <input type="hidden" name="{{$file['name']}}"  value="{{$item->pid}}">
                                                        <img src="{{asset($file['path'])}}" alt="" class="img img-responsive template-img" id="student-img">
                                                        <hr>
                                                    @endforeach
                                                    <button type="button" class=" btn btn-primary saveTemplate" pid="{{$item->pid}}" id="tempBtn{{$item->pid}}" > Save </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @php
                                    $k++
                                @endphp
                @endforeach
                
            </div>
            <div class="tab-pane fade" id="content-justified" role="tabpanel" aria-labelledby="content-tab">
                @php
                    $k=0;
                @endphp
               @foreach ($categories as $item)
                     <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen{{$item->pid}}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-{{$item->pid}}" aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseOne">
                                                {{$item->category}}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-{{$item->pid}}"
                                            class="accordion-collapse collapse {{$k==0 ?'show' : ''}}"
                                            aria-labelledby="panelsStayOpen-headingOne">
                                            <div class="accordion-body">
                                                <form action="" id="configForm{{$item->pid}}">
                                                    @csrf 
                                                    <input type="hidden" name="category" value="{{$item->pid}}">
                                                    
                                                    <fieldset class="border rounded-3 p-3">
                                                        <legend class="float-none w-auto px-3"> Key Wards</legend>
                                                        
                                                        <div class="form-group">
                                                            <label for="">Result Title</label>
                                                            <input type="text" name="title" value="{{@$item->title ?? ''}}" class="form-control form-control-sm" placeholder="e.g Continuous Assessment Report" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Pass Mark</label>
                                                            <input type="number" step="0.5" name="pass_mark" value="{{@$item->pass_mark ?? 40}}" class="form-control form-control-sm" placeholder="e.g Pass Mark" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Student Name</label>
                                                            <input type="text" name="student_name" value="{{@$item->student_name  ?? ''}}" class="form-control form-control-sm" placeholder="e.g Name of Student" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Name of Principal/Head</label>
                                                            <input type="text" name="head_teacher" value="{{@$item->head_teacher  ?? ''}}" class="form-control form-control-sm" placeholder="e.g Principal/Head Teacher" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Name of Class Teacher</label>
                                                            <input type="text" name="class_teacher" value="{{@$item->class_teacher  ?? ''}}" class="form-control form-control-sm" placeholder="e.g Class/Form Teacher" >
                                                        </div>
                                                    </fieldset>

                                                        @php
                                                           $setting = json_decode($item->settings) ;
                                                        @endphp
                                                    <fieldset class="border rounded-3 p-3">
                                                        <legend class="float-none w-auto px-3">Show/Hide Column</legend>
                                                        <div class="form-group">
                                                            <label for="">Serial Number</label>
                                                            <input type="checkbox" name="serial_number" {{@$setting->serial_number == 1 ? 'checked' : ''}} value="1" id="">
                                                        </div>                           

                                                        <div class="form-group">
                                                            <label for="">Class Position</label>
                                                            <input type="checkbox" name="class_position" {{@$setting->class_position == 1 ? 'checked' : ''}} value="1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Subject Position</label>
                                                            <input type="checkbox" name="subject_position" {{@$setting->subject_position == 1 ? 'checked' : ''}} value="1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Subject Average</label>
                                                            <input type="checkbox" name="subject_average" {{@$setting->subject_average == 1 ? 'checked' : ''}} value="1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Subject Grade</label>
                                                            <input type="checkbox" name="subject_grade" {{@$setting->subject_grade == 1 ? 'checked' : ''}} value="1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""> Remarks </label>
                                                            <input type="checkbox" name="remark" value="1" {{@$setting->remark == 1 ? 'checked' : ''}}>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Subject Teacher Name</label>
                                                            <input type="checkbox" name="subject_teacher" value="1" {{@$setting->subject_teacher == 1 ? 'checked' : ''}}>
                                                        </div>
                                                     
                                                        <div class="form-group p-4">
                                                            <label for="">Subject Listing Type</label> <br>
                                                            <input type="radio" name="subject_type" value="1" class="mb-2" {{$item->subject_type == '1'? 'checked' : ''}}> Grouped Subject <br>
                                                            
                                                            <input type="radio" name="subject_type" value="2"  class="mb-2" {{$item->subject_type == '2'? 'checked' : ''}}> Individual <br>
                                                            <input type="radio" name="subject_type" value="3"  class="mb-2" {{$item->subject_type == '3'? 'checked' : ''}}> Individual with Group as Heading <br>

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Display Chart</label>
                                                            <input type="checkbox" name="show_chart" value="1" {{@$setting->show_chart == 1 ? 'checked' : ''}}>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Chart Type</label> <br>
                                                            <input type="radio" name="chart" value="line" {{@$setting->chart == 'line'? 'checked' : ''}}> Line Chart <br>
                                                            <img src="{{asset('/files/thumbnail/line-chart.png')}}" alt="" class="chart-img"> <br>
                                                            
                                                            <input type="radio" name="chart" value="column" {{@$setting->chart == 'column'? 'checked' : ''}}> Column Chart <br>
                                                            <img src="{{asset('/files/thumbnail/column-chart.png')}}" alt="" class="chart-img">

                                                        </div>
                                                        

                                                    </fieldset>

                                                    <button type="button" class=" btn btn-primary saveConfig" pid="{{$item->pid}}" id="configBtn{{$item->pid}}" > Save </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @php
                                    $k++
                                @endphp
                @endforeach
                
                
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>

<script>
    $(document).ready(function(){
        $('.saveTemplate').click(function(){
            let id = $(this).attr('pid');
            var route = "{{route('save.template')}}";
            submitFormAjax('tempForm'+id, 'tempBtn'+id, route);
        })
        $('.saveConfig').click(function(){
            let id = $(this).attr('pid');
            var route = "{{route('save.config')}}";
            submitFormAjax('configForm'+id, 'configBtn'+id, route);
        })
    })
</script>

@endsection