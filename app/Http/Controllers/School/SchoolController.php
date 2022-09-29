<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use App\Models\School\School;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\Rider\SchoolRider;
use App\Models\School\Staff\SchoolStaff;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Users\UserController;
use App\Models\School\Registration\SchoolParent;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Parent\ParentController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\School\Rider\SchoolRiderController;

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
                        ->where(['school_pid'=>$id, 'school_staff.user_pid'=>getUserPid()])
                        ->first(['school_staff.pid', 'school_name', 'school_logo', 'type','role','school_staff.status']);
        if($schoolUser && $schoolUser->status !=1){
            return redirect()->back()->with('warning','you Have been denied access, contact the school.');
        }
        if(!$schoolUser){
            return redirect()->back()->with('error','you are doing it wrong');
        }
        setSchoolPid($id);
        setSchoolType($schoolUser->type);
        setSchoolUserPid($schoolUser->pid);
        setSchoolName($schoolUser->school_name);
        setSchoolLogo($schoolUser->school_logo);
        setDefaultLanding(true);
        setUserActiveRole($schoolUser->role);
        // dd(getUserActiveRole());
        // check user role and redirect to a corresponding dashboard
        return redirect()->route('my.school.dashboard');
    }
    public function mySchoolDashboard(){
       
        // $data = School::where('pid', getSchoolPid())->get()->dd();
        $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $students = Student::where(['school_pid'=>getSchoolPid(),'status'=>1])->count();
        $riders = SchoolRider::where(['school_pid' => getSchoolPid(), 'status' => 1])->count();
        $parents = DB::table('school_parents as p')
                        ->join('students as s','s.parent_pid','p.pid')
                        ->where(['p.school_pid' => getSchoolPid(), 's.status' => 1])->count('p.id');
        $data = ['staff'=>$staff, 'students'=> $students, 'riders'=> $riders, 'parents'=> $parents];
        return view('school.dashboard.admin-dashboard', compact('data'));
    }
    public function createSchool(Request $request){
        $validator = Validator::make($request->all(),[
            "state" => "required",
            "type" => "required",
            "lga" => "required",
            "school_email" => "nullable|email",
            "school_name" => "required|unique:schools",
            "school_contact" => "required",
            "school_address" => "required|string",
            "school_moto" => "required",
            "school_handle" => "nullable|unique:schools",
            "school_logo" => "nullable|image|mimes:jpeg,png,jpg,gif",
        ]);

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
                "pid" => public_id(),
                "user_pid" => getUserPid(),
                'school_handle' => $this->schoolHandle(),
                'school_code' => $request->school_handle,
            ];

            if ($request->school_logo) {
                $name = $data['school_name'] . '-logo';
                $data['school_logo'] = saveImg($request->file('school_logo'), name: $name, path: 'logo');
            }
            try {
               $result =  School::create($data);
               if($result){
                    // set school pid 
                    setSchoolPid($result->pid);
                   $data = [
                       'school_pid'=>$result->pid,
                       'user_pid'=>getUserPid(),
                       'role'=> 205,//school admin
                    ];
                    // $user=
                    StaffController::registerStaffToSchool($data);
                    setSchoolPid();
                    // if($user){
                    //     return response()->json(['status' => 1, 'message' => 'School Created Successfully']);
                    // }
                    return response()->json(['status' => 1, 'message' => 'School Created Successfully']);
                    }
                } catch (\Throwable $e) {
                    $error = $e->getMessage();
                    logError($error);
                    return response()->json(['status' => 'error', 'message' => 'Something Went Wrong... error logged']);
            }

        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
       
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
        $staff = StaffController::registerStaffToSchool($data);
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
                'admitted_class' => $request->arm,
                'current_class' => $request->arm,
                'current_session_pid' => activeSession(),
                'staff_pid' => getSchoolUserPid(),
                'school_pid'=>getSchoolPid(),
                'pid'=>public_id(),
            ];
            $student = StudentController::createSchoolStudent($data);
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
    

    public function findExistingParent($key)
    {
        $key = str_replace('@__@','/',trim($key));
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
        $std = ParentController::createSchoolParent($data);
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
            'rider_id' => SchoolRiderController::riderUniqueId(),
        ];
        $std = SchoolRiderController::createSchoolRider($data);
        if($std){
            return 'Rider added to School, unique Id is '.$std->rider_id;
        }
        return 'Failed to link parent to School';
    }

    
}

   