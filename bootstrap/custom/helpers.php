<?php 
use App\Mail\AuthMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Controllers\Auths\AuthController;


   function logError($error){
    Log::error(json_encode($error));
   }
   function public_id(){
        return strtoupper(str_shuffle(date('YMDHism').time()));
    }
   function invoiceNumber(){
        return strtoupper(date('yMd'));
    }

   function base64Encode($var){
        return base64_encode(base64_encode($var));
   }
   function base64Decode($var){
        return base64_decode(base64_decode($var));
   }
    function setSchoolPid($pid=null){ //set logged in school pid
        session(['activeSchoolPid'=>base64Encode($pid)]); //get user pid
    }
    function getSchoolPid(){ //get logged in school pid
        if(getUserPid()){ //check if user is logged in
            return base64Decode(session('activeSchoolPid')); //return  school pid
        }
        //bruteLogout();
    }
    function setActionablePid($pid=null){ //set pid key of the table to be acted upone
        session(['activeRecordPid'=>$pid]); //get user pid
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
     function setSchoolLogo($logo=null){ //set school logo
        session(['schoolLogo'=>$logo]); 
    }
     function getSchoolLogo(){ //set school logo
        $path = session('schoolLogo') ? '/files/logo/'. session('schoolLogo') : 'files/edulite/edulite logo.png'; //'files/edulite/edulite logo.png'
        return $path; 
    }
    function getSchoolUserPid(){ //set pid key of the table to be acted upone 
        return base64Decode(session('schoolUserPid')); //get user pid
    }
    function setUserActiveRole($code=null){
        session(['userActiveRole'=>$code]); //user role
    }
   
    function getUserActiveRole(){
        return session('userActiveRole'); 
    }
    function hasRole($role=false){
        return $role;
    }
    
    function schoolTeacher(){
        $cn =['200','205','301','300','303','305','307','500'];
        return (in_array(getUserActiveRole(),$cn)|| hasRole());
    }
    function classTeacher(){
        return (getUserActiveRole() == 301 || hasRole());
    }
    function schoolAdmin(){
        $cn = ['200', '205'];
        return (in_array(getUserActiveRole(), $cn) || hasRole());
    }
    function studentRole(){
        return (getUserActiveRole() == 600);
    }
    function parentRole(){
        return (getUserActiveRole() == 605 || hasRole());
    }
    function riderRole(){
        return (getUserActiveRole() == 610 || hasRole());
    }
    function canComment(){
        $cn =['301','307','500'];
        return (in_array(getUserActiveRole(), $cn) || hasRole());
    }
    function deniedAccess($role=false){
        return $role;
    }
    function setSchoolType($type=1){
        session(['schoolType' => $type]); //get  Type
    }
     function getSchoolType(){
        return session('schoolType'); 
    }

    function setAuthFullName($name=null){
        session(['authFullname' => $name]); 
    }
    function getAuthFullname(){
       return session('authFullname'); 
    }
    function setDefaultLanding($l=false){
        session(['defaultLanding' => $l]); 
    }
    function getDefaultLanding(){
       return session('defaultLanding'); 
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
                '200'=> 'School Super Admin',
                '205'=> 'School Admin',
                '300'=> 'Teacher',
                '301'=> 'Form/Class Teacher',
                '303'=> 'Clerk',
                '305'=> 'Secretary',
                '307'=> 'Portals',
                '400'=> 'Office Assisstnace',
                '405'=> 'Security',
                '500'=> 'Principal/Head Teacher',
                // '505'=> 'Head Teacher',
                '600'=> 'Student',
                '601'=> 'Applicant',
                '605'=> 'Parent/Guardian',
                '610'=> 'Rider',
                '700'=> 'Agent/Referer',
                '710'=> 'Partners',
                '10'=> 'App Admin',
                default=>''
                };
       return $role; 
    }
    function matchGender($gn){
        $role =  match((string)$gn){
                '2'=> 'Female',
                '1'=> 'Male',
                '3'=> 'Other',
                default=>''
                };
       return $role; 
    }
    function matchReligion($lg){
        $role =  match((string)$lg){
                '2'=> 'Christian',
                '1'=> 'Muslim',
                '3'=> 'Other',
                default=>''
                };
       return $role; 
    }
    function matchPaymentModel($mdl){
        $model =  match((string)$mdl){
                '2'=> 'Per Session',
                '1'=> 'Termy',
                '3'=> 'Once',
                default=>''
                };
       return $model; 
    }
    function matchPaymentCategory($ctg){
        $model =  match((string)$ctg){
            '1'=>'Class base',
            "2"=>'General',
            "3"=>'Class Conditional',
            "4"=> 'General Conditional',
            default=>''
        };
       return $model; 
    }
    function matchPaymentType($type){
        $model =  match((string)$type){
                '2'=> 'On demand',
                '1'=> 'Compulsary',
                default=>''
                };
       return $model; 
    }
    function matchStudentStatus($sts){
        $role =  match((string)$sts){
                '0'=> 'Disabled',
                '1'=> 'Active Student',
                '3'=> 'Left School',
                '4'=> 'Suspended',
                default=>''
                };
       return $role; 
    }
    function matchAccountStatus($sts){
        $role =  match((string)$sts){
                '0'=> 'Disabled',
                '1'=> 'Active Account',
                // '3'=> 'Left School',
                '2'=> 'Suspended',
                default=>''
                };
       return $role; 
    }
    function matchStudentRiderStatus($sts){
        $role =  match((string)$sts){
                '0'=> 'Disabled',
                '1'=> 'Active',
                // '3'=> 'Left School',
                '2'=> 'Suspended',
                default=>''
                };
       return $role; 
    }
    function matchSchoolPaymentModule($sts){
        $role =  match((string)$sts){
                '1'=> 'Per term/student',
                '2'=> 'Per Session/Student',
                '3'=> 'Anual',
                '4'=> 'Buy off',
                default=>''
                };
       return $role; 
    }
function getInitials($string = null)
{
    $string = preg_split("/[\s,_-]+/",$string);
        $ret = '';
        foreach ($string as $word)
            $ret .= $word[0];
        return $ret;
}
    function dateToAge($date){
        return Carbon::parse($date)->age;
    // $date = new DateTime($date);
    // return $date->diff(Carbon::now())
    // ->format('%y years, %m months and %d days');
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

    function rtnGrade($num,$grd){

        foreach($grd as $val){
                if($num >=$val->min_score && $num <= $val->max_score)
                 return $val->grade;
        }
        return 'NA';
    }
   
function date_diff_weekdays($from, $to)
{
    if ($from === null || $to === null)
        return null;

    $date_from = new DateTime($from);
    $date_to = new DateTime($to);

    // calculate number of weekdays from start of week - start date
    $from_day = intval($date_from->format('w')); // 0 (for Sunday) through 6 (for Saturday)
    if ($from_day == 0)
        $from_day = 7;
    $from_wdays = $from_day > 5 ? 5 : $from_day;

    // calculate number of weekdays from start of week - end date
    $to_day = intval($date_to->format('w'));
    if ($to_day == 0)
        $to_day = 7;
    $to_wdays = $to_day > 5 ? 5 : $to_day;

    // calculate number of days between the two dates
    $interval = $date_from->diff($date_to);
    $days = intval($interval->format('%R%a')); // shows negative values too

    // calculate number of full weeks between the two dates
    $weeks_between = floor($days / 7);
    if ($to_day >= $from_day)
        $weeks_between -= 1;

    // complete calculation of number of working days between
    $diff_wd = 5 * ($weeks_between) + (5 - $from_wdays) + $to_wdays;

    return $diff_wd;
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
    function fullDate(){
        return date('Y-m-d H:i:s');
    }

    function sendMail($param){
       return Mail::to($param['email'])->send(new AuthMail($param));
    }
function saveImg($image,$path='images',$name=null)
{
    // $image = $request->file('image');
$name = str_replace('/', '-', $name . ' edulite.' .'.png' /*$image->extension()*/);

    // $input['imagename'] = time() . '.' . $image->extension();

    // $destinationPath = public_path('/files/thumbnail/');
    $destinationPath = public_path("/files/" . $path . '/');

    $img = Image::make($image->path());
    $img->resize(150, 150, function ($constraint) {
        $constraint->aspectRatio();
    })->save($destinationPath . $name);

    // $destinationPath = public_path("/files/" . $path);
    // $image->move($destinationPath, $name);
    return $name;
    $percent=0.26;
    $size = $image->getSize();
    if($size < 1024 * 1024){
        $percent = 1;
    }
    $destinationPath = public_path("/files/".$path.'/');
    if(!$name){
        $name = getSchoolPid() . '-' . public_id();
    }
    $name = str_replace('/','-',$name.' edulite.'. $image->extension());
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
function _saveImg($image,$path='images',$name=null)
{
    $percent=0.26;
    $size = $image->getSize();
    if($size < 1024 * 1024){
        $percent = 1;
    }
    $destinationPath = public_path("/files/".$path.'/');
    if(!$name){
        $name = getSchoolPid() . '-' . public_id();
    }
    $name = str_replace('/','-',$name.' edulite.'. $image->extension());
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

function phpWay($path)
{
    move_uploaded_file($path, $path);
    $file_type = IOFactory::identify($path);
    $reader = IOFactory::createReader($file_type);
    $spreadsheet = $reader->load($path);
    unlink($path);
    $data = $spreadsheet->getSheet(0)->toArray(); //get the first sheet instead of getActiveSheet()
    $header =  $data[0];
    unset($data[0]);
    return ['header' => $header, 'data' => $data];
}


function maatWay($model, $path)
{
    // $collection = Excel::toCollection(new SchoolStaff, $path);
    $data = Excel::toArray($model, $path);//array way 
    $header =  $data[0][0];
    unset($data[0][0]);
    $data = $data[0];
    return ['header' => $header, 'data' => $data];
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





