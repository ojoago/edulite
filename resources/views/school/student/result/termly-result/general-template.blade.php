
@include('school.student.result.termly-result.template-header')

<style>
    .extra-curricular{
        display: flex;
        justify-content: space-between
    }
    .result-header{

    }

    .f-row,.s-row{
        display: flex;
        justify-content: space-between
    }
    
    .dotted{    
        border-bottom: 2px dotted  #000;
        color: #000;
        margin: 5px 10px;
    }
    .lf{
        flex-basis: 100%;
        text-align: left;
        
    }
    .rt{
        flex-basis: 40%;
        text-align: left;
    }
    .s-row .f1, 
    .s-row .f2, 
    .s-row .f3, 
    .s-row .f4{
        flex-basis: 25%;
        text-align: left;
    }
    .f1,.f2,.f3{
        flex-basis: 33%;
        text-align: left;
    }

    .b-row{
        display: flex;

    }
    .br{
        flex-basis: 100%;
    }
    
    .bd,.bc{
        flex-basis: 50%;
        margin: 5px 10px;

    }
    .solid{
        border-bottom: 1px solid #000;
        margin: 5px 10px;
    }

</style>

<hr>

{{-- reust header  --}}
  @php
        $config = $result_config;
        $setting = json_decode(@$config->settings); 
    @endphp
<div class="result-header">
    <table border="1" cellpadding="pixels" class="table table-hover table-striped table-bordered examTable text-uppercase">
        <tr>
            <td colspan="3">name: {{$std->fullname}}</td>
            <td>Final Grade:</td>
        </tr>
        <tr>
            <td >class: {{$result->arm}}</td>
            <td>total Score.</td>
            <td>{{number_format($result->total,1)}}</td>
            <td>Age: {{dateToAge($std->dob)}} </td>
           
        </tr>
        <tr>
            <td >admission no.: {{$std->reg_number}}</td>
            <td>final average</td>
            <td>{{number_format($result->average,1)}}</td>
            <td></td>
            
        </tr>
        <tr>
            <td >session: {{$result->session}}</td>
            <td>class average</td>
            <td>{{number_format($result->class_average,1)}}</td>
            <td colspan="2" align="center">ATTENDANCE</td>
            
        </tr>
        <tr>
            <td>Term {{$result->term}}</td>
            <td>highest in class </td>
            <td>2</td>
            <td>days open </td>
            <td>112</td>
           
        </tr>
        <tr>
            <td>no. in class</td>
            <td>lowest in class</td>
            <td>4</td>

            <td>days present </td>
            <td>{{ @$result->present }}</td>
           
        </tr>
        <tr>
            <td colspan="3">House</td>
            <td>days absent</td>
            <td>{{ @$result->absent }}</td>
            
        </tr>
    </table>


</div>
    {{-- subject result  --}}

        @include('school.student.result.termly-result.single-subject-table',['subResult'=>$subResult,'setting' =>$setting , 'terms' => $terms, 'grades' => $grades])

    {{-- subject result  --}}

    {{-- extra curricular  --}}

    <div class="extra-curricular">

        @foreach($psycho as $row)
            @if($row->baseKey->isNotEmpty())
                <table class="psychoTable">
                    <thead>
                        <tr>
                            <th>{{$row->psychomotor}}</th>
                            @for ($i = $row->max; $i > 0; $i--)
                                <th>{{$i}}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($row->baseKey as $rw)
                        @php
                            $score = getPsychoKeyScore(student:$result->student_pid,param:$param,key:$rw->pid);
                        @endphp
                        <tr>
                            <td> {{$rw->title}} </td>
                            @for ($i = $row->max; $i > 0; $i--)
                                @if($i == $score)
                                <td> <i class="bi bi-check"></i></td>
                                @else
                                <td></td>
                                @endif
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
        {{-- <div class="legend"></div>
        <div class="rating">

            @include('school.student.result.curricula-type.'.$psycho[0]->grade)
        </div> --}}
    </div>
     <div class="result-footer">
        <div class="b-row">
            <div class="br solid">
               Teacher‘s  Comment: {{$result->class_teacher_comment}}
            </div>
        </div>

        <div class="b-row">
            <div class="bd solid">
                Signature: 
                <div class="signature-base">
                    @php $imgUrl = $result->signature ? asset("/files/images/".$result->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            <div class="bc solid">Date: {{formatDate($result->date)}}</div>
        </div>

        <div class="b-row">
            <div class="br solid">
               Principal’s  Comment: {{$result->principal_comment}}
            </div>
        </div>

        <div class="b-row">
            <div class="bd solid">
                Signature: 
                <div class="signature-base">
                    @php $imgUrl = $result->principal_signature ? asset("/files/images/".$result->principal_signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            <div class="bc solid">Date: {{formatDate($result->date)}} </div>
        </div>
     </div>

{{-- chart  --}}
@if(@$setting->show_chart== 1)
    @include('school.student.result.termly-result.chart')
@endif 

<a href="{{route('student.report.card.pdf',['param'=>$param , 'pid' => $std->pid])}}"> <button class="btn btn-primary m-2">Print</button> </a>
