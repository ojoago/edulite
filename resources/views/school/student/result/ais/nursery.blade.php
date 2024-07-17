
@include('school.student.result.ais.header',['result_config'=>$result_config,'school'=>$school,'std'=>$std, ])

{{-- extra-curricular --}}
<style>
    .extra-curricular{
        display: flex;
        justify-content: space-between
    }
    .result-header{

    }

    .f-row{
        display: flex;
        justify-content: space-between
    }
    
    .dotted{    
        border-bottom: 2px dotted  #000;
        color: #000;
        margin: 5px 10px;
    }
    .lf{
        flex-basis: 60%;
        text-align: left;
        
    }
    .rt{
        flex-basis: 40%;
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
    }
</style>


{{-- reust header  --}}
@php
    $config = $result_config;
    $setting = json_decode($config->settings); 
@endphp
<div class="result-header">

    <div class="f-row">
        <div class="lf dotted">
            Name of Pupil: {{$std->fullname}}
        </div>
        <div class="rt dotted">Gender: {{$std->gender}} </div>
    </div>

    <div class="f-row">

        <div class="f1 dotted">
            Class: {{$result->arm}}
        </div>
        <div class="f2 dotted">Age: {{dateToAge($std->dob)}}  </div>
        <div class="f3 dotted">Next Term Begins:  {{formatDate($result->next_term)}}</div>
        
    </div>
    <div class="f-row">

        <div class="f1 dotted">
            Class Average: {{number_format($result->class_average,1)}}
        </div>
        <div class="f2 dotted">Personal Total: {{number_format($result->total,1)}}</div>
        <div class="f3 dotted">Personal Average: {{number_format($result->average,1)}} </div>

    </div>

</div>

<span>Keys to Grades: <i>A – Distinction – 70% & Above, C- Credit – 60% to 69%, P- Pass – 40% to 59%, F – Fail below 40%</i></span>

    {{-- subject result  --}}

       @include('school.student.result.termly-result.subject-table',['subResult'=>$subResult,'setting' =>$setting , 'terms' =>$terms])


    {{-- subject result  --}}

    {{-- extra curricular  --}}

    <div class="extra-curricular">
        <div class="legend">
            Key:
            <p>5 - Excellent</p>
            <p>4 - Very Good </p>
            <p>3 - Good</p>
            <p>2 - Fair </p>
            <p>1 - Poor</p>
        </div>
        <div class="rating">
            @include('school.student.result.curricula-type.'.$psycho[0]->grade)
        </div>
    </div>

     <div class="result-footer">
        <div class="b-row">
            <div class="br solid">
               Teacher‘s  Comment: {{$result->class_teacher_comment}}
            </div>
        </div>

        <div class="b-row">
            <div class="bd solid signature-container">
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
             <div class="bd solid signature-container">
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
@if($setting->show_chart== 1)
    @include('school.student.result.termly-result.chart',['subResult'=>$subResult])
@endif 
     
<a href="{{route('student.report.card.pdf',['param'=>$param , 'pid' => $std->pid])}}"> <button class="btn btn-primary btn-sm">Print</button> </a>
