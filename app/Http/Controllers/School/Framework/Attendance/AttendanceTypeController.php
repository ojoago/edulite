<?php

namespace App\Http\Controllers\School\Framework\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Attendance\AttendanceType;
use App\Models\School\Framework\Attendance\ClassAttendance;

class AttendanceTypeController extends Controller
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
        $cnd = ['school_pid'=>getSchoolPid()];
        $data = AttendanceType::where($cnd)->get(['pid','title']);
        $arm = ClassArm::where($cnd)->get(['pid','arm']);
        $session = Session::where($cnd)->get(['pid','session']);
        $cat = Category::where($cnd)->get(['pid','category']);
        $term = Term::where($cnd)->get(['pid','term']);
        return view('school.framework.attendance.index',compact('data','arm','session','cat','term'));
    }

    public function createAttendanceType(Request $request){
        $request->validate([
            'title'=>'required'
        ]);
        $request['pid'] = public_id();
        $request['staff_pid'] = getUserPid();
        $request['school_pid'] = getSchoolPid();
        // dd($request->all());
        $result = $this->createOrUpdateAttendanceType($request->all());
        if($result){
            return redirect()->back()->with('success','attendance type created');
        }
        return redirect()->back()->with('error','failed to create type');
    }

    private function createOrUpdateAttendanceType($data){
        try {
          return AttendanceType::updateOrCreate(['pid'=>$data['pid'],'school_pid'=>$data['school_pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function createCLassAttendance(Request $request){
        $request->validate([
            'attendance_pid'=>'required|string',
            'arm_pid'=>'required|string',
            'session_pid' => 'required|string',
            'term_pid' => 'required|string',
        ]);
        $request['pid'] = public_id();
        $request['school_pid'] = getSchoolPid();
        $request['staff_pid'] = getUserPid();
        $result = $this->createOrUpdateClassAttendance($request->all());
        if($result){
            return redirect()->route('school.attendance')->with('success','class attendance created');
        }
        return redirect()->route('school.attendance')->with('error','failed to create class attendance');
    }

    private function createOrUpdateClassAttendance($data){
        try {
            return ClassAttendance::updateOrCreate(['pid'=>$data['pid'],'school_pid'=>$data['school_pid']],$data);
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
