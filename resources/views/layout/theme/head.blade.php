<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{env('APP_NAME', 'EuLite')}} - @yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('files/edulite/edulite favicon.png')}}" rel="icon">
  <link href="{{asset('files/edulite/edulite favicon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('themes/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <!-- <link href="{{asset('themes/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('themes/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('themes/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('themes/vendor/simple-datatables/style.css')}}" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="{{asset('themes/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/jquery-validation/css/screen.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/DataTables/datatables.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{asset('themes/css/custom/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
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