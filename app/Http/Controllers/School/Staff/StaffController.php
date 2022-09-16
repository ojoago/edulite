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
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;

class StaffController extends Controller
{
    private $pwd = 1234567;
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
        // $cnd = ['school_staff.school_pid'=>getSchoolPid()];
        $data = SchoolStaff::join('users','users.pid','school_staff.user_pid')
                    ->join('user_details','users.pid','user_details.user_pid')
                    ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status'=>1])
                    ->get([
                        'gsm','username','email','staff_id','fullname',
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
                        'role_id','school_staff.pid', 'school_staff.created_at'
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
        $data = DB::table('users as u')->join('user_details as d','d.user_pid','u.pid')
                        ->join('school_staff as s','s.user_pid','u.pid')
                        ->where(['school_pid'=>getSchoolPid(),'s.pid'=>base64Decode($request->pid)])
                        ->select('gsm','email','username','fullname','address','title','dob','gender','religion','lga','state','role', 'passport','signature','stamp')->first();
        echo formatStaffProfile($data);
    }

    public function loadStaffClass(Request $request){
        $data = DB::table('staff_classes as c')->join('arms as a','a.pid','c.arm_pid')
                        ->join('terms as t','t.pid','c.term_pid')
                        ->join('sessions as s','s.pid','session_pid')
                        ->select('term','session','arm','c.created_at')
                        ->where(['school_pid'=>getSchoolPid(),'staff_pid'=>$request->pid])->orderBy('arm')->get();
        
    }
    public function loadStaffSubject(Request $request){
        $data = DB::table('staff_subjects as sb')->join('subjects as s','s.pid', 'sb.subject_pid')
                        ->join('terms as t','t.pid', 'sb.term_pid')
                        ->join('sessions as s','s.pid','session_pid')
                        ->select('term','session','subject','c.created_at')
                        ->where(['school_pid'=>getSchoolPid(),'staff_pid'=>$request->pid])->orderBy('arm')->get();
        
    }

    public function createStaff(Request $request){
        $validator = Validator::make($request->all(),[
            'firstname'=>'required|string|min:3|max:25',
            'lastname'=> 'required|string|min:3|max:25',
            'gsm'=> 'required|min:11|max:11|unique:users,gsm',
            'username'=> 'nullable|unique:users,username',
            'email'=> 'nullable|email|unique:users,email',
            'gender'=>'required',
            'dob'=>'required|date',
            'role'=>'required',
            'address'=>'required|string',
            'passport'=> 'nullable|image|mimes:jpeg,png,jpg,gif',
            'signature'=>'nullable|image|mimes:jpeg,png,jpg,gif',
            'stamp'=>'nullable|image|mimes:jpeg,png,jpg,gif',
        ],['gsm.required'=>'Enter Phone Number','dob.required'=>'Enter staff date of birth']);
        
        if(!$validator->fails()){
            $data = [
                'gsm' => $request->gsm,
                'email'=> $request->email,
                'account_status' =>1,
                'password'=>$this->pwd,
                'username'=> $request->username ?? AuthController::uniqueUsername($request->firstname)
            ];
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
            ];
            $user = AuthController::createUser($data);
            if($user){
                $detail['user_pid'] = $user->pid;
                $userDetails = UserDetailsController::insertUserDetails($detail);
                if($userDetails){
                    $staff = ['role' => $request->role, 'user_pid' => $user->pid, 'staff_id' =>    self::staffUniqueId()];
                    if($request->passport){
                        $name = $staff['staff_id'] . '-passport';
                        $staff['passport'] = saveImg($request->file('passport'),name:$name);
                    }
                    if($request->signature){
                        $name = $staff['staff_id'] . '-signature';
                        $staff['signature'] = saveImg($request->file('signature'),name:$name);
                    }
                    if($request->stamp){
                        $name = $staff['staff_id'] . '-stamp';
                        $staff['stamp'] = saveImg($request->file('stamp'),name:$name);
                    }
                   $result = self::registerStaffToSchool($staff);
                   if($result){

                        return response()->json(['status' => 1, 'message' => 'Staff Registration Successfull, Staff Id '.$result->staff_id.' & username is '.$data['username']]);

                    }

                    return response()->json(['status' => 1, 'message' => 'user account created, but not linked to school!! use '.$data['gsm'].' or '.$data['username'].' to link to school']);
                
                }
            }

            return response()->json(['status' => 1, 'message' => 'user account not completed, and not linked to school!! use '.$data['gsm']. ' or ' . $data['username'] . ' to link to school, while the use link to update details']);

        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }


    public static function registerStaffToSchool(array $data){
        try {
            $data['school_pid'] = $data['school_pid'] ?? getSchoolPid();
            $data['pid'] =  public_id();
            $data['staff_id'] = $data['staff_id'] ?? self::staffUniqueId();
            return SchoolStaff::create($data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
        
    }

    public static function staffUniqueId(){
        $id = self::countStaff() + 1;
        $id =strlen($id) == 1 ? '0'.$id : $id;
        return SchoolController::getSchoolHandle().'/'.strtoupper(date('yM')).$id;
    }
    
    public static function countStaff(){
       return SchoolStaff::where(['school_pid'=>getSchoolPid()])->where('staff_id','like','%'.date('yM').'%')->count('id');
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
                    foreach($request->arm_pid as $row){
                        $dupParams['arm_pid'] = $data['arm_pid'] = $row;
                        $result = StaffClass::updateOrCreate($dupParams,$data);
                    }
                    if ($result) {
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
            'arm_pid'=> 'required',
            'session_pid'=> 'required',
            'term_pid'=> 'required',
            'teacher_pid'=> 'required',
            'subject_pid'=> 'required',
        ],[
            'category_pid.required'=>'Select Category to get the corresponding classes',
            'class_pid.required'=>'Select Class to get the corresponding Arms',
            'arm_pid.required'=>'Select class Arm to get the corresponding Subjects',
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
            $result= $this->assignClassArmSubjectToTeacher($data);
            if($result){
                return response()->json(['status'=>1,'message'=>'Selected Subject (s) assigned to staff!!!']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong from the Back!']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
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
}
