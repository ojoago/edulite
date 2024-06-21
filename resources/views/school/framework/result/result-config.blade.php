@extends('layout.mainlayout')
@section('title','Result Configuration')
@section('content')

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
                                                    @php
                                                        $n = 0;
                                                    @endphp
                                                    @foreach ($files as $file)
                                                    @php
                                                        echo ++$n
                                                    @endphp
                                                        <input type="radio" name="{{$item->pid}}" id="">
                                                        <input type="hidden" name="template" value="{{$file['name']}}">
                                                        <img src="{{asset($file['path'])}}" alt="" class="img img-responsive" id="student-img">
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
               
                
            </div>

        </div><!-- End Default Tabs -->

    </div>
</div>

<script>
    $(document).ready(function(){
        $('.saveTemplate').click(function(){
            alert()
        })
    })
</script>

@endsection