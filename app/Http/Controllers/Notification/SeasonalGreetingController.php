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
            'message' => 'Today is the day when we remember the years before and look at the possibilities before us in order to strive for an even better future. We should remember not to leave the faith of our country in the hands of our leaders alone, as it is the responsibility of everyone to make it greater. Have faith in Nigeria and happy Democracy Day! ',
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
