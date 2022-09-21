<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\School\School;
use App\Models\Users\UserDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\SchoolStaff;
use App\Http\Controllers\Auths\AuthController;

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
        $schools = School::where('user_pid', getUserPid())->get(['pid', 'school_name']);
        $office = DB::table('school_staff as t')
        ->join('schools as s','s.pid','t.school_pid')
        ->where('t.user_pid', getUserPid())->get(['s.pid', 's.school_name']);
        if(!getDefaultLanding()){
            if($schools->isEmpty() || $office->isEmpty()){
                if ($schools->isEmpty()) {
                    if (count($office) === 1) {
                        $pid = $office[0]->pid;
                    }
                } else {
                    if (count($schools) === 1) {
                        $pid = $schools[0]->pid;
                    }
                }
                AuthController::clearAuthSession();
                return redirect()->route('login.school', [base64Encode($pid)]);
            }
            
        }
        AuthController::clearAuthSession();
        $data =['schools'=> $schools,'work'=>$office];
        return view('users.dashboard', compact('data'));
    }

    public static function loadUserInfo($id)
    {
        $user = UserDetail::where('pid', $id)->first(['gender', 'dob', 'religion', 'state', 'lga', 'address']);
        return $user;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
