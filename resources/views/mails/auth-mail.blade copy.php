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