<?php 

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auths\AuthController;

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
    function setSchoolPid($pid=null){ //set logged in school pid
        if($pid){
            session(['activeSchoolPid'=>base64Encode($pid)]); //get user pid
        }else{
            session(['activeSchoolPid'=>null]); //get user pid
        }

    }
    function getSchoolPid(){ //get logged in school pid
        if(getUserPid()){ //check if user is logged in
            return base64Decode(session('activeSchoolPid')); //return  school pid
        }
        //bruteLogout();
    }
    function setActionablePid($pid=null){ //set pid key of the table to be acted upone
        if($pid){
            session(['activeRecordPid'=>$pid]); //get user pid
        }else{
            session(['activeRecordPid'=>null]); //get user pid
        }
    }
    function getActionablePid(){ //set pid key of the table to be acted upone 
        if(getUserPid()){//check if user is still logged
            return session('activeRecordPid'); //return school pid
        }
        // bruteLogout();
    }
    function setSchoolUserPid($pid=null){ //set pid key of the table to be acted upone
        if($pid){
            session(['schoolUserPid'=>base64Encode($pid)]); //get user pid
        }else{
            session(['schoolUserPid'=>null]); //get user pid
        }

    }
    function setSchoolName($name=null){ //set school to session
        if($name){
            session(['schoolName'=>$name]); //get user name
        }else{
            session(['schoolName'=>null]); //to school name to null
        }
    }
    function getSchoolName(){ // get school name
        return session('schoolName');
    }
    function getSchoolUserPid(){ //set pid key of the table to be acted upone 
        return base64Decode(session('schoolUserPid')); //get user pid
    }
    function setUserActiveRole($code=null){
        if($code){
            session(['userActiveRole'=>$code]); //get user pid
        }else{
            session(['userActiveRole'=>null]); //get user pid
        }
    }
    function getUserActiveRole(){
        return 200;
        return base64Decode(session('userActiveRole')); 
    }
    function setSchoolType($type=1){
            session(['schoolType' => $type]); //get  Type
    }
    function getSchoolType(){
    return session('schoolType'); 
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
    function signOut(){
        if (!auth()) {
            AuthController::logUserout();
        }
        return redirect()->route('login')->with('danger', 'Your Session has expired');
    }


    function matchStaffRole($role){
          
        $role =  match($role){
                '200'=> 'Super Admin',
                '205'=> 'School Admin',
                '500'=> 'Pincipal',
                '505'=> 'Head Teacher',
                '301'=> 'Form/Class Teacher',
                '300'=> 'Teacher',
                '303'=> 'Clerk',
                '305'=> 'Secretary',
                '307'=> 'Portals',
                '400'=> 'Office Assisstnace',
                '405'=> 'Security',
                };
       return $role; 
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