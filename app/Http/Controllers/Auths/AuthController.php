<?php

namespace App\Http\Controllers\Auths;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Users\UserDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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

            return back()->with('success','Account Created successfully, Verification link sent to your mail');
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
        $data['pid']  = public_id();
           return User::create($data);
        } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
            logError($error);
        }
    }
   
    public static function uniqueUsername($firstname)
    {
        $rm = ['#',' ','`',"'",'#','^','%','$','','*','(',')',';','"','>','<','/','?','+',',',':',"|",'[',']','{','}','~'];
        $firstname = str_replace($rm,'',trim($firstname));
       $count = UserDetail::where('firstname' ,$firstname)
                                ->orWhere(['firstname' => strtolower($firstname)])
                                ->orWhere(['firstname' => strtoupper($firstname)])
                                ->count('id');
        if ($count == 0) {
            return $firstname;
        }
        return $firstname.date('ym') . $count;
    }
    public function verifyAccount($id){
        $user= User::where('pid',$id)->first(['id','account_status','email_verified_at']);
        $user->account_status = 1;
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user = $user->save();
        return redirect()->route('login')->with('success','account verification successfull, you can now login');
    }
    public function forgetPassword(Request $request){

    }
    public function resetPasswordForm($id){
        session(['pid' => $id]);
        return view('auths.reset');
    }
    public function resetPassword(Request $request)
    {
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
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // $pid = User::where('email',$request->email)
        //                 ->orwhere('gsm', $request->email)
        //                 ->orwhere('username', $request->email)->pluck('pid')->first();
        if (auth()->attempt($request->only('email', 'password'))) {
            $name = authUsername();
            setAuthFullname($name);
            self::clearAuthSession();
            return redirect()->route('users.dashboard');
        }
        return back()->with('message', "error|Invalid login details");
    }

    public function logout(Request $request){
        self::logUserout();
        return redirect()->route('login');
    }
    public function logoutSchool(){
        self::clearSchoolSession();
        return redirect()->route('users.dashboard');
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
        setAuthFullname();
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
