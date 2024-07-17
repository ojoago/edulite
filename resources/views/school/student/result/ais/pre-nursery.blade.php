
@include('school.student.result.ais.header')

@php
        $config = $result_config;
        $setting = json_decode($config->settings); 
    @endphp

<hr>

<table id="studentDetailTable">
    <tr>
        <td colspan="2"> <b>PUPIL NAME</b> {{$std->fullname}}</td>
        <td colspan="2"> <b>TERM</b> {{$result->term}}</td>
    </tr>
    <tr>
        <td > <b> GENDER</b> </td>
        <td>{{$std->gender}}</td>
        <td><b>SESSION</b> {{$result->session}}</td>
        <td> <b>NEXT TERM BEGINS:</b> {{formatDate($result->next_term)}} </td>
    </tr>
    <tr>
        <td ><b>HEIGHT</b>  </td>
        <td>{{$std->height}}</td>
        <td><b>WEIGHT</b></td>
        <td>{{$std->weight}}</td>
    </tr>
</table>

<b class="rating">KEY TO RATINGS: 5 - EXCELLENT, 4 - VERY GOOD, 3 - GOOD 2 - FAIR 1 - POOR </b>



      @foreach($psycho as $row)
        @if($row->baseKey->isNotEmpty())
            <table class="psychoTable">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>{{$row->psychomotor}}</th>
                        <th>RATING</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($row->baseKey as $rw)
                    <tr>
                        <td> {{$loop->iteration}} </td>
                        <td> {{$rw->title}} </td>
                        <td>{{getPsychoKeyScore(student:$result->student_pid,param:$param,key:$rw->pid)}} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    {{-- subject result  --}}

    @include('school.student.result.termly-result.subject-table')

    {{-- subject result  --}}

   
    <table id="teacherTable">
        <tr>
            <td colspan="3"><b>Name of Teacher:</b> {{$result->teacher_name}}</td>
        </tr>
        <tr>
            <td colspan="3"><b>Teacher's Comment:</b> {{$result->class_teacher_comment}}</td>
        </tr>
        <tr>
            <td></td>
            <td>
               <div class="bd solid signature-container">
                Signature: 
                <div class="signature-base">
                    @php $imgUrl = $result->signature ? asset("/files/images/".$result->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            </td>
            <td>Date: {{formatDate($result->date)}}</td>
        </tr>

       
        <tr>
            <td colspan="3"><b>Principal's Comment:</b> {{$result->principal_comment}} </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div class="bd solid signature-container">
                Signature: 
                <div class="signature-base">
                    @php $imgUrl = $result->principal_signature ? asset("/files/images/".$result->principal_signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            </td>
            <td>Date: {{formatDate($result->date)}}</td>
        </tr>

    </table>

    
{{-- chart  --}}
@if(@$setting->show_chart== 1)
    @include('school.student.result.termly-result.chart')
@endif 

<a href="{{route('student.report.card.pdf',['param'=>$param , 'pid' => $std->pid])}}"> <button class="btn btn-primary m-2">Print</button> </a>
