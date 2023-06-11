    @include('mails.mail-header')

    <table class="main-table">
        <tr>
            <td class="one-column">
                <div class="section">
                    <table width="100%">
                        <tr>
                            <td class="inner-td">
                                <p class="h2" style="text-align:left !important;">Hi {{$param['name']}},</p>
                                <p class="text" style="color:#000 !important;">
                                    {{$param['message']}}
                                </p>
                                <br>
                                <br>
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