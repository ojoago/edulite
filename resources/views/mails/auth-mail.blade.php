    @include('mails.mail-header')

    <table class="main-table">
        <tr>
            <td class="one-column">
                <div class="section">
                    <table width="100%">
                        <tr>
                            <td class="inner-td">
                                <p class="h2">Hi {{$param['name']}},</p>
                                <p class="text">
                                    Welcome to {{env('APP_NAME',APP_NAME)}}. We're honored that you've chosen to use our smart, simple and reliable system.
                                    It's our utmost priority to ensure you have an excellent experience with our System/Service.
                                    As as special thank you, we have created a unique referrar code for you, which will earn you comission on any user that
                                    signed up using your referrer code.
                                    <br>
                                <p class="text-red">Please click on the button below to verify your Account</p>
                                <p class="button-hover-center text-center" style="text-align:center !important">
                                    <a class="btn" href="{{URL::to('/')}}/{{$param['url']}}" style="font-size: 15px !important;font-weight: 600 !important;background: #00AFF0 !important; color: #FFF !important; text-decoration: none !important; padding: 9px 16px !important; border-radius: 28px !important;">
                                        CLICK ME
                                    </a>
                                </p>
                                <b class="ed-color">Have any questions/suggesstion or need more information? </b> <b class="lite-color">info@edulite.ng</b>
                                <p>Feel free to reach out to us on how <b class="ed-color">We</b> can work together, and we shall response as soon as possible.</p>
                                <b class="ed-color">For we are ready to provide bespoke Service.</b>
                                <p>We're always here to help.</p>
                                <b class="lite-color">{{env('APP_NAME',APP_NAME)}} TEAM</b>
                                </p>

                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <!-- end heading, paragraph and button  -->
    </table>
    @include('mails.mail-footer')