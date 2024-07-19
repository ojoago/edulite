<?php

namespace App\Http\Controllers\School;

use App\Models\SchoolUser;
use Illuminate\Http\Request;
use App\Models\School\School;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\Rider\SchoolRider;
use App\Models\School\Staff\SchoolStaff;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Users\UserController;
use App\Models\School\Registration\SchoolParent;
use App\Http\Controllers\School\Rider\RiderController;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Staff\StaffClass;
use App\Models\School\Staff\StaffSubject;
use App\Models\School\Student\Result\StudentClassResult;

class SchoolController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $pid = getSchoolPid();
        return view('school.create-school',compact('pid'));
    }
    public function loadSchoolDetailById()
    {
        $data = School::where('pid', getSchoolPid())->first();
        return response()->json($data);
    }
    public function schoolSetup(){
        if (session('status') && session('status') === 1) {
            return redirect()->route('my.school.dashboard')->with('success','Congratualtions!!! Setups completed... enjoy '. env('APP_NAME'));
        }
        return view('school.dashboard.setup');

    }
    public function schoolLogin($id,Request $request)
    {
        $role = $request->role;
        $id=base64Decode($id);
        // $schoolUser = DB::table('school_users as u')->join('schools as s','s.pid','u.school_pid')
        //                                         ->join('school_staff as ss', 'ss.pid','u.pid')
        //                                         ->leftJoin('staff_accesses as a','a.staff_pid','u.pid')
        //                 ->where(['u.school_pid' => $id, 'u.user_pid' => getUserPid()])
        //                 ->first(['u.pid', 's.school_name', 's.school_logo', 's.type', 'u.role', 'ss.status','a.access','s.status as sts','s.stage']);
        // dd($schoolUser);

        if($role){
            $where = ['u.school_pid' => $id, 'u.user_pid' => getUserPid(), 'role' => $role];
        }else{
            $where = ['u.school_pid' => $id, 'u.user_pid' => getUserPid()];
        }
        $schoolUser = DB::table('school_users as u')->join('schools as s', 's.pid', 'u.school_pid')
        ->leftJoin('staff_accesses as a', 'a.staff_pid', 'u.pid')
        ->where($where)
            ->first(['u.pid', 's.school_name', 's.school_logo', 's.type', 'u.role', 'u.status', 'access', 's.status as sts', 's.stage']);
        // dd($schoolUser);
        if(!$schoolUser){
            return redirect()->back()->with('error','you are doing it wrong');
        }
        if ($schoolUser && $schoolUser->sts === 0) {
            return redirect()->back()->with('error', $schoolUser->school_name.' Has been denied access, please contact your management');
        }
        if ($schoolUser && $schoolUser->status != 1) { // if status not eqaul to 1 then deny login
            return redirect()->route('users.home')->with('warning', 'you Have been denied access, please contact your school.');
        }

        setUserActiveRole($schoolUser->role);// set staff primary role
        setSchoolPid($id);
        setSchoolType($schoolUser->type);
        setSchoolUserPid($schoolUser->pid);
        setSchoolName($schoolUser->school_name);
        setSchoolLogo($schoolUser->school_logo);
        setUserAccess(json_decode($schoolUser->access) ?? null);// get staff adon roles
        setDefaultLanding(true);
        $code = self::getSchoolCode() ?? self::getSchoolHandle();// get school handle or code
        setSchoolCode($code);
        
        // check if setup is not complete 
        if($schoolUser->sts==2){
            session(['stage' => $schoolUser->stage+1, 'status' => $schoolUser->sts,'total'=>12]); 
        }else{
            session(['stage' => null, 'status' => null]);
        }

        // dd(getUserActiveRole());
        // check user role and redirect to a corresponding dashboard
        return redirect()->route('my.school.dashboard');

    }

    public function mySchoolDashboard(){
       
        // $data = School::where('pid', getSchoolPid())->get()->dd();
        // here show dashboard and load params based on role
        switch (getUserActiveRole()) {
            case schoolTeacher():
                if (session('status') && session('status') == 2) {
                    return redirect()->route('setup.school');
                }
                if(schoolAdmin()){
                    return redirect()->route('admin.dashboard');;
                    
                }
                if(headTeacher()){
                    return redirect()->route('head.teacher.dashboard');;
                    
                }
                if(classTeacher()){
                    return redirect()->route('class.teacher.dashboard');;
                }
                if(subjectTeacher()){
                    return redirect()->route('teacher.dashboard');;

                }
                if(schoolClerk()){
                    return redirect()->route('admin.dashboard');;

                }
                if(schoolSecretary()){
                    return redirect()->route('admin.dashboard');;

                }
                if(schoolPortal()){
                    return redirect()->route('admin.dashboard');;

                }
                return $this->staffLogin();
            case parentRole():
                return redirect()->route('parent.dashboard');
            case studentRole():
                return redirect()->route('student.dashboard');;
            case riderRole():
                return redirect()->route('rider.dashboard');;
            default:
                return redirect()->route('login.school', [base64Encode(getSchoolPid())])->with('warning', 'who are you!!!');
                break;
        }
        return redirect()->route('my.school.dashboard');
        
    }


    public function adminDashboard(){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'status' => 1])->count('id');
        $students = Student::where(['school_pid' => getSchoolPid(), 'status' => 1])->count('id');
        // $gender = Student::where(['school_pid' => getSchoolPid(), 'status' => 1])->groupBy('gender')->count('id');
        $riders = SchoolRider::where(['school_pid' => getSchoolPid(), 'status' => 1])->count('id');
        $parents = SchoolParent::where(['school_pid' => getSchoolPid(), 'status' => 1])->count('id');
        // $parents = DB::table('school_parents as p') ->join('students as s', 's.parent_pid', 'p.pid')
        //     ->where(['p.school_pid' => getSchoolPid(), 's.status' => 1])->distinct('p.pid')->count('p.id');
        $data = ['staff' => $staff, 'students' => $students, 'riders' => $riders, 'parents' => $parents];

        // dd($this->growthStatistics());
        return view('school.dashboard.admin-dashboard', compact('data'));
    }


    public function principalDashboard(){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $students = Student::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $riders = SchoolRider::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $parents = DB::table('school_parents as p') ->join('students as s', 's.parent_pid', 'p.pid')
            ->where(['p.school_pid' => getSchoolPid(), 's.status' => 1])->distinct('p.pid')->count('p.id');
        $data = ['staff' => $staff, 'students' => $students, 'riders' => $riders, 'parents' => $parents];

        // dd($this->growthStatistics());
        return view('school.dashboard.head-teacher-dashboard', compact('data'));
    }
    
    
    public function classTeacherDashboard(){
        $class = DB::table('staff_classes as c')->join('class_arms as a','a.pid','c.arm_pid')->where(['c.school_pid' => getSchoolPid(), 'c.teacher_pid' => getSchoolUserPid(), 'c.term_pid' => activeTerm(), 'c.session_pid' => activeSession()])->select('arm')->get();
        $subjects = DB::table('staff_subjects as s')->join('class_arm_subjects as c','c.pid', 's.arm_subject_pid')->join('class_arms as a','c.arm_pid','a.pid')->join('subjects as b','b.pid','c.subject_pid')->where(['s.school_pid' => getSchoolPid(), 's.teacher_pid' => getSchoolUserPid(), 's.term_pid' => activeTerm(), 's.session_pid' => activeSession()])->select('arm','subject')->get();
        // $class = StaffClass::where(['school_pid' => getSchoolPid(), 'teacher_pid' => getSchoolUserPid() , 'term_pid' => activeTerm(), 'session_pid' => activeSession() ])->count();
        // $subjects = StaffSubject::where(['school_pid' => getSchoolPid(), 'teacher_pid' => getSchoolUserPid(), 'term_pid' => activeTerm() , 'session_pid' => activeSession() ])->count();
        $riders = SchoolRider::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $parents = DB::table('school_parents as p') ->join('students as s', 's.parent_pid', 'p.pid')
            ->where(['p.school_pid' => getSchoolPid(), 's.status' => 1])->distinct('p.pid')->count('p.id');
        $data = ['class' => $class, 'subjects' => $subjects, 'riders' => $riders, 'parents' => $parents];

        // dd($this->growthStatistics());
        return view('school.dashboard.class-teacher-dashboard', compact('data'));
    }

    public function teacherDashboard(){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $students = Student::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $riders = SchoolRider::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $parents = DB::table('school_parents as p') ->join('students as s', 's.parent_pid', 'p.pid')
            ->where(['p.school_pid' => getSchoolPid(), 's.status' => 1])->distinct('p.pid')->count('p.id');
        $data = ['staff' => $staff, 'students' => $students, 'riders' => $riders, 'parents' => $parents];

        // dd($this->growthStatistics());
        return view('school.dashboard.teacher-dashboard', compact('data'));
    }


    public function switchRole($role){
        if(!in_array(getUserActiveRole(), getUserAccess())){
            $access= getUserAccess();
            array_push($access, getUserActiveRole());
            setUserAccess($access);
        }
        setUserActiveRole($role); // get staff primary role
        return response()->json(['status' => 1, 'message' => 'role switched']);
    }
    private function staffLogin(){
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $students = Student::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $riders = SchoolRider::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $parents = DB::table('school_parents as p')
        ->join('students as s', 's.parent_pid', 'p.pid')
            ->where(['p.school_pid' => getSchoolPid(), 's.status' => 1])->distinct('p.pid')->count('p.id');
        $data = ['staff' => $staff, 'students' => $students, 'riders' => $riders, 'parents' => $parents];
        
        // dd($this->growthStatistics());
        return view('school.dashboard.admin-dashboard', compact('data'));
    }


    public function parentLogin(){

        setStudentPid();//set student pid to null 
        $data = DB::table('students as s')->join('class_arms as a','a.pid','s.current_class_pid')
                                        ->join('sessions as i','i.pid','current_session_pid')
                                        ->where(['s.school_pid' => getSchoolPid(), 's.parent_pid' => getSchoolUserPid()])
                                        ->orderByDesc('s.id')
                                        ->get(['reg_number','fullname','s.status','passport','session','arm','s.pid']);//->dd();
        if(count($data)==1){
            return redirect()->route('student.login', ['id' => base64Encode($data[0]->pid)]);
        }
        return view('school.dashboard.parent-dashboard', compact('data'));
    }
    public function studentLogin(){
        $data = Student::where(['school_pid' => getSchoolPid(), 'pid' => getSchoolUserPid()])->first(['pid','status']);
        setStudentPid($data->pid); 
        $result = StudentClassResult::where('student_pid',$data->pid)->count('id');
        
        
        $attendance =  DB::table('attendances as a')->join('attendance_records as r', 'r.pid', 'a.record_pid')
                ->join('students as s', 's.pid', 'a.student_pid')
                ->select(DB::raw("  COUNT(CASE WHEN a.status = 1 THEN 'present' END) as 'present',
                                    COUNT(CASE WHEN a.status = 0 THEN 'absent' END) as 'absent',
                                    COUNT(CASE WHEN a.status = 2 THEN 'excused' END) as 'excused'
                                     "))
                ->where( [
                'r.school_pid' => getSchoolPid(),
                'a.student_pid' => $data->pid ,
                'r.term_pid' => activeTerm(),
                'r.session_pid' => activeSession()
            ])->first();

        $invoices = DB::table('student_invoices as i')->join('class_invoice_params as p', 'p.pid', 'i.param_pid')->where([ 'i.student_pid'=>$data->pid , 'p.term_pid' =>activeTerm() , 'p.session_pid' => activeSession() ])->count('i.pid');

        return view('school.dashboard.student-dashboard', compact('data', 'attendance', 'result', 'invoices'));

    }
    public function riderLogin(){
        $data = SchoolRider::where(['school_pid' => getSchoolPid(), 'user_pid' => getUserPid()])->first(['pid']);//->dd();
        if($data){
            return redirect()->route('school.rider.profile', ['id' => base64Encode($data->pid)]);
        }
        return view('school.dashboard.rider-dashboard', compact('data'));
    }

    // create school 
    public function createSchool(Request $request){
        if($request->school_name){
            $request['school_code'] = $request->school_code ?? getInitials($request->school_name);
        }
        $validator = Validator::make($request->all(),[
            "state" => "required",
            "type" => "required",
            "lga" => "required",
            "school_email" => "nullable|email",
            "school_name" => ["required",
                            Rule::unique('schools')->where(function($param){
                                $param->where('pid','<>',getSchoolPid());
                            })],
            "school_contact" => "required",
            "school_address" => "required|string",
            "school_moto" => "required",
            "school_code" => ["nullable", 
                Rule::unique('schools')->where(function ($param){
                    $param->where('pid', '<>', getSchoolPid());
                })],
            "school_logo" => "nullable|image|mimes:jpeg,png,jpg,gif",
        ],['school_code.unique'=> $request->school_code.' already exist, Enter a differnet one']);

        if(!$validator->fails()){
            $data = [
                "state" => $request->state,
                "type" => $request->type,
                "lga" => $request->lga,
                "school_name" => $request->school_name,
                "school_email" => $request->school_email,
                "school_contact" => $request->school_contact,
                "school_address" => $request->school_address,
                "school_moto" => $request->school_moto,
                "pid" => $request->pid ?? public_id(),
                'school_code' => $request->school_code,
            ];

            if(!$request->pid){
                $data['user_pid'] = getUserPid();
                $data['school_handle'] = $this->schoolHandle();
            }
            if ($request->school_logo) {
                $name = $data['school_name'] . '-logo';
                $data['school_logo'] = saveImg($request->file('school_logo'), name: $name, path: 'logo');
            }
            try {
               $result =  School::updateOrCreate(['pid'=> $request->pid],$data);
               if($result){
                    if(isset($request->pid)){
                        setSchoolName($result->school_name);
                        return response()->json(['status' => 1, 'message' => 'School Updated Successfully']);
                    }
                    // set school pid 
                    setSchoolPid($result->pid);
                   $data = [
                       'school_pid'=>$result->pid,
                       'user_pid'=>getUserPid(),
                       'role'=> 205,//school admin
                    ];
                    // $user=
                    self::createSchoolStaff($data);
                    setSchoolPid();
                    return response()->json(['status' => 1, 'message' => 'School Created Successfully','code'=> base64Encode($result->pid)]);
                    }
                } catch (\Throwable $e) {
                    logError($e->getMessage());
                    return response()->json(['status' => 'error', 'message' => 'Something Went Wrong... error logged']);
            }

        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    public function updateSetupStage(Request $request){
       try {
            $stage = $request->stage;
            if($stage==12){
                DB::table('schools')->where('pid', getSchoolPid())->update(['stage' => $stage, 'status'=>1]);
                session(['status' => 1]);
            }else{
                DB::table('schools')->where('pid', getSchoolPid())->update(['stage' => $stage]);
                session(['stage' => $stage+1]);
            }
            return response()->json(['status' => 1, 'message' => 'Stage Updated, loading next stage...']);
            
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json(['status' => 0, 'message' => 'failed']);
       }
    }
    
    public function previousSetupStage(Request $request){
       try {
            $stage = $request->stage;
            
            session(['stage' => $stage - 1]);
            
            return response()->json(['status' => 1, 'message' => 'Loading previous Stage...']);
            
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json(['status' => 0, 'message' => 'failed']);
       }
    }

    public static function createSchoolUser(string $userId, string $pid, string $role){//school user pid is the same as either staff pid, parent pid, student pid or rider pid
        $data = $dupParam = ['user_pid'=>$userId,'pid'=>$pid,'school_pid'=>getSchoolPid()];
        $data['role']= $role;
       return SchoolUser::updateOrCreate($dupParam,$data);
    }

    public static function createSchoolStaff($data){
        try {
            $data['pid'] = $data['pid'] ?? public_id();
            self::createSchoolUser(userId: $data['user_pid'], pid: $data['pid'], role: $data['role']);
            $data['school_pid'] = $data['school_pid'] ?? getSchoolPid();
            $dup = SchoolStaff::where(['school_pid' => $data['school_pid'], 'user_pid' => $data['user_pid']])->first();
            if ($dup) {
                $dup->fill($data);
                return $dup->save();
            }
            $data['staff_id'] = $data['staff_id'] ?? StaffController::staffUniqueId();
            return SchoolStaff::create($data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }


    public static function createSchoolStudent($data){
        try {
            self::createSchoolUser(userId: $data['user_pid'], pid: $data['pid'], role: '600');
            $dup = Student::where(['school_pid' => $data['school_pid'], 'user_pid' => $data['user_pid']])->first();
            if ($dup) {
                $dup->fill($data);
                return $dup->save();
            }
            return Student::create($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    
    public static function createSchoolParent($data){
        
        try {
            self::createSchoolUser(userId: $data['user_pid'], pid: $data['pid'], role: '605');
            $dupParams = [
                'school_pid' => $data['school_pid'],
                'pid' => $data['pid'],
            ];
            return SchoolParent::updateOrCreate($dupParams, $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }


    public static function createSchoolRider($data){
        try {
            self::createSchoolUser(userId: $data['user_pid'], pid: $data['pid'], role: '610');
            $dupParams = [
                'user_pid' => $data['user_pid'],
                'school_pid' => $data['school_pid'],
            ];
            return SchoolRider::updateOrCreate($dupParams, $data);
        } catch (\Throwable $e) {
            $error =  $e->getMessage();
            logError($error);
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

    public static function getSchoolCode()
    {
        return School::where(['pid' => getSchoolPid()])->pluck('school_code')->first();
    }

    public static function loadSchoolNotificationDetail($pid){
        try {
            $data = DB::table('schools')->where('pid', $pid)->first(['school_name', 'school_logo', 'school_address', 'school_contact']);
            return $data;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
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
    }

   
    public function findExistingUser($key){
        $key = str_replace('@__@', '/', trim($key));
       $user = DB::table('users as u')->leftJoin('user_details as d','u.pid','d.user_pid')
                                ->leftJoin('school_staff as s','u.pid','s.user_pid')
                                ->where('u.email',$key)
                                ->orWhere('u.gsm',$key)
                                ->orWhere('u.username',$key)
                                ->orWhere('s.staff_id',$key)
                                ->select(['fullname','dob','address','gender','religion','title','username','gsm','email','u.pid'])->first();
        // logError($user);
        return formatStaff($user);
    }
    
    // link staff 
    public function linkExistingUserToSchool(Request $request){
      
        $id = SchoolStaff::where([
            'user_pid' => $request->pid,
            'school_pid' => getSchoolPid()
        ])->pluck('staff_id')
        ->first();
        if ($id) {
            return 'staff already exist in ' . getSchoolName() . ' and the staff Id is ' . $id;
        }
        $data = [
            'user_pid' => $request->pid,
            'role' => $request->role
        ];
        $staff = self::createSchoolStaff($data);
        return 'Staff added to school and staff Id is '.$staff->staff_id;
    }

    // find student  
    public function findExistingStudent($key)
    {
        $key = str_replace('@__@','/',trim($key));
        $user = DB::table('users as u')->leftJoin('user_details as d', 'u.pid', 'd.user_pid')
        ->leftJoin('students as s', 'u.pid', 's.user_pid')
        ->where('u.email', $key)
            ->orWhere('u.gsm', $key)
            ->orWhere('u.username', $key)
            ->orWhere('s.reg_number', $key)
            ->select(['d.fullname', 'd.dob', 'd.address', 'd.gender', 'd.religion', 'reg_number', 'username', 'passport', 'email', 'u.pid'])->first();
        // logError($user);
        return formatStudent($user);
    }
    // link student 
    // link staff 
    public function linkExistingStudentToSchool(Request $request)  {
        $id = Student::where([
            'user_pid' => $request->pid,
            'school_pid' => getSchoolPid()
        ])->pluck('reg_number')
        ->first();
        if ($id) {
            return 'Student already exist in <b class="text-info">' . getSchoolName() . '</b> and the Reg is ' . $id;
        }
        $user = UserController::loadUserInfo($request->pid);
        if($user){
            $data = [
                'reg_number' => StudentController::studentUniqueId(),
                'gender' => $user->gender,
                'dob' => $user->dob,
                'religion' => $user->religion,
                'state' => $user->state,
                'lga' => $user->lga,
                'address' => $user->address,
                'type' => $request->type ?? getSchoolType(),
                'session_pid' => activeSession(),
                'term_pid' => activeTerm(),
                'admitted_term' => activeTerm(),
                'admitted_class' => $request->arm,
                'current_class_pid' => $request->arm,
                'current_session_pid' => activeSession(),
                'staff_pid' => getSchoolUserPid(),
                'school_pid'=>getSchoolPid(),
                'pid'=>public_id(),
            ];
            $student = self::createSchoolStudent($data);
            if($student){
                $studentClass = [
                    'session_pid' => $request->session_pid,
                    'arm_pid' => $request->arm,
                    'school_pid' => $student->pid,
                    'staff_pid' => getSchoolUserPid(),
                ];
                StudentController::createStudentClassRecord($studentClass);
            }
            
        }
        
        return 'Student added to school and Reg  is ' . $student->reg_number;
    }
    // find parent
    

    public function findExistingParent(Request $request)
    {
        $key = $request->key;
        $user = DB::table('users as u')->leftJoin('user_details as d', 'u.pid', 'd.user_pid')
        ->leftJoin('school_parents as p', 'u.pid', 'p.user_pid')
        ->where('u.email', $key)
            ->orWhere('u.gsm', $key)
            ->orWhere('u.username', $key)
            // ->orWhere('s.reg_number', $key)
            ->select(['d.fullname', 'd.dob', 'd.address', 'd.gender', 'd.religion', 'username', 'passport', 'email', 'u.pid','title'])->first();
        // logError($user);
        return formatParent($user);
    }
    // link student 
    // link staff 
    public function linkExistingParentToSchool(Request $request)  {

        $id = SchoolParent::where([
            'user_pid' => $request->pid,
            'school_pid' => getSchoolPid()
        ])->pluck('pid')
        ->first();
        if ($id) {
            return 'Parent already exist in <b class="text-info">' . getSchoolName() . '</b> ';
        }
        $data =['school_pid' => getSchoolPid(), 'user_pid' => $request->pid,'pid'=>public_id()];
        $std = self::createSchoolParent($data);
        if($std){
            return 'Parent added to School';
        }
        return 'Failed to link parent to School';
    }

    // load existing rider 
    public function findExistingRider($key)
    {
        $key = str_replace('@__@','/',trim($key));
        $user = DB::table('users as u')->leftJoin('user_details as d', 'u.pid', 'd.user_pid')
        ->leftJoin('school_riders as r', 'u.pid', 'r.user_pid')
        ->where('u.email', $key)
            ->orWhere('u.gsm', $key)
            ->orWhere('u.username', $key)
            ->orWhere('r.rider_id', $key)
            ->select(['d.fullname', 'd.dob', 'd.address', 'd.gender', 'd.religion', 'username', 'passport', 'email', 'u.pid','title','rider_id'])->first();
        // logError($user);
        return formatRider($user);
    }
    // link rider 
    public function linkExistingRiderToSchool(Request $request)  {
        $id = SchoolRider::where([
            'user_pid' => $request->pid,
            'school_pid' => getSchoolPid()
        ])->pluck('rider_id')
        ->first();
        if ($id) {
            return 'Rider already exist in <b class="text-info">' . getSchoolName() . '</b> & unique id <b class="text-danger">'.$id.'</b>';
        }
        $data = [
            'school_pid' => getSchoolPid(),
            'user_pid' => $request->pid,
            'pid' => public_id(),
            'rider_id' => RiderController::riderUniqueId(),
        ];
      
        $sts = self::createSchoolRider($data);
        if($sts){
            return 'Rider added to School, unique Id is '.$sts->rider_id;
        }
        return 'Failed to link parent to School';
    }

    // statistics for graph 
    private function studentStatistics()
    {
        $sts = DB::table('students as s')->join('user_details as d', 'd.user_pid', 's.user_pid')
        ->join('class_arms as a', 'a.pid', 's.current_class_pid')
        ->join('classes as c', 'c.pid', 'a.class_pid')
        ->select(DB::raw('COUNT(s.id) AS count,c.class,d.gender'))
        ->where(['s.school_pid' => getSchoolPid()])->whereIn('s.status', [1, 4])->groupBy(['c.class', 'd.gender'])->get();
        return $sts;
    }
    private function growthStatistics()
    {
        $sts = DB::table('students as s')
        ->select(DB::raw('COUNT(s.id) AS count,YEAR(created_at) AS year'))
        ->where(['school_pid' => getSchoolPid()])->groupBy(DB::raw('YEAR(created_at)'))->orderBy('created_at')->get();
        return $sts;
    }

    // form master 
    private function staffClasses(){

    }
    private function staffSubjects(){

    }

    // parent 


    // student 

    // rider 
}

   