<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\School\School;
use App\Models\Users\UserDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auths\AuthController;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $schools = School::where('user_pid', getUserPid())->get(['pid', 'school_name']);
        // $office = DB::table('school_staff as t')
        // ->join('schools as s','s.pid','t.school_pid')
        // ->where('t.user_pid', getUserPid())->get(['s.pid', 's.school_name']);
        $data = $this->loadUserSchools(); //['schools'=> $schools,'work'=>$office];
        if(!getDefaultLanding()){
            if (count($data) === 1) {
                $pid = $data[0]->pid;
                AuthController::clearAuthSession();
                return redirect()->route('login.school', [base64Encode($pid)]);
            }
        }
        AuthController::clearAuthSession();
        return view('users.dashboard', compact('data'));
    }
    public function dashboard()
    {
        
        AuthController::clearAuthSession();
        $data = $this->loadUserSchools();//['schools'=> $schools,'work'=>$office];
        // $data =['schools'=> $schools,'work'=>$office];
        return view('users.dashboard', compact('data'));
    }

    public function loadUserSchools(){
        $account =  DB::table('school_users as u')->join('schools as s','s.pid','school_pid')
                    ->where('u.user_pid', getUserPid())->get(['s.pid', 's.school_name','role']);
        return $account;
        // $schools = School::where('user_pid', getUserPid())->get(['pid', 'school_name']);
        // $office = DB::table('school_staff as t')
        // ->join('schools as s', 's.pid', 't.school_pid')
        // ->where('t.user_pid', getUserPid())->get(['s.pid', 's.school_name']);
        // return ['schools' => $schools, 'work' => $office];
    }
    public static function loadUserInfo($id)
    {
        $user = UserDetail::where('pid', $id)->first(['gender', 'dob', 'religion', 'state', 'lga', 'address']);
        return $user;
    }
    public function loadUserDetail()
    {
        $user = UserDetail::where('user_pid', getUserPid())->first(['gender', 'dob', 'religion', 'state', 'lga', 'address','firstname','lastname','othername','about']);
        return response()->json($user);
    }
    public function updateUserDetail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname'=>'required|string|min:3',
            'lastname'=>'required|string|min:3',
            'dob'=>'date',
            'gender'=>'required|int',
            'religion'=>'required|int',
            'address'=>'required|string',
            'about'=>'nullable|string|max:255',
        ]);
        if(!$validator->fails()){
            $data = [
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'othername'=>$request->othername,
                'dob'=>$request->dob,
                'gender'=>$request->gender,
                'religion'=>$request->religion,
                'address'=>$request->address,
                'about'=>$request->about,
                'user_pid'=>getUserPid()
            ];
            $dtl = UserDetailsController::insertUserDetails($data);
            if($dtl){

                return response()->json(['status'=>1,'message'=>'details updated']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }
    
}
