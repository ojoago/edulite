    @include('mails.school-header')

    <table class="main-table">
        <tr>
            <td class="one-column">
                <div class="section">
                    <table width="100%">
                        <tr>
                            <td class="inner-td">
                                <p class="h2">Dear {{$param['name']}},</p>
                                <p class="text">
                                    {{$param['message']}}
                                    <br>

                                    <b class="ed-color">Have any questions/suggesstion or need more information? </b> <b class="lite-color">info@edulite.ng</b>
                                <p>Feel free to reach out to us on how <b class="ed-color">We</b> can work together, and we shall response as soon as possible.</p>
                                <b class="ed-color">For we are ready to provide bespoke Service.</b>
                                <p>{{$param['school']->school_name}}</p>
                                <b class="lite-color">Powered By: {{env('APP_NAME',APP_NAME)}} TEAM</b>
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