<!DOCTYPE html>
<html lang="en">
<style>
    button{
        display: none !important;
    }
</style>
<body onload="printPage()">
   
    @include($path)
   
   
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
