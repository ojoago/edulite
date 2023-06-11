    @include('mails.mail-header')

    <table class="main-table">
        <tr>
            <td class="one-column">
                <div class="section">
                    <table width="100%">
                        <tr>
                            <td class="inner-td">
                                <p class="h2">Hi {{$param['name']}},</p>
                                <p>edulite.ng has received a request to reset the password for your account.</p>

                                <p class="text-red">If you did not request to reset your password, please ignore this email</p>
                                <p class="button-hover-center" style="margin: 20px;">
                                    <a class="btn" href="{{URL::to('/')}}/{{$param['url']}}" style="font-size: 15px !important;font-weight: 600 !important;background: #00AFF0 !important; color: #FFF !important; text-decoration: none !important; padding: 9px 16px !important; border-radius: 28px !important;">
                                        Reset PASSWORD NOW
                                    </a>
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