<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{env('APP_NAME',APP_NAME)}} - @yield('title')</title>
  <meta content="description" name="Upgrade your school with edulite suite, and ease the stress of school manual process at less cost.">
  <meta content="keywords" name="education, edulite, education suite, educate, education is light, secondary school, school, primary school, nursery school">
  <meta content="author" name="edulite">

  <!-- Favicons -->
  <link href="{{asset('files/edulite/edulite drk bg.png')}}" rel="icon">
  <link href="{{asset('files/edulite/edulite drk bg.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('themes/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{asset('themes/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/DataTables/datatables.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{asset('themes/css/custom/style.css')}}" rel="stylesheet">
  <link href="{{asset('themes/css/custom/report-card-style.css')}}" rel="stylesheet">

</head>

<body>
  <!-- spinner  -->
  <div class="overlay">
    <div class="spiner">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>


  <div class="flex-wrapper">
    <!-- logout if seesion expired   -->
    @php signOut() @endphp