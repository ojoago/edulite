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
        body {
            margin: 20px 160px;
        }

        .flex-container,
        .flex-row {
            display: flex;
            justify-content: space-between;
            /* flex-wrap: wrap; */
            align-items: flex-start;
        }

        .text-content {
            flex-basis: 60%;
            text-align: center;
        }

        .text-content>.h4,
        .text-content>.h3 {
            margin-bottom: 1px;
        }

        .text-content>p {
            margin: 1px;
            font-size: small;
        }

        .logo-image {
            width: 100px !important;
            border-radius: 15px;
        }

        .logo-image>img {
            width: 100%;
        }

        .flex-row {
            /* height: 200px; */
            justify-content: space-between;
        }

        .personal-detail,
        .flex-col {
            flex-basis: 40%;
            margin: 3px;
            /* justify-content: space-between; */
        }

        .student-img {
            flex-basis: 15%;
            border-radius: 5px;
            align-items: center;
            justify-content: center;
            border: 1px solid #000;
            max-height: 200px;
        }

        .student-img>img {
            width: 100%;
            height: 100%;
        }

        .signature-base {
            width: 60px !important;
            align-items: center;
            justify-content: center;
        }

        .signature-base>img {
            width: 100%;
        }


        table {
            /* background: #fff; */
            /* box-shadow: 0 0 0 10px #fff; */

            /* width: calc(100% - 20px); */
            border-spacing: 5px;
        }

        tr>th,
        tr>td {
            padding: 5px !important;
        }

        .flat-row {
            padding: 3px !important;
            width: auto !important;
            /* padding-right: 0 !important; */
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

        @media screen and (max-width:560px) {
            .student-img {
                border: none !important;
                display: none !important;
            }

            .flex-container {
                flex-direction: column !important;
            }

            .examTable {
                width: 100% !important;
            }

            body {
                margin: 1px;
            }
        }

        @media print {

            .header,
            #header,
            button {
                display: none !important;
            }

            .rotate-up {
                vertical-align: bottom !important;
                height: 120px;
                text-align: center !important;
            }

            .rotate-up {
                -ms-writing-mode: tb-rl !important;
                -webkit-writing-mode: vertical-rl !important;
                writing-mode: vertical-rl !important;
                white-space: nowrap !important;
                transform: rotate(90deg) !important;
                width: 30px !important;
                transform: translate(45px, -20px)
            }

            .student-img {
                border: none;
            }

            #column_Chart {
                width: auto;
            }
        }
    </style>


<body>

<div class="flex-row">
    <div class="img-left logo-image">
        <img src="{{asset("/files/logo/".$school->school_logo)}}" alt="" class="img img-responsive">
    </div>
    <div class="text-content">
        <h3 class="text-success h4">{{strtoupper(getSchoolName())}}</h3>
        <small>{{@$school->school_moto}}</small>
        
    </div>
    <div class="img-left logo-image">
       <p>{{$school->school_address}}</p>
        <span>{{$school->school_contact}}</span>
        {{-- <p>{{$school->school_email}}</p> --}}
    </div>
</div>