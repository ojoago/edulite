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
        $data = School::where('pid', getSchoolPid())->get();
        return view('school.index',compact('data'));
    }
    public function schoolLogin($id)
    {
        $id=base64Decode($id);
        $schoolUser = SchoolStaff::join('schools','schools.pid','school_staff.school_pid')
                        ->where(['school_pid'=>$id, 'school_staff.user_pid'=>getUserPid()])->first(['school_staff.pid', 'school_name']);
        if(!$schoolUser){
            return redirect()->back()->with('error','you are doing it wrong');
        }
        setSchoolPid($id);
        setSchoolType();
        setSchoolUserPid($schoolUser->pid);
        setSchoolName($schoolUser->school_name);
        return redirect()->route('my.school.dashboard');
    }
    public function mySchoolDashboard(){
       
        $data = School::where('pid', getSchoolPid())->get();
        return view('school.dashboard.admin-dashboard', compact('data'));
    }
    public function createSchool(Request $request){
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
            $data = [
                "state_id" => $request->state_id,
                "lga_id" => $request->lga_id,
                "school_name" => $request->school_name,
                "school_contact" => $request->school_contact,
                "school_address" => $request->school_address,
                "school_moto" => $request->school_moto,
                "school_handle" => $request->school_handle,
                "pid" => public_id(),
                "user_pid" => getUserPid(),
                'school_handle'=>$this->schoolHandle(),
            ];
            $request['pid'] = public_id();
            $request['user_pid'] = getUserPid();
            School::create($data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
       
    }

    public function schoolHandle()
    {
        $id = $this->countSchool() + 1;
        $id = strlen($id) == 1 ? '0' . $id : $id;
        return strtoupper(date('yM')) . $id;
    }
    public function countSchool()
    {
        return School::where('school_handle', 'like', '%' . date('yM') . '%')->count('id');
    }

    public static function getSchoolHandle()
    {
        return School::where(['pid' => getSchoolPid()])->pluck('school_handle')->first();
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
