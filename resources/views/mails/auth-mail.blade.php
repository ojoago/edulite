    @include('mails.mail-header')

    <table width="100%">
        <tr>
            <td class="inner-td" style="background-color: #222 !important;color:#FFF">
                <p>
                    Dear parent, guadian, teacher elders,
                    it is our collective duty to give our children (the next generation)
                    the best education they deserve in-order to make this world a better and safe place.
                </p>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td class="inner-td">
                <p class="h2" style="text-align:left !important;">Hi {{ucwords($param['name'])}},</p>
                <p class="text">
                    Welcome to {{env('APP_NAME',APP_NAME)}}. We're honored that you've chosen to use our smart, simple and reliable system.
                    It's our utmost priority to ensure you have an excellent experience with our System/Service.
                    As as special thank you, we have created a unique referrar code for you, which will earn you comission on any user that
                    signed up using your referrer code.
                    <br>
                <p class="text-red text-center" style="text-align:center !important;">Please click on the button below to verify your Account</p>
                <p class="button-hover-center text-center" style="text-align:center !important;margin-bottom:10px;">
                    <a class="btn" href="{{URL::to($param['url'])}}" style="font-size: 15px !important;font-weight: 700 !important;background: #00AFF0 !important; color: #FFF !important; text-decoration: none !important; padding: 9px 16px !important; border-radius: 28px !important;">
                        CLICK HERE TO VERIFY
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