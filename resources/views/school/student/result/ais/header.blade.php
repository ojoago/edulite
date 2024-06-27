<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{env('APP_NAME',APP_NAME)}} - {{$std->fullname}} Report Card</title>
    <meta content="description" name="Upgrade your school with edulite suite, 
                                    and ease the stress of school manual process at less cost.
                                     get accurate and accessible information about students, staff remotely.
                                      Allow guardian/parent keep track of their childrens performance easily 
                                      and at you their own time and convenience. EduLite manage school process 
                                      such as report card, performance charts, attendance, student promotion, 
                                      automated principal comment, hostel/portals, student pick up rider, 
                                      event notification such as holidays, notify parent student exam timetable">
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
    <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/css/custom/style.css')}}" rel="stylesheet">
</head>

    <style>
        *{
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif
        }
        body {
            margin: 20px 160px;
        }

        body::before {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{asset("/files/logo/".$school->school_logo)}}') no-repeat center center;
            background-size: 50%;
            opacity: 0.2; /* Adjust the opacity as needed */
            z-index: -1;
        }
        .top-header{
            display: flex;
        }

        .logo-side{
            flex-basis: 25%;
        }
        .text-content{
            flex-basis: 50%;
            color: #000;
        }
        .school-name{
            font-weight: bold;
        }

        #moto{
            border: solid 3px #0001;
            padding: 5px;
            background: rgb(117, 75, 88);
            color: #fff;
        }

        .address-side{
            flex-basis: 25%;
            font-size: 9px;
            font-weight: bold;
        }


        table {
            border-spacing: 5px;
            font-family: Calibri, sans-serif

        }


           #studentDetailTable{
        border: solid 1px #000;
    }
    #studentDetailTable tr td{
        border: solid 1px #f1ff;
    }

    .psychoTable{
        border: solid 1px #000;
        margin-bottom: 15px;
    }
    .psychoTable tr th{
        background: #000;
        color: #fff;
        text-align: center;

    }
    .psychoTable tr td{
        border: solid 1px #000;
        text-align: center;
    }

    #teacherTable{
        border: solid 1px #000;
    }
    
    #teacherTable tr td{
        border: solid 1px #000;
    }

.rating{
    margin-bottom: 10px;
}
#examTable{

}
#examTable{
        border: solid 1px #000;
        margin-bottom: 15px;
    }
    #examTable tr th{
        background: #000;
        color: #fff;
        text-align: center;

    }
    #examTable tr td{
        border: solid 1px #000;
        text-align: center;
    }


        .rotate-up {
            vertical-align: bottom;
            text-align: center;
            /* font-weight: normal; */
        }

        .rotate-up {
            -ms-writing-mode: tb-rl;
            -webkit-writing-mode: vertical-rl;
            writing-mode: vertical-rl;
            /* translate(25px, 51px) // 45 is really 360-45 */
            /* rotate(315deg); */
            /* transform: rotate(315deg) translate(25px, 51px); */
            white-space: nowrap;
            /* overflow: hidden; */
            /* width: 25px; */
            transform: rotate(180deg);
            /* height: 150px; */
            width: 30px;
            /* transform-origin: left bottom; */
            /* box-sizing: border-box; */
        }

        .signature-container{
           display: flex;
            align-items: center;
        }
        .signature-base {
            width: 60px !important;
            align-items: center;
            justify-content: center;
        }

        
        .signature-base>img {
            width: 100%;
            margin-left: 15px;
        }

  



 </style>


<body>
    
<div class="top-header">
    <div class="logo-side">
        <img src="{{asset("/files/logo/".$school->school_logo)}}" alt="logo" >
    </div>
    <div class="text-content">
        <h3 class="school-name">{{strtoupper(getSchoolName())}}</h3>
        <small id="moto">{{@$school->school_moto}}</small>
        
    </div>
    <div class="address-side">
       <p>{{$school->school_address}}</p>
        Tel: <span>{{$school->school_contact}}</span>
        {{-- <p>{{$school->school_email}}</p> --}}
    </div>
</div>