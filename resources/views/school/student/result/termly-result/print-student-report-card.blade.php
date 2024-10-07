<!DOCTYPE html>
<html lang="en">
<style>
    button{
        display: none !important;
    }
</style>
<body onload="printPage()">
   
    @include($path,[ 'subResult' => $subResult, 'std' => $std, 'scoreSettings' => $scoreSettings, 'param' => $param,
            'psycho' => $psycho, 'result' => $result, 'grades' => $grades, 'school' => $school, 'terms' => $terms, 'result_config' => $result_config
        ])
   
{{-- <a href="{{route('student.report.card.pdf',['param'=>$param , 'pid' => $std->pid])}}"> <button class="btn btn-primary m-2">Print</button> </a> --}}
<button onclick="history.back()" class="btn btn-primary m-2">Back </button>
   
</body>
     <script src="{{asset('js/jquery.3.7.0.min.js')}}"></script>
<script>
    // window.print();
    function printPage() {
        // Trigger the print dialog
        window.print();
    }
</script>

</html>
