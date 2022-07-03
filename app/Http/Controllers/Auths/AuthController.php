<?php

namespace App\Http\Controllers\Auths;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(Request $request){
        $request->validate([
            'email'=>'required|email|unique:users,email',
            'username'=>'required|unique:users,username',
            'password'=>'required|min:6|confirmed'
        ]);
        $request['pid'] = public_id();
        $request['password'] = Hash::make($request->password);
        // dd($request->all());
        $user = User::create($request->all());
        $token = $user->createToken('traqToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response,201);
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
    public function resetPassword(Request $request){

    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->to('users-dashboard');
        }
        return back()->with('message', "error|Invalid login details");
    }

    public function logout(Request $request){
        if (auth()->user()) {
            auth()->logout();
        }
        return redirect()->route('login');

    }
}
