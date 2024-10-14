<?php

namespace App\Http\Controllers\School;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Users\UserDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\Users\UserDetailsController;

class SchoolListController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $data = $this->loadUserSchools();
        AuthController::clearAuthSession();
        return view('list.school-list', compact('data'));
    }
    public function dashboard()
    {

        AuthController::clearAuthSession();
        $data = $this->loadUserSchools();
        return view('users.dashboard', compact('data'));
    }

    public function loadUserSchools()
    {
        $account =  DB::table('schools')->orderBy('id', 'DESC')->paginate(20, ['pid', 'school_name', 'school_logo', 'school_address', 'school_contact', 'status','school_email']);
        // dd($account);
        return $account;
    }
    public static function loadUserInfo($id)
    {
        try {
            $user = UserDetail::where('pid', $id)->first(['gender', 'dob', 'religion', 'state', 'lga', 'address']);
            return $user;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
    }
    public function loadUserDetail()
    {
        try {
            $user = UserDetail::where('user_pid', getUserPid())->first(['gender', 'dob', 'religion', 'state', 'lga', 'address', 'firstname', 'lastname', 'othername', 'about']);
            return response()->json($user);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
    }
    public static function getUserDetail($pid)
    {
        try {
            $data = DB::table('users as u')->join('user_details as d', 'd.user_pid', 'u.pid')->where('u.pid', $pid)->first(['u.email', 'd.fullname', 'd.gender', 'u.gsm']);
            return $data;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
    }
    public function updateUserDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'dob' => 'date',
            'gender' => 'required|int',
            'religion' => 'required|int',
            'address' => 'required|string',
            'about' => 'nullable|string|max:255',
        ]);
        if (!$validator->fails()) {
            $data = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'othername' => $request->othername,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'address' => $request->address,
                'about' => $request->about,
                'user_pid' => getUserPid()
            ];
            $dtl = UserDetailsController::insertUserDetails($data);
            if ($dtl) {

                return response()->json(['status' => 1, 'message' => 'details updated']);
            }
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    public function users()
    {
        $users = User::where('email', '<>', null)->orderBy('created_at', 'desc')->paginate(10, ["email", "username", "gsm", "account_status", "email_verified_at", "created_at", "code"]);
        return view('list.users', compact('users'));
    }
}
