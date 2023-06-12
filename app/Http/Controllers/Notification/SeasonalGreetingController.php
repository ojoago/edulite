<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class SeasonalGreetingController extends Controller
{
    public static function seasonalGreeting()
    {
        $users = DB::table('users as u')->select('email','username')->where('email','<>',null)->get();
        $data = [
            'message' => 'Democracy is not just a system of governance; it is a shared commitment to upholding the values of equality, inclusivity, and respect for fundamental human rights. 
            It is an opportunity for every Nigerian voice to be heard and every citizen to contribute to the nation’s growth.

Let us strive for unity amidst our diversity, embracing dialogue and peaceful coexistence as we work towards a better Nigeria. Together, we can overcome challenges, bridge divides, and foster an environment where every Nigerian can thrive.

Happy Democracy Day Nigerians💚! ',
            'blade' => 'greeting',
            'subject' => 'Democracy Day',
            // 'name' => 'Hassan',
            // 'email' => 'ojoago247@gmail.com'
        ];
        // sendMail($data);
        foreach($users as $user){
            $data['email']= $user->email;
            $data['name']= $user->username;
            sendMail($data);
        }
    }

    public static function birthdays()
    {
        // $users = DB::table('users as u')->select('email', 'username', 'status')->where()->get();
    }
}
