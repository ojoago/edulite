<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME',APP_NAME)}}</title>
    <link href="{{asset('themes/css/custom/mail-style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div id="wrapper-inner">
            <table class="main-table">
                <tr>
                    <td class="one-column">
                        <div class="section">
                            <table width="100%">
                                <tr>
                                    <td class="header" style=" background-color: #00AFF0;color:#fff !important;border-bottom: 3px solid #FCBA03;width:100% !important">
                                        <p style="text-align: center;padding: 1%;font-weight: 900;font-size: 11px;text-transform: uppercase;color:#fff !important;">
                                            <a href="#" style="color:#fff !important;">Education is light, hence {{env('APP_NAME',APP_NAME)}}</a>
                                        </p>
                                    </td>
                                </tr>
                                <tr width="100%">
                                    <td width="100%">
                                        <table style="background-color: #f1f1f1;" width="100%">
                                            <tr>
                                                <td class="two-column">
                                                    <img src="{{asset('files/edulite/edulite logo.png')}}" alt="{{env('APP_NAME',APP_NAME)}}">
                                                </td>
                                                <td>
                                                    <h1 style="padding-left: 10px;">
                                                        <span class="ed-color">Learning Today</span>,<br>
                                                        <span class="lite-color">Leading Tomorrow</span>
                                                    </h1>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="inner-td">
                                        <table class="content">
                                            <tr>
                                                <td>
                                                    <h3>{{$param['school']->school_name}}</h3>
                                                    <h4>{{$param['school']->school_address}}</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>{{$param['school']->school_contact}}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="inner-td">
                                        <table class="content">
                                            <tr>
                                                <img src="{{$param['school']->school_logo ? asset('/files/logo/'.$param['school']->school_logo) : asset('/files/thumbnail/teacher.jpeg')}}" alt="{{$param['school']->school_name}} logo">
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                           
               

                <!-- top banner -->


                <!-- outer table 2  -->
                <!-- main table  -->
                <!-- 
            -----
            -----
            -----
            -----
            include footer here 
            -----
            -----
            -----
            ----- 
        -->
                <!-- outer table three  -->