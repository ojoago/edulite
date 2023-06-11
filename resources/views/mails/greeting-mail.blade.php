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
                                    {{$param['message']}}
                                </p>
    <br>
    <br>
                                <b class="ed-color">Have any questions/suggesstion or need more information? </b> <b class="lite-color">info@edulite.ng</b>
                                <p>Feel free to reach out to us on how <b class="ed-color">We</b> can work together, and we shall respond as soon as possible.</p>
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