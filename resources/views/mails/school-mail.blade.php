    @include('mails.school-header')


    <tr>
        <td class="inner-td">
            <p class="h2" style="text-align:left !important;">Dear {{$param['name']}},</p>
            <p class="text" style="color:#000 !important;">
                {!! $param['message'] !!}
            </p>
            <br>

            <hr>
            <h4 style="color: red !important;">
                Refer {{env('APP_NAME',APP_NAME)}} to schools and earn commission
            </h4>
            </p>
        </td>
    </tr>
    <tr width="100%">

        <td style="padding: 10px !important; background: #FCBA03 !important; color:#fff !important">
            <p>
                TEACHERS DON'T TEACH FOR THE INCOME. <br> TEACHERS TEACH FOR THE OUTCOME. <br>
                @ {{env('APP_NAME',APP_NAME)}}, We saying a big thank you to all teachers...
            </p>
        </td>

    </tr>
    <!-- end heading, paragraph and button  -->
    @include('mails.mail-footer')