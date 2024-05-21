<?php
// jully 3 1:10 am
namespace App\Http\Controllers\Auths;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Framework\Events\SchoolNotificationController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Users\UserDetailsController;

class AuthController extends Controller
{
    public $password = 1234567;
    // public function signUpForm($id=null){
    //     if($id){
    //         session(['linkId'=>base64Decode($id)]);
    //     }
    //     return view('auths.sign-up');
    // }
    public function signUp(Request $request){
        $request->validate([
            'email'=>'required|email|unique:users,email|regex:/^[a-zA-Z0-9.@\s]+$/',// added regex
            'username'=> "required|unique:users,username|regex:/^[a-zA-Z0-9_\s]+$/",//added regex
            'gsm'=> "required|unique:users,gsm|max:11|min:11",//added regex
            'password'=>'required|min:4|confirmed',
            'firstname'=> "required|regex:/^[a-zA-Z0-9'\s]+$/",
            'lastname'=> "required|regex:/^[a-zA-Z0-9'\s]+$/",
        ]);
        $data = [
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>$request->password,
            'gsm'=>$request->gsm,
        ];
        // dd($request->all());
        $user = self::createUser($data);
        // send email
        if($user){
            $dtl = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'othername' => $request->othername,
                // 'dob' => $request->dob,
                // 'gender' => $request->gender,
                // 'religion' => $request->religion,
                'address' => $request->address,
                // 'about' => $request->about,
                'user_pid' => $user->pid
            ];
            // add user details to details table 
            $dtl = UserDetailsController::insertUserDetails($dtl);
            $data = [
                    'email'=>$user->email,
                    'name'=>$user->username,
                    'blade'=>'auth',
                    'url'=> 'verify/'. base64Encode($user->pid),
                    'subject'=> 'Account Verification Link'
            ];
            sendMail($data);
            return back()->with('success','Account Created successfully, Verification link sent to your mail, check inbox or Spam-folder now or contact info@edulite.ng');
        } 
        return back()->with('error','failed to created account');
        $token = $user->createToken('AUTH_TOKEN')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response,201);
    }

    public static function createUser($data){
        try {
            if(!isset($data['pid'])){
                $data['code'] = self::referrerCode();
                $data['pid']  =  public_id();
             }else{
                unset($data['password']);
             }
           return User::updateOrCreate(['pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }
    public static function referrerCode()
    {
        $count = User::where('code', 'like', '%' . date('yMd') . '%')->count('id');
        $id = $count + 1;
        $id = strlen($id) == 1 ? '0' . $id : $id;
        return date('yMd').$id;
    }
    public static function uniqueUsername(string $firstname)
    {
        if(empty($firstname)){
            return ;
        }
        $rm = ['#',' ','`',"'",'#','^','%','$','','*','(',')',';','"','>','<','/','?','+',',',':',"|",'[',']','{','}','~'];
        $firstname = str_replace($rm,'',trim($firstname));
       $count = User::where('username','like' ,'%'. $firstname.'%')
                                // ->orWhere(['firstname' => strtolower($firstname)])
                                // ->orWhere(['firstname' => strtoupper($firstname)])
                                ->count('id');
        if ($count == 0) {
            return $firstname;
        }
        return strtolower($firstname).date('ym') . $count;
    }

    public static function findEmail($email){
        return User::where('email', $email)->first();
    }
    public static function findGsm($gsm){
        
        return User::where('gsm', $gsm)->first();
    }
    public function verifyAccount($id){
        $user= User::where('pid',base64Decode($id))->first(['id','account_status','email_verified_at']);
        if($user->account_status==1){

            return redirect()->route('login')->with('success','account already Verified, you can now login');
        }
        if($user->account_status != 0 ){
            
            return redirect()->route('login')->with('success','Contact your school or admin to short out your issue');
        }
        $user->account_status = 1;
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user = $user->save();
        return redirect()->route('login')->with('success','account verification successfull, you can now login');
    }

    // send forget password link 
    public function forgetPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email']);
            
        if(!$validator->fails()){
            $user = User::where('email',$request->email)->first(['pid','email','id','username']);
            if($user){
                $data = [
                    'email' => $request->email,
                    'name' => $user->username,
                    'blade' => 'reset',
                    'url' => 'reset/' . base64Encode($user->pid .'||'. strtotime(now())),
                    'subject' => 'Password reset Link'
                ];
                if(sendMail($data)){
                    // $user->reset_token = strtotime(now());
                    $user->save();
                    return response()->json(['status'=>1,'message'=>'Password Reset link sent to your mail']);
                }
                return response()->json(['status'=>'error','message'=>'Something Went Wrong, try again or contact care@edulite.ng']);
            }
            return response()->json(['status'=>'error','message'=>'The email you provide is not registered']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }
    // open forget password when user click on link 
    public function resetPasswordForm($id){
        session(['resetPasswordToken' => $id]);
        return view('auths.reset');
    }

    public function resetUserPassword(Request $request){
        try {
            $user = User::where('pid', base64Decode($request->pid))->first();
            if ($user) {
                $pwd = randomNumber();
                $user->password = $pwd;
                $result = $user->save();
                if($result){
                    $id = base64Decode($request->id);
                    $msg = getAuthFullname(). ' Has reset your password <br>';
                    $msg .= '<p>Your new password is: <b>'.$pwd.'</b> </p>';
                    $msg .= 'if your are not aware of this contact the school management for a prompt action.';
                    SchoolNotificationController::notifyIndividualParent($msg,$id);
                    return response()->json(['status' => 1, 'message' => 'Password reset successful']);
                }
            }
            return response()->json(['status' => 0, 'message' => 'User not found']);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json(['status' => 0, 'message' => ER_500]);
        }
    }
    // reseting password when user submit  form 
    public function resetPassword(Request $request)
    {
        try {
            $request->validate(['password' => 'required|confirmed|min:6']);
            list($pid, $token) = explode('||', base64Decode(session('resetPasswordToken')));
            $user = User::where('pid', $pid)->first(); // load user detail
            $diff = strtotime(now()) - $token; //compare token
            if (abs($diff / 86400) > 1) {
                return redirect()->back()->with('warning', 'error|Reset Token has expired!');
            }
            $user->password = $request->password;
            // $user->reset_token = null;
            $msg = 'success|Password reset successfull!!!.';
            if ($user->account_status === 0) {
                $user->account_status = 1;
                $msg = 'success|Password reset successfull and account Verified!!!.';
            }
            $user->save();
            return redirect()->route('login')->with('message', $msg);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            return redirect()->route('login')->with('error', 'Something Went Wrong');
        }
    }
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'password'=> 'required|min:6|confirmed',
            'opwd'=>'required',
        ],['password.required'=>'Enter New Password', 'password.min' => 'Password is minimum of 6 characters',
            'opwd.required'=>'Old Password is required',
            ]);
        if(!$validator->fails()){
            try {
                $user = User::find(auth()->user()->id);
                if (Hash::check($request->opwd, $user->password)) {
                    $user->password = $request->password;
                    $user->save();
                    return response()->json(['status' => 1, 'message' => 'Password updated.']);
                }
                return response()->json(['status' => '2', 'message' => 'old password is incorrect.']);
            } catch (\Throwable $e) {
                $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
                logError($error);
            }
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    // login into the app 
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // login with username/gsm/email 
        $user = User::where('users.email',$request->email)// login with email
                        ->orwhere('users.username', $request->email)
                        ->orwhere('users.gsm', $request->email)// login with gsm
                        ->first(['username','account_status']);//
        if(!$user){// lgin with student reg
            $user = User::join('students', 'students.user_pid', 'users.pid')
                ->where('students.reg_number', $request->email) // logon with staff id
                ->first(['username', 'account_status']);
             }
        if(!$user){//login with staff id
            $user = User::join('school_staff', 'school_staff.user_pid', 'users.pid')
                ->where('school_staff.staff_id', $request->email) // logon with staff id
                ->first(['username', 'account_status']);
             }
            

        if($user && isset($user->account_status)){
            if ($user->account_status == 1) {
                if (auth()->attempt(['username' => $user->username, 'password' => $request->password,/*$request->only('email', 'password')*/])) {
                    $name = authUsername();
                    self::clearAuthSession();
                    setAuthFullName($name);
                    return redirect()->route('users.dashboard');
                }
                
                return back()->with('message', "error|Invalid login details");
            } elseif($user->account_status == 2) {
                return back()->with('message', "info|this account has been banned because of suspicius activities care@edulite.ng, 09079311551.");
            }elseif($user->account_status == 0){
                return back()->with('message', "info|Your acccount is not yet verified, please login to your mail and click on the verification link to activate your account or contact info@edulite.ng, 09079311551.");
            }
            return back()->with('message', "info|Contact care@edulite.ng, 09079311551.");
        }
        
        return back()->with('message', "error|Invalid login details");
    }

    public function logout(Request $request){
        self::logUserout();
        setAuthFullName();
        return redirect()->route('login');
    }
    public function logoutSchool(){
        self::clearSchoolSession();
        return redirect()->route('users.home');
    }
    public static function logUserout(){
        if (auth()->user()) {
            auth()->logout();
        }
       session()->flush();;
    }
    public static function clearAuthSession(): void
    {
        setActionablePid();
        setDefaultLanding();
        self::clearSchoolSession();
    }
    public static function clearSchoolSession(): void
    {
        setSchoolPid();
        setSchoolType();
        setSchoolUserPid();
        setSchoolName();
        setSchoolLogo();
        setUserActiveRole();
        setSchoolCode();
        setUserAccess();
    }
}
