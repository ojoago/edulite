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
use App\Http\Controllers\School\Parent\ParentController;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
       try {
            $data = Student::join('class_arms', 'class_arms.pid', 'students.current_class')
            ->where(['students.school_pid' => getSchoolPid(), 'students.status' => 1])
            ->get(['arm', 'students.fullname', 'reg_number', 'students.created_at','parent_pid','students.pid']);
            return datatables($data)
                ->addColumn('parent',function($data){
                return ParentController::getParentFullname($data->parent_pid);
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->diffForHumans();
            })->addIndexColumn()
            ->addColumn('action',function($data){
                return view('school.lists.student.student-action-buttons',['data'=>$data]);
            })
            ->make(true);
       } catch (\Throwable $e) {
        $error = $e->getMessage();
        logError($error);
        }
    }

    public function studentProfile($pid){
        return view('school.lists.student.student-profile',compact('pid'));

    }
    public function viewStudentProfile(Request $request){
        $data = DB::table('users as u')->join('user_details as d', 'd.user_pid', 'u.pid')
            ->join('students as s', 's.user_pid', 'u.pid')
            ->where(['school_pid' => getSchoolPid(), 's.pid' => base64Decode($request->pid)])
            ->select('gsm', 'email', 'username', 's.fullname','reg_number', 's.address', 'dob', 'gender', 's.religion', 's.passport')->first();
        echo formatStudentProfile($data);
    }
    public function viewStudentclassHistroy(Request $request){
       
        $data = StudentClass::where([
                    'student_classes.school_pid' => getSchoolPid(),
                     'student_classes.student_pid' => base64Decode($request->pid)])
                     ->join('class_arms', 'class_arms.pid', 'student_classes.arm_pid')
                     ->join('sessions', 'sessions.pid', 'student_classes.session_pid')
                     ->get(['session,arm,student_classes.created_at AS date']);
    
        // $data = DB::table('student_classes as r')->join('class_arms as a', 'a.pid', 'r.arm_pid')
        // ->join('sessions as s', 's.pid', 'r.session_pid')
        // ->where(['r.school_pid' => getSchoolPid(), 'r.student_pid' => base64Decode($request->pid)])
        //     ->get(DB::raw('session,arm,r.created_at AS date'));
        return datatables($data)
            // ->editColumn('date',function($data){
            //     return $data->date->diffForHumnas();
            // })
            ->make(true);
    }

    public static function createSchoolStudent($data){

        try {
            return Student::create($data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
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
    public static function studentName($pid){
        $std = Student::where(['students.pid'=>$pid, 'students.school_pid'=>getSchoolPid()])->leftjoin('user_details', 'user_details.user_pid','students.user_pid')
                        ->first([
                            'students.reg_number', 
                            'students.fullname', 
                            'students.student_image_path',
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
            $error = $e->getMessage();
            logError($error);
       }
    }

    public static function linkPickUperRiderToStudent(array $data){
        try {
            $dupParams = $data;
            unset($dupParams['rider_pid']);
            return StudentPickUpRider::updateOrCreate($dupParams,$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
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
