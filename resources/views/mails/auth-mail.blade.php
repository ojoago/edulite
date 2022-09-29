<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME',APP_NAME)}}</title>

    <style type="text/css">
        body {
            Margin: 0 !important;
            padding: 15px;
            background-color: #FFF;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
        }

        .wrapper-inner {
            width: 100%;
            background-color: #eee;
            max-width: 670px;
            Margin: 0 auto;
        }

        table {
            border-spacing: 0;
            font-family: sans-serif;
            color: #727f80;
        }

        .outer-table {
            width: 100%;
            max-width: 670px;
            margin: 0 auto;
            background-color: #FFF;
        }

        td {
            padding: 0;
        }

        .header {
            background-color: #00AFF0;
            border-bottom: 3px solid #FCBA03;
        }

        p {
            margin: 0;
        }

        .header p {
            text-align: center;
            padding: 1%;
            font-weight: 500;
            font-size: 11px;
            text-transform: uppercase;
        }

        a {
            color: #F1F1F1;
            text-decoration: none;
        }

        /*--- End Outer Table 1 --*/
        .main-table-first {
            width: 100%;
            max-width: 610px;
            Margin: 0 auto;
            background-color: #FFF;
            border-radius: 6px;
            margin-top: 25px;
        }

        /*--- Start Two Column Sections --*/
        .two-column {
            text-align: justify;
            font-size: 0;
            padding: 5px 0 10px 0;
        }

        .two-column .section {
            width: 100%;
            max-width: 300px;
            display: inline-block;
            vertical-align: top;
        }

        .two-column .content {
            font-size: 16px;
            line-height: 20px;
            text-align: justify;
        }

        .content {
            width: 100%;
            padding-top: 20px;
        }

        .center {
            display: table;
            Margin: 0 auto;
        }

        img {
            border: 0;
        }

        img.logo {
            float: left;
            Margin-left: 5%;
            max-width: 200px !important;
        }

        #callout {
            float: right;
            Margin: 4% 5% 2% 0;
            height: auto;
            overflow: hidden;
        }

        #callout img {
            max-width: 20px;
        }

        .social {
            list-style-type: none;
            Margin-top: 1%;
            padding: 0;
        }

        .social li {
            display: inline-block;
        }

        .social li img {
            max-width: 15px;
            Margin-bottom: 0;
            padding-bottom: 0;
        }

        /*--- Start Outer Table Banner Image, Text & Button --*/
        .image img {
            width: 100%;
            max-width: 670px;
            height: auto;
        }

        .main-table {
            width: 100%;
            max-width: 610px;
            margin: 0 auto;
            background-color: #FFF;
            border-radius: 6px;
        }

        .one-column .inner-td {
            font-size: 16px;
            line-height: 20px;
            text-align: justify;
        }

        .inner-td {
            padding: 10px;
        }

        .h2 {
            text-align: center;
            font-size: 23px;
            font-weight: 600;
            line-height: 45px;
            Margin: 12px;
            color: #4A4A4A;
        }

        p.center {
            text-align: center;
            max-width: 580px;
            line-height: 24px;
        }

        .button-holder-center {
            text-align: center;
            Margin: 5% 2% 3% 0;
        }

        .button-holder {
            float: right;
            Margin: 5% 0 3% 0;
        }

        .btn {
            font-size: 15px;
            font-weight: 600;
            background: #00AFF0;
            color: #FFF;
            text-decoration: none;
            padding: 9px 16px;
            border-radius: 28px;
        }

        .ed-color {
            color: #00AFF0;
        }

        .lite-color {
            color: #FCBA03;
        }

        .text-red{
            color: red;
        }
        /*--- Start Two Column Image & Text Sections --*/
        .two-column img {
            width: 100%;
            max-width: 280px;
            height: auto;
        }

        .two-column .text {
            padding: 10px 0;
        }

        /*--- Start 3 Column Image & Text Section --*/
        .outer-table-2 {
            width: 100%;
            max-width: 670px;
            margin: 22px auto;
            background-color: #C2C1C1;
            border-bottom: 3px solid #81B9C3;
            border-top: 3px solid #81B9C3;
        }

        .three-column {
            text-align: center;
            font-size: 0;
            padding: 10px 0 30px 0;
        }

        .three-column .section {
            width: 100%;
            max-width: 200px;
            display: inline-block;
            vertical-align: top;
        }

        .three-column .content {
            font-size: 16px;
            line-height: 20px;
        }

        .three-column img {
            width: 100%;
            max-width: 125px;
            height: auto;
        }

        .outer-table-2 p {
            margin-top: 6px;
            color: #FFF;
            font-size: 18px;
            font-weight: 500;
            line-height: 23px;
        }

        /*--- Start Two Column Article Section --*/
        .outer-table-3 {
            width: 100%;
            max-width: 670px;
            margin: 22px auto;
            background-color: #C2C1C1;
            border-top: 3px solid #81B9C3;
        }

        .h3 {
            text-align: center;
            font-size: 21px;
            font-weight: 600;
            Margin-bottom: 8px;
            color: #4A4A4A;
        }

        /*--- Start Bottom One Column Section --*/
        .inner-bottom {
            padding: 22px;
        }

        .h1 {
            text-align: center !important;
            font-size: 25px !important;
            font-weight: 600;
            line-height: 45px;
            margin: 12px 0 20px 0;
            color: #4A4A4A;
        }

        .inner-bottom p {
            font-size: 16px;
            line-height: 24px;
            text-align: justify;
        }

        /*--- Start Footer Section --*/
        .footer {
            width: 100%;
            background-color: #C2C1C1;
            margin: 0 auto;
            color: #FFF;
        }

        .footer img {
            max-width: 135px;
            Margin: 0 auto;
            display: block;
            padding: 4% 0 1% 0;
        }

        p.footer {
            text-align: center;
            color: #FFF !important;
            line-height: 30px;
            padding-bottom: 4%;
            /* text-transform: uppercase; */
        }

        /*--- Media Queries --*/
        @media screen and (max-width: 400px) {
            .h1 {
                font-size: 22px;
            }

            .two-column .column,
            .three-column .column {
                max-width: 100% !important;
            }

            .two-column img {
                width: 100% !important;
            }

            .three-column img {
                max-width: 60% !important;
            }
        }

        @media screen and (min-width: 401px) and (max-width: 400px) {

            .two-column .column {
                max-width: 50% !important;
            }

            .three-column .column {
                max-width: 33% !important;
            }
        }

        @media screen and (max-width:768px) {
            img.logo {
                float: none !important;
                margin-left: 0% !important;
                max-width: 200px !important;
            }

            #callout {
                float: none !important;
                margin: 0% 0% 0% 0;
                height: auto;
                text-align: center;
                overflow: hidden;
            }

            #callout img {
                max-width: 26px !important;
            }

            .two-column .section {
                width: 100% !important;
                max-width: 100% !important;
                display: inline-block;
                vertical-align: top;
            }

            .two-column img {
                width: 100% !important;
                height: auto !important;
            }

            img.img-responsive {
                width: 100% !important;
                height: auto !important;
                max-width: 100% !important;
            }

            .content {
                width: 100%;
                padding-top: 0px !important;
            }
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <div id="wrapper-inner">
            <table class="outer-table">
                <tr>
                    <td class="header">
                        <p><a href="#">Education is light, hence {{env('APP_NAME',APP_NAME)}}</a></p>
                    </td>
                </tr>
                <table class="main-table-first">
                    <tr>
                        <td class="two-column">
                            <div class="section">
                                <table width="100%">
                                    <tr>
                                        <td class="inner-td">
                                            <table class="content">
                                                <tr>
                                                    <img src="{{asset('files/edulite/edulite logo.png')}}" alt="{{env('APP_NAME',APP_NAME)}}">
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- first column  -->
                            <div class="section">
                                <table width="100%">
                                    <tr>
                                        <td class="inner-td">
                                            <table class="content">
                                                <tr>
                                                    <div class="" id="callout">
                                                        <ul class="social">
                                                            <li><a href="#"><img src="{{asset('files/edulite/svg/facebook.svg')}}" alt=""></a></li>
                                                            <li><a href="#">Instagram</a></li>
                                                            <li><a href="#"><img src="{{asset('files/edulite/svg/YouTube.svg')}}" alt=""></a></li>
                                                        </ul>
                                                    </div>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- first column  -->
                        </td>
                    </tr>
                </table>
                <!-- main table first  -->
            </table>
            <!-- outer table  -->
        </div>

        <!-- <table class="outer-table">
            <tr>
                <td class="top-banner">
                    display continual add here with edu color
                </td>
            </tr>
        </table> -->

        <!-- top banner -->
        <table class="main-table">
            <tr>
                <td class="one-column">
                    <div class="section">
                        <table width="100%">
                            <tr>
                                <td class="inner-td">
                                    <!-- <p class="h2">Auth Mail</p> -->
                                    <p class="text">
                                        Welcome to the {{env('APP_NAME',APP_NAME)}}. We're honored that you've chosen to use our smart and simple system.
                                        It's our utmost priority to ensure you have an excellent experience with our System/Service.
                                        As as special thank you, we have created a unique referrar code for that earn you comission on any user that
                                        signed up using your referrer code.
                                        <br>

                                        <b class="ed-color">Have any questions/suggesstion or need more information? </b> <b class="lite-color">info@edulite.ng</b>
                                    <p>Feel free to reach out to us on how <b class="ed-color">We</b> can work together, and we shall response as soon as possible.</p>
                                    <b class="ed-color">For we are ready to provide bespoke Service.</b>
                                    <p>We're always here to help.</p>
                                    <b class="lite-color">{{env('APP_NAME',APP_NAME)}} TEAM</b>
                                    </p>
                                    <br>
                                    <p class="text-red">Please click on the button below to verify your Account</p>
                                    <p class="button-hover-center" style="margin: 50px;">
                                        <a class="btn" href="{{URL::to('/')}}/{{$param['url']}}">CLICK ME</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <!-- end heading, paragraph and button  -->
        </table>
        <!-- <table class="outer-table-2" style="background-color:#FCBA03;"> -->
        <!-- <tr> -->
        <!-- <td class="three-column">
                    <div class="section">
                        <table width="100%">
                            <tr>
                                <td class="inner-td">
                                    <table class="content">
                                        <tr>
                                            <td>
                                                <img src="" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita, consectetur!
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="section">
                        <table width="100%">
                            <tr>
                                <td class="inner-td">
                                    <table class="content">
                                        <tr>
                                            <td>
                                                <img src="" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita, consectetur!
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="section">
                        <table width="100%">
                            <tr>
                                <td class="inner-td">
                                    <table class="content">
                                        <tr>
                                            <td>
                                                <img src="" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita, consectetur!
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="section">
                        <table width="100%">
                            <tr>
                                <td class="inner-td">
                                    <table class="content">
                                        <tr>
                                            <td>
                                                <img src="" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita, consectetur!
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td> -->
        <!-- end three column  -->
        <!-- </tr>
        </table> -->

        <!-- <table class="main-table">
            <tr>
                <td class="two-section">
                    <div class="section">
                        <table width="100%">
                            <tr>
                                <td class="inner-td">
                                    <table class="content">
                                        <tr>
                                            <td><img src="" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td class="text">
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi minus error perferendis?</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi minus error perferendis?</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="section">
                        <table width="100%">
                            <tr>
                                <td class="inner-td">
                                    <table class="content">
                                        <tr>
                                            <td><img src="" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td class="text">
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi minus error perferendis?</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi minus error perferendis?</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
            <tr>
                <td class="one-column">
                    <table width="100%">
                        <tr>
                            <td class="inner-bottom">
                                <p class="h1">{{env('APP_NAME',APP_NAME)}}</p>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea id beatae maiores, dolores voluptates itaque qui temporibus officiis iusto dolorem illum recusandae voluptatum veritatis reiciendis delectus pariatur obcaecati. Rem, autem!</p>
                                <br>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos fugiat temporibus dicta?</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table> -->


        <!-- outer table 2  -->
        <!-- main table  -->
        <table class="outer-table-3">
            <tr>
                <td class="one-column">
                    <table width="100%">
                        <tr>
                            <td class="footer">
                                <img src="{{asset('files/edulite/edulite logo.png')}}" alt="{{env('APP_NAME',APP_NAME)}}">
                                <p class="footer">
                                    www.ng <br>
                                    care@edulite.ng | edulite@gmail.com
                                    <br>
                                    &copy; , 2022
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- outer table three  -->
        <!-- inner wrapper -->
    </div>
    <!-- end of wrapper -->
</body>

</html>