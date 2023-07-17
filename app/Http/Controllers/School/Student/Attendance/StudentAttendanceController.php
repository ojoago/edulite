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
        //$this->middleware('auth');
    }
    public function index()
    {
        //
    }

    public function loadArmStudent(Request $request){
        $data = Student::where([
                            'current_class_pid'=>$request->arm,
                            'current_session_pid'=>activeSession(),
                            'status'=>1
                        ])->get(['pid', 'reg_number', 'fullname']);
                        $arm = $request->arm;
        return view('school.student.attendance.take-attendance',compact('data', 'arm'));
    }
    public function submitStudentAttendance(Request $request){
        if($request->check && $request->student){
           if(!$this->exclodeWeekend($request->date ?? justDate())){
               return response()->json(['status' => 'error', 'message' => "No Class! it's weekend"]);
           }
            $pid = $this->recordStudentAttendance($request->all());
            if($pid){
                $result = $this->takeAttendance($request->check,$request->student,$pid);
                if($result){
                    return response()->json(['status' => 1, 'message' => count($request->student).' Student(s) Attendance taken']);
                }
            }
           
            return response()->json(['status'=>'error','message'=>'Error Something Went Wrong']);
        }
        return response()->json(['status'=>0,'message'=>'Tick participated for at least 1 student']);
    }
    private function exclodeWeekend($date){
        if(in_array(date('l', strtotime($date)),['Sunday',''])){
          return false;
        }
        return true;
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

    private function takeAttendance(array $checks, $student,  string $pid){
        $count = count($student);
        $data = [
            'record_pid' => $pid,
            'school_pid'=>getSchoolPid()
        ];
        // $dataArray = [];
        // DB::statement("DELETE FROM attendances WHERE record_pid = '".$pid."' AND school_pid='".getSchoolPid()."' ");
        // $atn = Attendance::where($data)->get('id');
        // Attendance::destroy($atn->toArray());
        if($count>0){
            for ($i = 0; $i < $count; $i++) {
                $data['student_pid'] = $student[$i];
                $dupParam = $data;
                $data['status'] = isset($checks[$i]) ? 1 : 0;
                $result = Attendance::updateOrCreate($dupParam, $data);
            }
        }
        // $result = Attendance::insert($dataArray);
        return $result;
    }

    // student attendance history 
    public function loadStudentAttendanceHistory(Request $request){
        if (isset($request->term_pid) && isset($request->session_pid) && isset($request->arm_pid)) {
            $where = [
                'r.school_pid' => getSchoolPid(),
                'r.arm_pid' => $request->arm_pid,
                'r.term_pid' => $request->term_pid,
                'r.session_pid' => $request->session_pid
            ];
        } elseif (isset($request->term_pid)) {
            $where = [
                'r.school_pid' => getSchoolPid(),
                'r.arm_pid' => $request->arm_pid,
                'r.term_pid' => $request->term_pid,
                'r.session_pid' => activeSession()
            ];
        } else {
            $where = [
                'r.school_pid' => getSchoolPid(),
                'r.arm_pid' => $request->arm_pid,
                'r.term_pid' => activeTerm(),
                'r.session_pid' => activeSession()
            ];
        }
        $data = DB::table('attendances as a')
        ->join('attendance_records as r', 'r.pid', 'a.record_pid')
        ->join('students as s', 's.pid', 'a.student_pid')
        ->select('fullname', 'reg_number', 'r.date', 'a.status')
        ->where($where)
            ->orderBy('date')
            ->orderBy('a.updated_at')
            ->get();
        return datatables($data)
            ->editColumn('start', function ($data) {
                return date('y-m-d, D', strtotime($data->date));
            })
            ->editColumn('title', function ($data) {
                return $data->status == 1 ? '<span class="bg-success text-white p-1">Present</span>' : '<span class="bg-danger text-white p-1">Absent</span>';
            })
            ->rawColumns(['data', 'title'])
            ->make(true);
    }

    // student attendance count 
    public function loadStudentAttendanceCount(Request $request){
        if(isset($request->term_pid) && isset($request->session_pid) && isset($request->arm_pid)){
            $where = [
                'r.school_pid' => getSchoolPid(),
                'r.arm_pid' => $request->arm_pid,
                'r.term_pid' => $request->term_pid,
                'r.session_pid' => $request->session_pid
            ];
        }elseif(isset($request->term_pid)){
            $where = [
                'r.school_pid' => getSchoolPid(),
                'r.arm_pid' => $request->arm_pid,
                'r.term_pid' => $request->term_pid,
                'r.session_pid' => activeSession()
            ];
        }else{
            $where = [
                'r.school_pid' => getSchoolPid(),
                'r.arm_pid' => $request->arm_pid,
                'r.term_pid' => activeTerm(),
                'r.session_pid' => activeSession()
            ];
        }
        $data = DB::table('attendances as a')
                ->join('attendance_records as r', 'r.pid', 'a.record_pid')
                ->join('students as s', 's.pid', 'a.student_pid')
                ->select(DB::raw("fullname,reg_number,
                                    COUNT(CASE WHEN a.status = 1 THEN 'present' END) as 'present',
                                    COUNT(CASE WHEN a.status = 0 THEN 'absent' END) as 'absent'
                                     "))
                ->where($where)
                    ->groupBy('reg_number')
                    ->groupBy('fullname')
                    // ->groupBy('a.status')
                    ->orderBy('date')
                    ->orderBy('a.updated_at')
                    ->get();
        // +923213274255
        return datatables($data)
                       
                        ->editColumn('present',function($data){
                            return '<span class="bg-success text-white p-2">'.$data->present.'</span>' ;
                        })
                        ->editColumn('absent',function($data){
                            return '<span class="bg-danger text-white p-2">'.$data->absent.'</span>' ;
                        })
                        ->rawColumns(['data','present','absent'])
                        ->addIndexColumn()
                        ->make(true);
    }
    // particular student attendance 
    // fullcalender 
    public function studentAttendance(Request $request){
       $data = DB::table('attendances as a')->join('attendance_records as r','r.pid','a.record_pid')
                    ->select(DB::raw("
                                DISTINCT(r.date) as start,
                                (CASE a.status WHEN 1 THEN 'present'
                                            WHEN 0 THEN 'absent'
                                END) as title"))
                    ->where([
                            'a.student_pid'=>base64Decode($request->pid),
                            'r.term_pid'=>activeTerm(),
                            'r.session_pid'=>activeSession(),
                            'a.school_pid'=>getSchoolPid()])
                    // ->where('a.status','<>',NULL)
                    ->get();
    
       return response()->json($data->toArray());
    }
}
