<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\UserDetail;

class UserDetailsController extends Controller
{


    public static function insertUserDetails($data){
        $data['fullname'] = self::concatUserFullname($data);
        try {
            $dupParams = ['user_pid'=>$data['user_pid']];
            return UserDetail::updateOrCreate($dupParams,$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    public static function concatUserFullname($data)
    {
        $names =  $data['lastname'] . ' ' . $data['firstname'] . ' ' . $data['othername'];
        return ucwords(trim($names));
    }
}
