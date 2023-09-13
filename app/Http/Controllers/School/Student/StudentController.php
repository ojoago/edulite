<?php

namespace App\Http\Controllers\School\Student;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Student\StudentClass;
use App\Http\Controllers\Auths\AuthController;
use App\Models\School\Registration\SchoolParent;
use App\Http\Controllers\School\SchoolController;
use App\Models\School\Student\StudentPickUpRider;
use App\Http\Controllers\Users\UserDetailsController;

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


    public function staffActiveStudent(Request $request){
        $data = DB::table('students as s')->join('class_arms as a', 'a.pid', 's.current_class_pid')
                ->join('staff_classes as c','c.arm_pid', 's.current_class_pid')
                ->leftJoin('school_parents as p', 'p.pid', 's.parent_pid')
                ->leftjoin('user_details as d', 'd.user_pid', 'p.user_pid')
        ->where(['s.school_pid' => getSchoolPid(), 's.status' => 1,'c.teacher_pid'=>getSchoolUserPid()]) //active student
        ->select('arm', 's.fullname', 'reg_number', 's.created_at', 'd.fullname as parent', 's.pid', 's.status')->orderByDesc('s.id')->get();
        
        return $this->addDataTable($data);
    }

    private function loadStudentQuery($condition){

    }
    public function studentProfile($pid){
        setStudentPid(base64Decode($pid));
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
            ->select('gsm', 'email', 'username', 's.fullname','reg_number', 's.address', 'dob', 'd.gender', 's.religion', 's.passport','s.status','a.arm')->first();
         return response()->json(formatStudentProfile($data));
    }


    public function viewStudentclassHistroy(Request $request){
        $data = StudentClass::where([
                    'student_classes.school_pid' => getSchoolPid(),
                     'student_classes.student_pid' => $request->pid
                     ])
                     ->leftjoin('class_arms', 'class_arms.pid', 'student_classes.arm_pid')
                     ->join('sessions', 'sessions.pid', 'student_classes.session_pid')
                     ->get(['session','arm']);
            // logError($data);
        return datatables($data)

            // ->editColumn('date',function($data){
            //     return $data->updated_at->diffForHumans();
            // })
            ->make(true);
    }
    public function viewStudentResult(Request $request){
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
            logError($e->getMessage());
            return false;
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
                            'user_details.gender',
                            'dob','students.pid'
                            ]);

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
            logError($e->getMessage());
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
        $id = sprintNumber(self::countStudent() + 1);
        // $id = strlen($id) == 1 ? '0' . $id : $id;
        return (SchoolController::getSchoolCode() ?? SchoolController::getSchoolHandle()) . '/' . strtoupper(date('yM')) . $id; // concatenate shool handle with student id
    }
    public static function getStudentDetailBypId($pid)
    {
        $data = DB::table('students as s')->join('users as u', 'u.pid', 's.user_pid')
                ->join('user_details as d', 'd.user_pid', 's.user_pid')
                ->select('u.email', 'u.gsm', 's.fullname')
                ->where(['s.pid' => $pid, 's.school_pid' => getSchoolPid()])->first();
        return $data;
    }
    public static function countStudent()
    {
        return Student::where(['school_pid' => getSchoolPid()])
            ->where('reg_number', 'like', '%' . date('yM') . '%')->count('id');
    }


    public function findStudentByReg(Request $request){
        $data = Student::where(['school_pid'=>getSchoolPid(),'reg_number'=>$request->reg])->first();
        return response()->json($data);
    }


    // student registration  goes here
    private  $pwd = 123456;

    public function registerStudent(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'firstname' => "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
                'lastname' => "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
                'othername' => "nullable|string|regex:/^[a-zA-Z0-9'\s]+$/",
                'gsm' => [
                    'nullable', 'digits:11',
                    Rule::unique('users')->where(function ($param) use ($request) {
                        $param->where('pid', '<>', $request->user_pid);
                    })
                ],
                'username' => [
                    'nullable', 'string', 'min:3', "regex:/^[a-zA-Z0-9\s]+$/",
                    Rule::unique('users')->where(function ($param) use ($request) {
                        $param->where('pid', '<>', $request->user_pid);
                    })
                ],
                'email' => [
                    'nullable', 'string', 'email', "regex:/^[a-zA-Z0-9.@\s]+$/",
                    Rule::unique('users')->where(function ($param) use ($request) {
                        $param->where('pid', '<>', $request->user_pid);
                    })
                ], //|||unique:users,email
                'gender' => 'required',
                'dob' => 'required|date',
                'religion' => 'required',
                'address' => 'required',
                'type' => 'required',
                'category_pid' => 'required_without:pid|string',
                'class_pid' => 'required_without:pid|string',
                'arm_pid' => 'required_without:pid|string',
                'passport' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ],
            [
                'dob.required' => 'Student Date of Birth is required',
                'firstname.required' => 'Enter Student First Name',
                'lastname.required' => 'Enter Student Last Name',
                'religion.required' => 'Select Student Religion',
                // 'state.required'=>'Select Student State of Origin',
                // 'lga.required'=>'Select LGA of Origin',
                'address.required' => 'Enter Student Residence Address',
                'type.required' => 'Select Student Type',
                'session_pid.required_without' => 'Select Session for Student',
                'term_pid.required_without' => 'Select Term for Student',
                'category_pid.required_without' => 'Select Category for Student',
                'class_pid.required_without' => 'Select Class for Student',
                'arm_pid.required_without' => 'Select Class Arm for Student',
                'gsm.digits' => 'phone number should be empty 11 digits',
                'lastname.regex' => 'Special character is not allowed',
                'lastname.regex' => 'Special character is not allowed',
                'othername.regex' => 'Special character is not allowed',
            ]

        );
        if (!$validator->fails()) {
            $data = [
                'account_status' => 1,
                'password' => $this->pwd,
                'username' => $request->username ?? AuthController::uniqueUsername($request->firstname),
                'gsm' => $request->gsm,
                'pid' => $request->user_pid,
            ];
            if ($request->email) { // do this check cos email comes as '' and cause dup, so if email is empty then ignore email column
                $data['email'] = $request->email;
            }
            $detail = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'othername' => $request->othername,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'religion' => $request->religion,
                'state' => $request->state,
                'lga' => $request->lga,
                'address' => $request->address,
            ];
            $student = [
                'gender' => $request->gender,
                'dob' => $request->dob,
                'religion' => $request->religion,
                'state' => $request->state,
                'lga' => $request->lga,
                'address' => $request->address,
                'type' => $request->type,
                'pid' => $request->pid ?? public_id(),
                'staff_pid' => getSchoolUserPid(),
                'school_pid' => getSchoolPid(),
            ];
            if (!$request->pid) {
                $student['reg_number'] =  StudentController::studentUniqueId();
                $student['session_pid'] =  activeSession();
                $student['term_pid'] =  activeTerm();
                $student['admitted_class'] =  $request->arm_pid;
                $student['current_class_pid'] =  $request->arm_pid;
                $student['current_session_pid'] =  activeSession();
            }

            $studentClass = [
                'session_pid' => activeSession(),
                'arm_pid' => $request->arm_pid,
                'school_pid' => $student['school_pid'],
                'staff_pid' => getSchoolUserPid(),
            ];
            try {
                DB::beginTransaction();
                // create user 
                $user = AuthController::createUser($data);
                if ($user) {
                    $detail['user_pid'] = $request->user_pid ?? $user->pid; // grt user pid and foreign key
                    // create user detail 
                    $userDetails = UserDetailsController::insertUserDetails($detail);
                    if ($userDetails) {
                        $student['fullname'] = $userDetails->fullname ?? UserDetailsController::getFullname($request->pid); //get student fullname and save along with student info
                        $student['user_pid'] = $request->user_pid ?? $user->pid; //get student user pid and save along with student info
                        // and prevent update if student leaves school 
                        if ($request->passport) {
                            $name = ($request->reg_number ?? $student['reg_number']);
                            $student['passport'] = saveImg(image: $request->file('passport'), name: $name);
                        }

                        $studentDetails = SchoolController::createSchoolStudent($student); // create school student
                        if ($studentDetails) {
                            DB::commit();
                            if ($request->parent_pid) {
                                $student_pid =  $studentDetails->pid ?? $request->pid;
                                self::linkParentToStudent(parentPid: $request->parent_pid, studentPid: $student_pid);
                            }
                            // student class history  
                            if (!$request->pid) {
                                $studentClass['student_pid'] = $studentDetails->pid;
                                self::createStudentClassRecord($studentClass);
                                return response()->json(['status' => 1, 'message' => 'Account  created Successfully!!! here is Student Reg. No. ' . $studentDetails->reg_number]);
                            }
                            return response()->json(['status' => 1, 'message' => 'Student Account Updated Successfully!!']);
                        }
                        DB::rollBack();
                        return response()->json(['status' => 1, 'message' => 'account completely  created but student class details not taken, so please use ' . $studentDetails->reg_number . ' to take create history']);
                    }

                    return response()->json(['status' => 1, 'message' => 'account created completely but student profile not created, so please use ' . $user->username . ' link to school']);
                }
                return response()->json(['status' => 1, 'message' => 'account created but not completed, so please use ' . $user->username . ' to update details and link to school']);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                logError(['error' => $e->getMessage(), 'line' => __LINE__]);
                return response()->json(['status' => 'error', 'message' => 'Something went Wrong... error logged']);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }
}
