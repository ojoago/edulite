<?php 
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
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
                default=>''
                };
       return $role; 
    }
    function matchGender($gn){
        $role =  match($gn){
                '2'=> 'Female',
                '1'=> 'Male',
                default=>''
                };
       return $role; 
    }
    function matchReligion($lg){
        $role =  match($lg){
                '2'=> 'Christian',
                '1'=> 'Muslim',
                '3'=> 'Other',
                default=>''
                };
       return $role; 
    }
    function matchStudentStatus($sts){
        $role =  match($sts){
                '0'=> 'Disabled',
                '1'=> 'Active Student',
                '3'=> 'Left School',
                '4'=> 'Suspended',
                default=>''
                };
       return $role; 
    }
    function matchAccountStatus($sts){
        $role =  match($sts){
                '0'=> 'Disabled',
                '1'=> 'Active Account',
                // '3'=> 'Left School',
                '2'=> 'Suspended',
                default=>''
                };
       return $role; 
    }

    function ordinalFormat($num){
        try {
            if(class_exists('NumberFormatter')){
                $locale = 'en_US';
                $nf = new \NumberFormatter($locale, \NumberFormatter::ORDINAL);
                return $nf->format($num);
            }else{
                return ordinal($num);
            }
        } catch (\Throwable $e) {
           $error = $e->getMessage();
           logError($error);
           return ordinal($num);
        }
    }

    function ordinal($num)
    {
        $end = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if (($num % 100) >= 11 && ($num % 100) <= 13)
            $surfix = $num . 'th';
        else
            $surfix = $num . $end[$num % 10];
        return $surfix;
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
            default=> 'warning',
        };
        $alert = $type == 'error' ? 'danger' : 'info';
        return sprintf('<div class="alert alert-%s alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>%s!</strong> %s
                        </div>', $alert, ucfirst($type), $message);
    }
    return '';
    }

    function justDate(){
        return date('Y-m-d');
    }


function saveImg($image,$path='images',$name=null)
{
    $percent=0.26;
    $size = $image->getSize();
    if($size < 1024 * 1024){
        $percent = 1;
    }
    $destinationPath = public_path('/files'.'/'.$path.'/');
    if(!$name){
        $name = getSchoolPid() . '-' . public_id();
    }
    $name = str_replace('/','-',$name.'.'. $image->extension());
    $height = Image::make($image)->height();//get image width
    $width = Image::make($image)->width();
    $new_width = $width * $percent;
    $new_height = $height*($new_width/$width);
    $img = Image::make($image->getRealPath());
    $img->resize($new_width, $new_height, function ($constraint) {
        $constraint->aspectRatio();
    })->save($destinationPath . $name);
    return $name;
}




if (!function_exists('file_path')) {
    /**
     * Return the path to public dir.
     *
     * @param  null  $path
     * @return string
     */
    function file_path($path = null)
    {
        return rtrim(app()->basePath('files/' . $path), '/');
    }
}





