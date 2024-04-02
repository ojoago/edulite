    @include('mails.mail-header')

    <table class="main-table">
        <tr>
            <td class="one-column">
                <div class="section">
                    <table width="100%">
                        <tr>
                            <td class="inner-td">
                                <p class="h2" style="text-align:left !important;">Hello, <b> {{$param['name']}}</b></p>
                                <p class="text" style="color:#000 !important;">
                                    {!!$param['message']!!}
                                </p>
                                <br>
                                @if(isset($param['url']))
                                <p class="text-red text-center" style="text-align:center !important;">Please click on the button below to login</p>
                                <p class="button-hover-center text-center" style="text-align:center !important;margin-bottom:10px;">
                                    <a class="btn" href="{{URL::to($param['url'])}}" style="font-size: 15px !important;font-weight: 700 !important;background: #00AFF0 !important; color: #FFF !important; text-decoration: none !important; padding: 9px 16px !important; border-radius: 28px !important;">
                                        CLICK HERE TO LOGIN
                                    </a>
                                </p>
                                @endif
                                <br>
                                <p class="text" style="color:#000 !important;">
                                    If you have any questions or need any assistance, please do not hesitate to contact us via email <b>info@edulite.ng</b> or <b>09079585000, 09079311551</b> on WhatsApp <br>

                                    Thank you for choosing our platform!
                                    <br>
                                    Sincerely, <br>
                                    {{env('APP_NAME',APP_NAME)}} Team.
                                </p>
                                <p>
                                <h3 style="color: red !important;">
                                    Remember to refer {{env('APP_NAME',APP_NAME)}} to schools and earn 15% commission
                                </h3>
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