<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\UserDetail;

class UserDetailsController extends Controller
{


    public static function insertUserDetails($data){
        try {
            return UserDetail::updateOrCreate(['user_pid' => $data['user_pid'] ],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

   
    public static function getFullname($pid){
        return UserDetail::where('pid',$pid)->pluck('fullname')->first();
    }
}
