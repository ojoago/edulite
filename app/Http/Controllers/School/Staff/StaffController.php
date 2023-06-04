<?php

namespace App\Http\Controllers\School\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\StaffClass;
use App\Models\School\Staff\SchoolStaff;
use App\Models\School\Staff\StaffSubject;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Framework\Events\SchoolNotificationController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Models\School\School;
use App\Models\School\Staff\StaffAccess;
use App\Models\School\Staff\StaffRoleHistory;
use App\Models\SchoolUser;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    private $pwd = 1234567;
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $cnd = ['school_staff.school_pid'=>getSchoolPid()];
        $data = SchoolStaff::join('users','users.pid','school_staff.user_pid')
                    ->join('user_details','users.pid','user_details.user_pid')
                    ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status'=>1])
                    ->get([
                        'gsm','username','email','staff_id','fullname','school_staff.status',
                        'role','school_staff.pid', 'school_staff.created_at'
                    ]);
        return $this->useDataTable($data);
    }
    public function inActiveStaff()
    {
        // $cnd = ['school_staff.school_pid'=>getSchoolPid()];
        $data = SchoolStaff::join('users','users.pid','school_staff.user_pid')
                    ->join('user_details','users.pid','user_details.user_pid')
                    ->where(['school_staff.school_pid' => getSchoolPid()])
                    ->where('school_staff.status','<>',1)
                    ->get([
                        'gsm','username','email','staff_id','fullname',
                        'role','school_staff.pid', 'school_staff.created_at'
                    ]);
        return $this->useDataTable($data);
    }
    private function useDataTable($data){
        return datatables($data)
        ->addColumn('action', function ($data) {
            return view('school.lists.staff.action-buttons', ['data' => $data]);
        })->editColumn('created_at', function ($data) {
            return $data->created_at->diffForHumans();
        })
        ->addIndexColumn()
        ->editColumn('role', function ($data) {
            return matchStaffRole($data->role);
        })
        ->make(true);
    }
    public function staffProfile($pid)
    {
        return view('school.lists.staff.staff-profile',compact('pid'));
    }
    
    public function loadStaffProfile(Request $request){
        // $data = DB::table('users as u')->leftjoin('user_details as d','d.user_pid','u.pid')
        //                 ->join('school_staff as s','s.user_pid','u.pid')
        //                 ->where(['s.school_pid'=>getSchoolPid(),'s.pid'=>base64Decode($request->pid)])
        //                 ->select('gsm','email','username','fullname','address','title','dob','gender','religion','lga','state','role', 'passport','signature','stamp','staff_id')->first();
        $data = DB::table('users as u')->join('user_details as d', 'd.user_pid', 'u.pid')
            ->join('school_staff as s', 's.user_pid', 'u.pid')
            ->where(['school_pid' => getSchoolPid(), 's.pid' => base64Decode($request->pid)])
            ->select('gsm', 'email', 'username', 'fullname', 'address', 'title', 'dob', 'gender', 'religion', 'lga', 'state', 'role', 'passport', 'signature', 'stamp', 'staff_id')->first();
        return response()->json(formatStaffProfile($data));
    }

    public function loadStaffClasses(Request $request){
       
        if(isset($request->session) && isset($request->term)){
            $data = DB::table('staff_classes as c')->join('class_arms as a', 'a.pid', 'c.arm_pid')
                ->join('terms as t', 't.pid', 'c.term_pid')
                ->join('sessions as s', 's.pid', 'session_pid')
                ->select('term', 'session', 'arm', 'c.updated_at')
                ->where([
                    'c.school_pid' => getSchoolPid(), 
                    'c.teacher_pid' => base64Decode($request->pid),
                    'c.term_pid'=>$request->term,
                    'c.session_pid'=>$request->session,
                    ])
                ->orderBy('arm')->get();
        }elseif(isset($request->session) || isset($request->term)){
            $data = DB::table('staff_classes as c')->join('class_arms as a', 'a.pid', 'c.arm_pid')
                ->join('terms as t', 't.pid', 'c.term_pid')
                ->join('sessions as s', 's.pid', 'session_pid')
                ->select('term', 'session', 'arm', 'c.updated_at')
                ->where(['c.school_pid' => getSchoolPid(), 'c.teacher_pid' => base64Decode($request->pid),'term_pid'=>$request->term])
                ->orWhere(['c.school_pid' => getSchoolPid(), 'c.teacher_pid' => base64Decode($request->pid),'session_pid'=>$request->session])
                ->orderBy('arm')->get();
        }else{
            $data = DB::table('staff_classes as c')->join('class_arms as a', 'a.pid', 'c.arm_pid')
                ->join('terms as t', 't.pid', 'c.term_pid')
                ->join('sessions as s', 's.pid', 'session_pid')
                ->select('term', 'session', 'arm', 'c.updated_at')
                ->where([
                    'c.school_pid' => getSchoolPid(), 'c.teacher_pid' => base64Decode($request->pid),
                    'c.term_pid' => activeTerm(),
                    'c.session_pid' => activeSession(),
                    ])
                ->orderBy('arm')->get();
        }
        return datatables($data)
                ->editColumn('date', function ($data) {
                    return date('d F Y',strtotime($data->updated_at));
                })
                ->addIndexColumn()
                ->make(true);
        
    }
    public function loadStaffSubject(Request $request){
        $data = DB::table('staff_subjects as sb')->join('class_arm_subjects as as','as.pid', 'sb.arm_subject_pid')
                        ->join('subjects as j','j.pid', 'as.subject_pid')
                        ->join('class_arms as a','a.pid', 'as.arm_pid')
                        ->join('terms as t','t.pid', 'sb.term_pid')
                        ->join('sessions as s','s.pid','sb.session_pid')
                        ->select('term','session','j.subject','sb.updated_at','a.arm')
                        ->where(['sb.school_pid'=>getSchoolPid(),'sb.staff_pid'=>base64Decode($request->pid)])
                        ->orderBy('arm')->get();
        return datatables($data)
            ->editColumn('date', function ($data) {
                return date('d F Y', strtotime($data->updated_at));
            })
            ->editColumn('staff_subject', function ($data) {
                return $data->arm.' '.$data->subject;
            })
            ->addIndexColumn()
            ->make(true);
    }

    // all staff classs 
    public function loadAllStaffClasses(Request $request){
        if (isset($request->session) && isset($request->term)) {
            $data = DB::table('staff_classes as c')->join('class_arms as a', 'a.pid', 'c.arm_pid')
                ->join('terms as t', 't.pid', 'c.term_pid')
                ->join('sessions as s', 's.pid', 'session_pid')
                ->join('school_staff as st', 'st.pid', 'teacher_pid')
                ->join('user_details as d', 'd.user_pid', 'st.user_pid')
                ->select('term', 'session', 'arm', 'c.updated_at', 'fullname')
                ->where([
                    'c.school_pid' => getSchoolPid(),
                    'c.term_pid' => $request->term,
                    'c.session_pid' => $request->session,
                ])
                ->orderBy('arm')->get();
        } elseif (isset($request->session) || isset($request->term)) {
            $data = DB::table('staff_classes as c')->join('class_arms as a', 'a.pid', 'c.arm_pid')
                ->join('terms as t', 't.pid', 'c.term_pid')
                ->join('sessions as s', 's.pid', 'session_pid')
                ->join('school_staff as st', 'st.pid', 'teacher_pid')
                ->join('user_details as d', 'd.user_pid', 'st.user_pid')
                ->select('term', 'session', 'arm', 'c.updated_at', 'fullname')
                ->where(['c.school_pid' => getSchoolPid(), 'term_pid' => $request->term])
                ->orWhere(['c.school_pid' => getSchoolPid(), 'session_pid' => $request->session])
                ->orderBy('arm')->get();
        } else {
            $data = DB::table('staff_classes as c')->join('class_arms as a', 'a.pid', 'c.arm_pid')
                ->join('terms as t', 't.pid', 'c.term_pid')
                ->join('sessions as s', 's.pid', 'session_pid')
                ->join('school_staff as st', 'st.pid', 'teacher_pid')
                ->join('user_details as d', 'd.user_pid', 'st.user_pid')
                ->select('term', 'session', 'arm', 'c.updated_at','fullname')
                ->where(['c.school_pid' => getSchoolPid()])
                ->orderBy('arm')->get();
        }
        return datatables($data)
            ->editColumn('date', function ($data) {
                return date('d F Y', strtotime($data->updated_at));
            })
            ->addIndexColumn()
            ->make(true);
    }

    // all staff subjects 
    public function loadAllStaffSubjects(Request $request)
    {   
        if(isset($request->session) && isset($request->term)){
            $data = DB::table('staff_subjects as sb')->join('class_arm_subjects as as', 'as.pid', 'sb.arm_subject_pid')
                ->join('subjects as j', 'j.pid', 'as.subject_pid')
                ->join('class_arms as a', 'a.pid', 'as.arm_pid')
                ->join('terms as t', 't.pid', 'sb.term_pid')
                ->join('sessions as s', 's.pid', 'sb.session_pid')
                ->join('school_staff as st', 'st.pid', 'sb.staff_pid')
                ->join('user_details as d', 'd.user_pid', 'st.user_pid')
                ->select('term', 'session', 'j.subject', 'sb.updated_at', 'a.arm', 'fullname')
                ->where(['sb.school_pid' => getSchoolPid(),
                        'sb.term_pid'=>$request->term,
                        'sb.session_pid'=>$request->session
                        ])
                ->orderBy('arm')->get();
        }elseif(isset($request->session) || isset($request->term)){
            $data = DB::table('staff_subjects as sb')->join('class_arm_subjects as as', 'as.pid', 'sb.arm_subject_pid')
                ->join('subjects as j', 'j.pid', 'as.subject_pid')
                ->join('class_arms as a', 'a.pid', 'as.arm_pid')
                ->join('terms as t', 't.pid', 'sb.term_pid')
                ->join('sessions as s', 's.pid', 'sb.session_pid')
                ->join('school_staff as st', 'st.pid', 'sb.staff_pid')
                ->join('user_details as d', 'd.user_pid', 'st.user_pid')
                ->select('term', 'session', 'j.subject', 'sb.updated_at', 'a.arm', 'fullname')
                ->where(['sb.school_pid' => getSchoolPid(), 'sb.term_pid' => $request->term])
                ->orWhere(['sb.school_pid' => getSchoolPid(), 'sb.term_pid' => $request->session])
                ->orderBy('arm')->get();
        }else{
            $data = DB::table('staff_subjects as sb')->join('class_arm_subjects as as', 'as.pid', 'sb.arm_subject_pid')
                    ->join('subjects as j', 'j.pid', 'as.subject_pid')
                    ->join('class_arms as a', 'a.pid', 'as.arm_pid')
                    ->join('terms as t', 't.pid', 'sb.term_pid')
                    ->join('sessions as s', 's.pid', 'sb.session_pid')
                    ->join('school_staff as st', 'st.pid', 'sb.staff_pid')
                    ->join('user_details as d', 'd.user_pid', 'st.user_pid')
                    ->select('term', 'session', 'j.subject', 'sb.updated_at', 'a.arm', 'fullname')
                    ->where(['sb.school_pid' => getSchoolPid()])
            ->orderBy('arm')->get();
        }
        
        return datatables($data)
            ->editColumn('date',
                function ($data) {
                    return date('d F Y', strtotime($data->updated_at));
                }
            )
            ->editColumn('staff_subject', function ($data) {
                return $data->arm . ' ' . $data->subject;
            })
            ->addIndexColumn()
            ->make(true);
    }

    // create staff account 
    public function createStaff(Request $request){
        $validator = Validator::make($request->all(),[
            'firstname'=>'required|string|min:3|max:25',
            'lastname'=> 'required|string|min:3|max:25',
            'gsm'=> ['required','digits:11', 
                                Rule::unique('users')->where(function ($param) use ($request) {
                                    $param->where('pid', '!=', $request->pid);
                                })],
            'username'=> ['nullable',
                                    Rule::unique('users')->where(function($param)use($request){
                                        $param->where('pid','!=',$request->pid);
                                    })],
            'email'=> ['nullable','email',
                                Rule::unique('users')->where(function ($param) use ($request) {
                                    $param->where('pid', '!=', $request->pid);
                                })],
            'gender'=>'required',
            'dob'=> 'required|date|before:'. confrimYear(),
            'role'=>'required',
            'address'=>'required|string',
            'passport'=> 'nullable|image|mimes:jpeg,png,jpg,gif',
            'signature'=>'nullable|image|mimes:jpeg,png,jpg,gif',
            'stamp'=>'nullable|image|mimes:jpeg,png,jpg,gif',
        ],['gsm.required'=>'Enter Phone Number','dob.required'=>'Enter staff date of birth','dob.before'=>'Staff must 18 years & above']);
        
        if(!$validator->fails()){
            try {
                $data = [
                    'gsm' => $request->gsm,
                    // 'email' => !empty($request->email) ? $request->email : null,
                    'account_status' => 1,
                    'password' => $this->pwd,
                    'username' => $request->username ?? AuthController::uniqueUsername($request->firstname),
                    'pid' => $request->pid
                ];
                if ($request->email) {
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
                    'title' => $request->title,
                    'pid' => $request->pid
                ];
                
                $user = AuthController::createUser($data);
                if ($user) {
                    $detail['user_pid'] = $data['pid'] ?? $user->pid;
                    $userDetails = UserDetailsController::insertUserDetails($detail);
                    if ($userDetails) {
                        $staff = ['role' => $request->role, 'user_pid' => $data['pid'] ?? $user->pid,];
                        if (!$request->staff_id) {//skip generating id when updating
                            $staff['staff_id'] = self::staffUniqueId();
                        }
                        if ($request->passport) {
                            $name = ($staff['staff_id'] ?? $request->staff_id) . '-passport';
                            $staff['passport'] = saveImg($request->file('passport'), name: $name);
                        }
                        if ($request->signature) {
                            $name = ($staff['staff_id'] ?? $request->staff_id) . '-signature';
                            $staff['signature'] = saveImg($request->file('signature'), name: $name);
                        }
                        if ($request->stamp) {
                            $name = ($staff['staff_id'] ?? $request->staff_id) . '-stamp';
                            $staff['stamp'] = saveImg($request->file('stamp'), name: $name);
                        }
                        $result = SchoolController::createSchoolStaff($staff);
                        if ($result) {

                            $this->staffRoleHistory(role: $request->role, pid: $result->pid ?? $request->pid);
                            if($request->pid){
                                return response()->json(['status' => 1, 'message' => 'Staff Detail updated  Successfully & username is ' . $data['username']]);
                            }
                            $message = 'Your account has been created, Staff Id: ' . $staff['staff_id']  . ' & username is ' . $data['username'].' and Password: '.$this->pwd;
                            $message .= ' Your primary Role is ' .matchStaffRole($request->role);

                            SchoolNotificationController::notifyIndividualStaff(message: $message, pid: $result->pid ?? $request->pid);

                            return response()->json(['status' => 1, 'message' => 'Staff Registration Successful, Staff Id ' . $staff['staff_id']  . ' & username is ' . $data['username']]);
                        }

                        return response()->json(['status' => 1, 'message' => 'user account created, but not linked to school!! use ' . $data['gsm'] . ' or ' . $data['username'] . ' to link to school']);
                    }
                }

                return response()->json(['status' => 'error', 'message' => 'user account not created']);

            } catch (\Throwable $e) {
                $error =  $e->getMessage();
                logError($error);
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong... error logged']);
            }
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    public function updateStaffImages(Request $request){
        $validator = Validator::make($request->all(),[
            'passport'=> 'required_without_all:signature,stamp|image|mimes:jpeg,png,jpg,gif',
            'signature'=> 'required_without_all:passport,stamp|image|mimes:jpeg,png,jpg,gif',
            'stamp'=> 'required_without_all:signature,passport|image|mimes:jpeg,png,jpg,gif',
            'pid'=> 'required',
        ],['pid.required'=>'please do the right thing']);
        if(!$validator->fails()){
            try {
                $staff = SchoolStaff::where(['pid'=>$request->pid,'school_pid'=>getSchoolPid()])->first();
                if ($request->passport) {
                    $name = $staff['staff_id'] . '-passport';
                    $staff['passport'] = saveImg($request->file('passport'), name: $name);
                }
                if ($request->signature) {
                    $name = $staff['staff_id'] . '-signature';
                    $staff['signature'] = saveImg($request->file('signature'), name: $name);
                }
                if ($request->stamp) {
                    $name = $staff['staff_id'] . '-stamp';
                    $staff['stamp'] = saveImg($request->file('stamp'), name: $name);
                }
                $sts = $staff->save();
                if($sts){

                    return response()->json(['status'=>1,'message'=>'Update successfull!!!']);
                }
                return response()->json(['status'=>'error','message'=>'Something Went Wrong']);
            } catch (\Throwable $e) {
                $error =  $e->getMessage();
                logError($error);
            }
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }
    public function find($pid){
        return view('school.registration.staff.register-staff',compact('pid'));
    }
    // load staff details on for editing 
    public function loadStaffDetailsById(Request $request){
        $data = DB::table('school_staff as t')->join('users as u','u.pid','t.user_pid')
                    ->leftJoin('user_details as d','d.user_pid','t.user_pid')
                    ->select('t.user_pid', 't.pid as t_pid', 'role', 'u.email','u.username', 'u.gsm', 'u.pid as u_pid','d.*','staff_id')
                    ->where(['t.pid'=>base64Decode($request->pid),'t.school_pid'=>getSchoolPid()])->first();
        return response()->json($data);
    }


    public static function staffUniqueId(){
        $id = sprintNumber(self::countStaff() + 1);
        // $id =strlen($id) == 1 ? '0'.$id : $id;
        return  (SchoolController::getSchoolCode() ?? SchoolController::getSchoolHandle()) .'/'.strtoupper(date('yM')).$id;
    }
    
    public static function countStaff(){
       return SchoolStaff::where(['school_pid'=>getSchoolPid()])->where('staff_id','like','%'.date('yM').'%')->count('id');
    }
    
    public function updateStaffStatus($pid){
        try {
            $staff = SchoolStaff::where(['school_pid' => getSchoolPid(),'pid' => base64Decode($pid)])->first(['id','status']);
            if ($staff) {
                $staff->status = $staff->status == 1 ? 0 : 1;
                // send notification mail 
                $staff->save();
                return 'staff Account updated';
            }
            return 'Something Went Wrong';
        } catch (\Throwable $e) {
            $error =  $e->getMessage();
            logError($error);
        }
    }
   

    public function updateStaffRole(Request $request){
        $validator = Validator::make($request->all(),[
            'role'=>'required',
            'pid'=>'required',
        ]);
        if(!$validator->fails()){
            try {
                $where = ['school_pid' => getSchoolPid(), 'pid' => $request->pid];
                $staff = SchoolStaff::where($where)->first();
                $staffLoginTable = SchoolUser::where($where)->first();
                $staffLoginTable['role'] = $staff['role'] = $request->role;
                $staffLoginTable->save();
                $sts = $staff->save();
                if($sts){
                    // log staff role update 
                    $this->staffRoleHistory(role: $request->role,pid: $request->pid);
                    if($request->role==200){
                        $school = School::where('pid',getSchoolPid())->first();
                        $school['user_pid'] = $staff->user_pid;
                        $sts = $school->save();
                    }
                    return response()->json(['status'=>1,'message'=>'staff role updated!!!']);
                }
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                logError($error);
            }
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        
    }
    private function staffRoleHistory($role,$pid){
        $roleHistry = [
            'school_pid' => getSchoolPid(),
            'term_pid' => activeTerm(),
            'session_pid' => activeSession(),
            'role' => $role,
            'staff_pid' => $pid,
            'creator' => getSchoolUserPid()
        ];
       $sts =  StaffRoleHistory::create($roleHistry);
       if($sts){
            $message ='You have been assigned '. matchStaffRole($role).' Role';
            SchoolNotificationController::notifyIndividualStaff(message: $message, pid: $pid);
       }
       return $sts;
    }
    public function staffAccessRight(Request $request){
       
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
            'access' => 'required',
        ], [
            'pid.required' => 'Logout login again...',
            'access.required' => 'Tick on role at least',
        ]);
        if (!$validator->fails()) {
            try {
                $data = [
                    'school_pid' => getSchoolPid(),
                    'access' => json_encode($request->access),
                    'staff_pid' => $request->pid,
                ];
                // logError($data);
                $msg = 'The following class has been assigned to you<br>';
                // if (count($request->arm_pid) == 1) {
                //     $msg = '';
                // }
                // $n = 0;
                // foreach ($request->arm_pid as $row) {
                //     $msg .= ++$n . ' ' . ClassController::getClassArmNameByPid($row) . '<br>';
                //     $dupParams['arm_pid'] = $data['arm_pid'] = $row;
                // }
                $result = StaffAccess::updateOrCreate(['staff_pid'=>$request->pid,'school_pid'=>$data['school_pid']], $data);
                if ($result) {
                    // $message = $msg;
                    // SchoolNotificationController::notifyIndividualStaff(message: $message, pid: $request->pid);
                    return response()->json(['status' => 1, 'message' => "Staff Access updated"]);
                }
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                logError($error);
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong.. error logged']);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
       
    }
    // public function staffAccessRight($pid){
    //     $staff = SchoolStaff::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->first(['id', 'status']);
    //     try {
    //         if ($staff) {
    //             $staff->status = 0;
    //             // send notification mail 
    //             $staff->save();
    //             return 'staff Account updated';
    //         }
    //         return 'Wrong Id provided, make sure your session is still active';
    //     } catch (\Throwable $e) {
    //         $error = $e->getMessage();
    //         logError($error);
    //     }
    // }


    public function assignClassToStaff(Request $request){
        $validator = Validator::make($request->all(),[
            'arm_pid'=>'required',
            'term_pid'=>'required',
            'session_pid'=>'required',
            'teacher_pid'=>'required',
            'category_pid'=>'required',
            'class_pid'=>'required',           
            ],[
                'arm_pid.required'=>'Select at least one class Arm from the list',
                'term_pid.required'=>'Select Term from the list',
                'session_pid.required'=>'Select Session from the list',
                'teacher_pid.required'=>'Select Staff',
                'class_pid.required'=>'Class is Required',
                'category_pid.required'=> 'Category is Required',
            ]);
            if(!$validator->fails()){
                try {
                    $dupParams =   $data = [
                        'school_pid'=>getSchoolPid(),
                        'term_pid'=>$request->term_pid,
                        'session_pid'=>$request->session_pid,
                    ];
                    $data['teacher_pid']=$request->teacher_pid;
                        // 'arm_pid'=>'',
                    $msg = 'The following class has been assigned to you<br>';
                    if(count($request->arm_pid)==1){
                        $msg = '';
                    }
                    $n=0;
                    foreach($request->arm_pid as $row){
                        $msg .=++$n.' '. ClassController::getClassArmNameByPid($row).'<br>';
                        $dupParams['arm_pid'] = $data['arm_pid'] = $row;
                        $result = StaffClass::updateOrCreate($dupParams,$data);
                    }
                    if ($result) {
                        $message = $msg;
                        SchoolNotificationController::notifyIndividualStaff(message:$message,pid: $request->teacher_pid);
                        return response()->json(['status'=>1,'message'=> count($request->arm_pid)." Class(es) Assigned to Staff"]);
                    }
                    return response()->json(['status'=>'error','message'=> 'Something Went Wrong']);
                } catch (\Throwable $e) {
                    $error = $e->getMessage();
                    logError($error);
                   return response()->json(['status'=>'error','message'=> 'Something Went Wrong.. error logged']);
                }   
            }
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        
    }
    public function StaffSubject(Request $request){
            $validator = Validator::make($request->all(),[
            'category_pid'=>'required',
            'class_pid'=> 'required',
            // 'arm_pid'=> 'required',
            'session_pid'=> 'required',
            'term_pid'=> 'required',
            'teacher_pid'=> 'required',
            'subject_pid'=> 'required',
        ],[
            'category_pid.required'=>'Select Category to get the corresponding classes',
            'class_pid.required'=>'Select Class to get the corresponding Arms',
            // 'arm_pid.required'=>'Select class Arm to get the corresponding Subjects',
            'term_pid.required'=>'Select Term',
            'session_pid.required'=>'Select Session',
            'teacher_pid.required'=>'Select Teacher',
            'subject_pid.required'=>'Select at least 1 Subject',
        ]);

        if(!$validator->fails()){
            $data = [
                'school_pid'=>getSchoolPid(),
                'term_pid'=> $request->term_pid,
                'session_pid'=> $request->session_pid,
                'teacher_pid'=> $request->teacher_pid,
                'subject_pid'=> $request->subject_pid,
                'staff_pid'=> getSchoolUserPid(),
            ];
            // logError($request->arm_pid);
            // foreach($request->arm_pid as $row){
            //     $data['arm_pid'] = $row;
            // }
            $result= $this->assignClassArmSubjectToTeacher($data);
            if($result){
                return response()->json(['status'=>1,'message'=>'Selected Subject (s) assigned to staff!!!']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong from the Back!']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        
    }
    
    private function assignClassArmSubjectToTeacher(array $data){
        $dupParams = [
            'term_pid'=>$data['term_pid'],
            'session_pid'=>$data['session_pid']
        ];
        try {
            foreach ($data['subject_pid'] as $row) {
                $data['pid'] = public_id();
                $dupParams['arm_subject_pid'] = $data['arm_subject_pid'] = $row;
                StaffSubject::updateOrCreate($dupParams, $data);
            }
            return true;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            return false;
        }
    }

    public static function getSubjectTeacherPid(string $session, string $term,string $subject){
        $teacher = StaffSubject::where([
            'school_pid'=>getSchoolPid(),
            'session_pid'=>$session,
            'term_pid'=>$term,
            'arm_subject_pid'=>$subject
            ])->pluck('teacher_pid')->first();
        return $teacher;
    }

    public static function getStaffDetailBypId(string $pid)
    {
        $data = SchoolStaff::join('users', 'users.pid', 'school_staff.user_pid')
        ->join('user_details', 'users.pid', 'user_details.user_pid')
        ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.pid'=>$pid])
            ->first(['gsm', 'title', 'email','fullname']);
        return $data;
    }
}
