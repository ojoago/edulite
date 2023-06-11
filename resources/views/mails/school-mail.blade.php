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
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <!-- end heading, paragraph and button  -->
    </table>
    @include('mails.mail-footer')