<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School\School;
use App\Models\School\Staff\SchoolStaff;
use Illuminate\Http\Request;

class SchoolController extends Controller
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
        setSchoolPid('4695NJ102161072M4N26902OU226');
        $data = School::where('pid', getSchoolPid())->get();
        return view('school.index',compact('data'));
    }
    public function schoolLogin($id)
    {
        $id=base64Decode($id);
        $schoolUser = SchoolStaff::where(['school_pid'=>$id,'user_pid'=>getUserPid()])->first();
        if(!$schoolUser){
            return redirect()->back()->with('error','you are doing it wrong');
        }
        setSchoolPid($id);
        setSchoolUserPid($schoolUser->pid);
        return redirect()->route('my.school.dashboard');
    }
    public function mySchoolDashboard(){
       
        $data = School::where('pid', getSchoolPid())->get();
        return view('school.dashboard.admin-dashboard', compact('data'));
    }
    public function create(Request $request){
        $request->validate([
            "state_id" =>"required|int",
            "lga_id" => "required|int",
            "school_name" => "required",
            "school_contact" => "required",
            "school_address" => "required",
            "school_moto" => "required",
            "school_handle" => "required",
        ]);
        try {
            $request['pid'] = public_id();
            $request['user_pid'] = getUserPid();
            School::create($request->all());
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
       
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
        try {
            $request['user_pid'] = getUserPid();
            $request['pid'] = base64Decode($id);
            $var = School::updateOrCreate(['pid' => $request['pid']], $request->all());
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            return redirect()->back()->with('error', 'Error logged');
        }
        dd($var);
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
