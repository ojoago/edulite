<?php

namespace App\Http\Controllers\Auths;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function signUpForm($id=null){
    //     if($id){
    //         session(['linkId'=>base64Decode($id)]);
    //     }
    //     return view('auths.sign-up');
    // }
    public function signUp(Request $request){
        $request->validate([
            'email'=>'required|email|unique:users,email',
            'username'=>'required|unique:users,username',
            'password'=>'required|min:4|confirmed'
        ]);
        $data = [
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>$request->password,
        ];
        // dd($request->all());
        $user = self::createUser($data);
        // send email
        if($user){
            $data = [
                    'email'=>$request->email,
                    'name'=>$request->username,
                    'blade'=>'auth',
                    'url'=> 'verify/'. base64Encode($user->pid),
                    'subject'=> 'Account Verification Link'
            ];
            sendMail($data);
            return back()->with('success','Account Created successfully, Verification link sent to your mail, check inbox or Spam-folder now!!!');
        } 
        return back()->with('error','failed to created account');
        $token = $user->createToken('traqToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response,201);
    }

    public static function createUser($data){
        try {
        $data['code'] = null;
        $data['pid']  = $data['pid'] ?? public_id();
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
            $user = User::where('email',$request->email)->first(['pid','email','reset_token','id','username']);
            if($user){
                $data = [
                    'email' => $request->email,
                    'name' => $user->username,
                    'blade' => 'reset',
                    'url' => 'reset/' . base64Encode($user->pid),
                    'subject' => 'Password reset Link'
                ];
                if(sendMail($data)){
                    $user->reset_token = strtotime(now());
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
        session(['pid' => $id]);
        return view('auths.reset');
    }

    // reseting password when user submit b=form 
    public function resetPassword(Request $request)
    {
        try {
            $request->validate(['password' => 'required|confirmed|min:6']);
            $user = User::where('pid', base64Decode(session('pid')))->first(); // load user detail
            $diff = strtotime(now()) - $user->reset_token; //compare token
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
        $user = User::where('email',$request->email)
                        ->orwhere('gsm', $request->email)
                        ->orwhere('username', $request->email)->first(['username','account_status']);
        if($user && isset($user->account_status)){
            if ($user->account_status == 1) {
                if (auth()->attempt(['username' => $user->username, 'password' => $request->password,/*$request->only('email', 'password')*/])) {
                    $name = authUsername();
                    self::clearAuthSession();
                    setAuthFullName($name);
                    return redirect()->route('users.dashboard');
                }
            } else {
                if ($user->account_status == 0) {
                    return back()->with('message', "info|Your acccount is not yet verified, please login to your mail and click on verification link to activate your account.");
                }
            }
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
        self::clearAuthSession();
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
    }
}
