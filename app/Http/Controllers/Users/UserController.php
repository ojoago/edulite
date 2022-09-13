<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\School\School;
use App\Models\Users\UserDetail;
use App\Http\Controllers\Controller;
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
        AuthController::clearAuthSession();
        $data = School::where('user_pid', getUserPid())->get();
        // return view('school.index', );
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
