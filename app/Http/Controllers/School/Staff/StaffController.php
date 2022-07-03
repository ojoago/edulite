<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Subject\Subject;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Staff\SchoolStaff;
use App\Models\School\Staff\StaffClass;
use App\Models\School\Staff\StaffSubject;
use Illuminate\Http\Request;

class StaffController extends Controller
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
    public function index($id)
    {
        $cnd = ['school_pid'=>getSchoolPid()];
        $data = SchoolStaff::where($cnd)->get();
        $arm = ClassArm::where($cnd)->get();
        $sbj = Subject::where($cnd)->get();
        $session = Session::where($cnd)->get();
        $term = Term::where($cnd)->get();
        return view('school.staff.index',compact('data','arm','sbj','session','term'));
    }

    public function create(Request $request){
        $request->validate([
            'role_id'=>'required',
            'staff_id'=>'required',
        ]);
        
        try {
            $request['school_pid'] = getSchoolPid();
            $request['pid'] = public_id();
            $request['user_pid'] = getUserPid();
            SchoolStaff::create($request->all());
            return redirect()->back()->with('success','staff created successfully');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function activateStaffAccount($pid){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(),'pid' => $pid])->first(['id','status']);
        try {
            if ($staff) {
                $staff->status = 1;
                // send notification mail 
                $staff->save();
                return 'staff Account updated';
            }
            return 'Wrong Id provided, make sure your session is still active';
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    public function deactivateStaffAccount($pid){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->first(['id', 'status']);
        try {
            if ($staff) {
                $staff->status = 0;
                // send notification mail 
                $staff->save();
                return 'staff Account updated';
            }
            return 'Wrong Id provided, make sure your session is still active';
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function staffRole($pid){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->first(['id', 'status']);
        try {
            if ($staff) {
                $staff->status = 0;
                // send notification mail 
                $staff->save();
                return 'staff Account updated';
            }
            return 'Wrong Id provided, make sure your session is still active';
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    public function staffAccessRight($pid){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->first(['id', 'status']);
        try {
            if ($staff) {
                $staff->status = 0;
                // send notification mail 
                $staff->save();
                return 'staff Account updated';
            }
            return 'Wrong Id provided, make sure your session is still active';
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function StaffClass(Request $request){
        
        try {
            $request['school_pid'] = getSchoolPid();
            $request['pid'] = public_id();
            $result = StaffClass::create($request->all());
            if($result){
                return redirect()->route('school.staff')->with('success', 'class asigned');
            }
            return redirect()->route('school.staff')->with('error', 'sorry sorry sorry dont cry');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }   
    }
    public function StaffSubject(Request $request){
        try {
            $request['school_pid'] = getSchoolPid();
            $request['pid'] = public_id();
            $result = StaffSubject::create($request->all());
            if($result){
                return redirect()->route('school.staff')->with('success', 'class asigned');
            }
            return redirect()->route('school.staff')->with('error', 'sorry sorry sorry dont cry');
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
