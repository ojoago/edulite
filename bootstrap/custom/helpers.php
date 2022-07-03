<?php 

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

   function logError($error){
    Log::error($error);
   }
   function public_id(){
     return strtoupper(str_shuffle(date('YMDHism').time()));
    }

   function base64Encode($var){
        return base64_encode(base64_encode($var));
   }
   function base64Decode($var){
        return base64_decode(base64_decode($var));
   }
    function setSchoolPid($pid){ //set logged in school pid
        session(['activeSchoolPid'=>base64Encode($pid)]); //get user pid
    }
    function getSchoolPid(){ //get logged in school pid
        if(getUserPid()){ //check if user is logged in
            return base64Decode(session('activeSchoolPid')); //return  school pid
        }
        //bruteLogout();
    }
    function setActionablePid($pid){ //set pid key of the table to be acted upone 
        session(['activeRecordPid'=>base64Encode($pid)]); //get user pid
    }
    function getActionablePid(){ //set pid key of the table to be acted upone 
        if(getUserPid()){//check if user is still logged
            return base64Decode(session('activeRecordPid')); //return school pid
        }
       // bruteLogout();
    }
    function getUserPid(){
        if(auth()->user()){
            return auth()->user()['pid'];
        }
        bruteLogout(); //get user pid
    }

    function bruteLogout(){
        if(auth()){
            auth()->logout();
        }
        return redirect()->route('login')->with('danger', 'Your Session has expired');
    }

    function flashMessage(){
    if (Session::has('message')) {
        list($type, $message) = explode('|', Session::get('message'));
        $alert = match($type){
            'error'=> 'danger',
            'warning'=> 'warning',
            'message'=> 'info',
            'info'=> 'info',
            'success'=> 'success',
        };
        $alert = $type == 'error' ? 'danger' : 'info';
        return sprintf('<div class="alert alert-%s alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>%s!</strong> %s
                        </div>', $alert, ucfirst($type), $message);
    }
    return '';
    }