<?php

namespace App\Http\Controllers\School\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Student\StudentClass;
use App\Models\School\Registration\SchoolParent;
use App\Http\Controllers\School\SchoolController;
use App\Models\School\Student\StudentPickUpRider;

class StudentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(){
       try {
            $data = DB::table('students as s')->join('class_arms as a', 'a.pid', 's.current_class_pid')
                ->leftJoin('school_parents as p', 'p.pid', 's.parent_pid')
                ->leftjoin('user_details as d', 'd.user_pid', 'p.user_pid')
                ->where(['s.school_pid' => getSchoolPid(),'s.status'=>1])//active student
                ->select('arm', 's.fullname', 'reg_number', 's.created_at', 'd.fullname as parent', 's.pid', 's.status')->orderByDesc('s.id')->get();
            return $this->addDataTable($data);
       } catch (\Throwable $e) {
        $error = $e->getMessage();
        logError($error);
        }
    }
    // in active student 
    public function inActiveStudent()
    {
        try {
            $data = DB::table('students as s')->join('class_arms as a','a.pid','s.current_class_pid')
                            ->leftJoin('school_parents as p','p.pid','s.parent_pid')
                            ->join('user_details as d','d.user_pid','p.user_pid')
                            ->where(['s.school_pid'=>getSchoolPid()])->whereIn('s.status',[0,4])//suspended/disabled
                            ->select('arm', 's.fullname', 'reg_number', 's.created_at', 'd.fullname as parent', 's.pid', 's.status')->get();
         
            return $this->addDataTable($data);
            
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }
    // in active student 
    public function exStudent()
    {
        try {
            $data = DB::table('students as s')->join('class_arms as a', 'a.pid', 's.current_class_pid')
                ->leftJoin('school_parents as p', 'p.pid', 's.parent_pid')
                ->join('user_details as d', 'd.user_pid', 'p.user_pid')
                ->where(['s.school_pid' => getSchoolPid()])->whereIn('s.status', [2, 3])//graduated/left school
                ->select('arm', 's.fullname', 'reg_number', 's.created_at', 'd.fullname as parent', 's.pid', 's.status')->get();
            return $this->addDataTable($data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    private function addDataTable($data){
        return datatables($data)
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('school.lists.student.student-action-buttons', ['data' => $data]);
            })
            ->make(true);
    }
    public function studentProfile($pid){
        return view('school.lists.student.student-profile',compact('pid'));
    }
    public function find($pid){
        return view('school.registration.student.register-student',compact('pid'));
    }
    public function loadStudentDetailsById(Request $request){
        $data = DB::table('students as s')->leftjoin('users as u', 'u.pid', 's.user_pid')
            ->leftjoin('user_details as d', 'd.user_pid', 's.user_pid')
            ->select('s.*', 'u.email', 'u.username', 'u.gsm', 'd.*')
            ->where(['s.pid' => base64Decode($request->pid), 's.school_pid' => getSchoolPid()])->first();
        return response()->json($data);
    }
    public function viewStudentProfile(Request $request){
        $data = DB::table('users as u')->join('user_details as d', 'd.user_pid', 'u.pid')
            ->join('students as s', 's.user_pid', 'u.pid')
            ->join('class_arms as a', 's.current_class_pid', 'a.pid')
            ->where(['s.school_pid' => getSchoolPid(), 's.pid' => base64Decode($request->pid)])
            ->select('gsm', 'email', 'username', 's.fullname','reg_number', 's.address', 'dob', 'gender', 's.religion', 's.passport','s.status','a.arm')->first();
         return response()->json(formatStudentProfile($data));
    }


    public function viewStudentclassHistroy(Request $request){
        $data = StudentClass::where([
                    'student_classes.school_pid' => getSchoolPid(),
                     'student_classes.student_pid' => base64Decode($request->pid)
                     ])
                     ->leftjoin('class_arms', 'class_arms.pid', 'student_classes.arm_pid')
                     ->join('sessions', 'sessions.pid', 'student_classes.session_pid')
                     ->get(['session','arm','student_classes.updated_at']);
            // logError($data);
        return datatables($data)
            ->editColumn('date',function($data){
                return $data->updated_at->diffForHumans();
            })
            ->make(true);
    }

    // load student riders/cares 
    public function loadStudentRiders(Request $request){
        $data = DB::table('student_pick_up_riders as p')
                    // ->join('student_pick_up_riders as p','s.pid','p.student_pid')
                    ->join('school_riders as r','r.pid','p.rider_pid')
                    ->join('user_details as d','d.user_pid','r.user_pid')
                    ->join('users as u','u.pid','d.user_pid')
                    ->select('gsm','d.fullname','d.address','username','r.status','r.pid','p.updated_at')
                    ->where(['p.student_pid'=>base64Decode($request->pid),'p.school_pid'=>getSchoolPid()])
                    ->get();
        logError($data);
        return datatables($data)
            ->editColumn('date', function ($data) {
                return date('d F Y',strtotime($data->updated_at));
            })
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? '<button class="btn btn-success btn-sm toggleStudentRider" data-bs-toggle="tooltip" title="Disable Rider/Care" pid ="' . $data->pid . '">Enabled</button>' : '<button class="btn btn-danger toggleStudentRider" pid ="' . $data->pid . '"  data-bs-toggle="tooltip" title="Enable Rider/Care">Disabled</button>';

            })
            ->addIndexColumn()
                ->rawColumns(['data', 'status'])
            ->make(true);
    }
   

    public static function createStudentClassRecord($data)
    {
        $dupParams = [
            'student_pid'   => $data['student_pid'],
            'session_pid'   => $data['session_pid'],
            'arm_pid'       => $data['arm_pid'],
            'school_pid'    => $data['school_pid'],
        ];
        try {
            return StudentClass::updateOrCreate($dupParams, $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    public function updateStudentStatus($pid)
    {
        try {
            $student = Student::where(['school_pid' => getSchoolPid(), 'pid' => base64Decode($pid)])->first(['id', 'status']);
            if ($student) {
                $student->status = $student->status == 1 ? 0 : 1;
                // send notification mail 
                $student->save();
                return 'Student Account Updated';
            }
            return 'Something Went Wrong';
        } catch (\Throwable $e) {
            $error =  $e->getMessage();
            logError($error);
        }
    }
    public static function studentName($pid){
        $std = Student::where(['students.pid'=>$pid, 'students.school_pid'=>getSchoolPid()])->leftjoin('user_details', 'user_details.user_pid','students.user_pid')
                        ->first([
                            'students.reg_number', 
                            'students.fullname', 
                            'students.passport',
                            'gender','dob', 'students.pid']);

        return $std;
    }
    
    public function linkStudentToParent(Request $request){
        $validator = Validator::make($request->all(),[
            'parent_pid'=>'required',
            'student_pid'=>'required'
        ],[
            'student_pid.required'=>'Select at least 1 student',
            'parent_pid.required'=>"Select Student's parent"]
        );

        if(!$validator->fails()){
            foreach($request->student_pid as $pid){
                $result = self::linkParentToStudent(studentPid:$pid,parentPid:$request->parent_pid);
            }
            if($result){

                return response()->json(['status'=>1,'message'=>count($request->student_pid)." student's linked to Parent/Quardian!!!"]);
            }
            return response()->json(['status'=>'error','message'=>"Something Went Wrong!!!"]);
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }

    public static function linkParentToStudent(string $studentPid, string $parentPid){
       try {
            $student = Student::where(['pid' => $studentPid, 'school_pid' => getSchoolPid()])->first();
            $student->parent_pid = $parentPid;
            $student->save();
            //log 
            return $student;
       } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];

            logError($error);
       }
    }

    public static function linkPickUperRiderToStudent(array $data){
        try {
            $dupParams = $data;
            unset($dupParams['rider_pid']);
            return StudentPickUpRider::updateOrCreate($dupParams,$data);
        } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];

            logError($error);
        }
    }


    public static function countParentStudent($parent_pid){
        return SchoolParent::where('pid',$parent_pid)->count('id');
    }
    public static function countRiderStudent($rider_pid){
        return StudentPickUpRider::where('rider_pid', $rider_pid)->count('id');
    }

    public static function studentUniqueId()
    {
        $id = self::countStudent() + 1;
        $id = strlen($id) == 1 ? '0' . $id : $id;
        return SchoolController::getSchoolHandle() . '/' . strtoupper(date('yM')) . $id; // concatenate shool handle with student id
    }
    public static function countStudent()
    {
        return Student::where(['school_pid' => getSchoolPid()])
            ->where('reg_number', 'like', '%' . date('yM') . '%')->count('id');
    }
}
