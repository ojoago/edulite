<?php

namespace App\Http\Controllers\School\Student\Attendance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\Framework\Attendance\Attendance;
use App\Models\School\Framework\Attendance\AttendanceRecord;

class StudentAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
    }

    public function loadArmStudent(Request $request){
        $data = Student::where([
                            'current_class'=>$request->arm,
                            'current_session_pid'=>activeSession(),
                            'status'=>1
                        ])->get(['pid', 'reg_number', 'fullname']);
                        $arm = $request->arm;
        return view('school.student.attendance.take-attendance',compact('data', 'arm'));
    }
    public function submitStudentAttendance(Request $request){
        // $atn = count($request->check) ?? null;
        // return response()->json(['status'=>0,'message'=> $request->all()]);
        if($request->check){
            $pid = $this->recordStudentAttendance($request->all());
            if($pid){
                $result = $this->takeAttendance($request->check,$pid);
                if($result){
                    return response()->json(['status' => 1, 'message' => count($request->check).' Student(s) Attendance taken']);
                }
            }
           
            return response()->json(['status'=>'error','message'=>'Error Something Went Wrong']);
        }
        return response()->json(['status'=>0,'message'=>'Tick participated for at least 1 student']);
    }

    private function recordStudentAttendance($data){
        $pid = AttendanceRecord::where([
                                'term_pid'=>activeTerm(),
                                'session_pid'=>activeSession(),
                                'date'=>$data['date'] ?? justDate(),
                                'arm_pid'=>$data['arm'],
                                'school_pid'=>getSchoolPid(),
                            ])->pluck('pid')->first();
        $result = AttendanceRecord::updateOrCreate([
            'pid'=>$pid,
        ],[
                                'school_pid'=>getSchoolPid(),
                                'date'=>$data['date'] ?? justDate(),
                                'note'=>$data['note'],
                                'pid'=> $pid ?? public_id(),
                                'arm_pid'=>$data['arm'],
                                'term_pid'=>activeTerm(),
                                'session_pid'=>activeSession(),
                                'staff_pid'=>getSchoolUserPid()
                            ]);
        return $result->pid;
    }

    private function takeAttendance(array $checks,string $pid){
        $count = count($checks);
        $data = [
            'record_pid' => $pid,
            'school_pid'=>getSchoolPid()
        ];
        $dataArray = [];
        DB::statement("DELETE FROM attendances WHERE record_pid = '".$pid."' AND school_pid='".getSchoolPid()."' ");
        // $atn = Attendance::where($data)->get('id');
        // Attendance::destroy($atn->toArray());
        for ($i=0; $i<$count; $i++) { 
            $data['student_pid'] = $checks[$i];
            $dataArray[] = $data; 
        }
        $result = Attendance::insert($dataArray);
        return $result;
    }
}
