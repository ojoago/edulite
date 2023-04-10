<?php

namespace App\Http\Controllers\School\Rider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Rider\SchoolRider;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\School\Framework\Events\SchoolNotificationController;

class SchoolRiderController extends Controller
{
    private $pwd = 123456;
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $data = SchoolRider::join('user_details','user_details.user_pid','school_riders.user_pid')
                    ->join('users','users.pid','school_riders.user_pid')
                    ->where(['school_riders.school_pid'=>getSchoolPid()])
                    ->get([
                            'fullname','gsm','email', 'username','address',
                            'school_riders.pid',
                            'school_riders.created_at']);
        return datatables($data)
                ->editColumn('date',function($data){
                    return $data->created_at->diffForHumans();
                })
                ->editColumn('count',function($data){
                    return  StudentController::countRiderStudent($data->pid);
                })
                ->addColumn('action',function($data){
                    return view('school.lists.rider.rider-action-buttons',['data'=>$data]);
                })
                ->addIndexColumn()
                ->make(true);
    }


    public function submitSchoolRiderForm(Request $request){
        // return response()->json(['status' => 5, 'mr' => $request->all()]);
        $validator = Validator::make($request->all(),[
            'firstname'=> "required|regex:/^[a-zA-Z0-9'\s]+$/",
            'lastname'=> "required|regex:/^[a-zA-Z0-9'\s]+$/",
            'othername'=> "nullable|regex:/^[a-zA-Z0-9'\s]+$/",
            'gsm'=>'required|min:11|max:11|unique:users,gsm',
            'username'=> "nullable|unique:users,username|regex:/^[a-zA-Z0-9\s]+$/",
            'email'=>'nullable|unique:users,email|email',
            'gender'=>'required',
            'dob'=> 'nullable|before:' . confrimYear(15),
            'religion'=>'required',
            'state'=>'required',
            'lga'=>'required',
            // 'student_pid',
            'address'=>'required',
            'passport' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ],[
            'gsm.required'=>'Enter Phone Number',
            'gsm.min'=>'Phone Number is 11 Digit',
            'gsm.max'=>'Phone Number is 11 Digit',
            'firstname.regex'=>'Special character is not allowed',
            'lasttname.regex'=>'Special character is not allowed',
            'dob.before'=> 'Pick up must be 15 years/above',
        ]);

        if(!$validator->fails()){
            $schoolPid = getSchoolPid();
            $data = [
                'gsm' => $request->gsm,
                'password' => $this->pwd,
                'account_status' => 1,
                'username' => $request->username ?? AuthController::uniqueUsername($request->firstname),
            ];
            if($request->email){
                $data['email'] = $request->email;
            }
            $user = AuthController::createUser($data);
            
            $userDetail = [
                'firstname' =>$request->firstname,
                'lastname' =>$request->lastname,
                'othername' => $request->othername,
                'gender' =>$request->gender,
                'dob' =>$request->dob,
                'religion' =>$request->religion,
                'state' =>$request->state,
                'lga' =>$request->lga,
                'address' =>$request->address,
            ];
           try {
                if ($user) {
                    $userDetail['user_pid'] = $user->pid;
                    $detail = UserDetailsController::insertUserDetails($userDetail);
                    $schoolRider = [
                        'school_pid' => $schoolPid,
                        'user_pid' => $user->pid,
                        'pid' => public_id(),
                        'rider_id' => self::riderUniqueId(),
                    ];
                    if ($request->passport) {
                        $name = $schoolRider['rider_id'] . '-R-passport';
                        $schoolRider['passport'] = saveImg($request->file('passport'), name: $name);
                    }
                    if ($detail) {
                        $rider = SchoolController::createSchoolRider($schoolRider);
                        if ($rider) {
                            if ($request->student_pid) {
                                $data = [
                                    'staff_pid' => getSchoolUserPid(),
                                    'rider_pid' => $rider->pid,
                                    'school_pid' => $schoolPid,
                                ];
                                foreach ($request->student_pid as $pid) {
                                    $data['student_pid'] = $pid;
                                    StudentController::linkPickUperRiderToStudent($data);
                                }
                                if ($request->email) {
                                    $msg = "Your registration is successfull, your user username: {$user->username}, and your password is {$this->pwd}. You can always reset your password anytime anywhere. NB. you can login with either your username, phone number or email along with your password";
                                    $this->mailNotification(pid: $rider->pid, msg: $msg);
                                }
                                
                                return response()->json(['status' => 1, 'message' => 'Account created Successfully & selected student\'s linked!!!']);
                            }
                            return response()->json(['status' => 1, 'message' => 'School Rider Pick up Rider Account created Successfully!!!']);
                        }
                        return response()->json(['status' => 1, 'message' => 'User Account Created but not Linked to School, please link using the add menu']);
                    }
                    return response()->json(['status' => 1, 'message' => 'User account created partialy, please edit and add!!!']);
                }
            
           } catch (\Throwable $e) {
                $error = $e->getMessage();
                logError($error);
           }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    // $msg = "Your registration is successfull, your user username: {$user->username}, and your password is {$this->pwd}. You can always reset your password anytime anywhere. NB. you can login with either your username, phone number or email with along with your password";
    //                             $this->mailNotification(pid:$parentData->pid,msg:$msg);
    private function mailNotification($msg, $pid)
    {
        $user = self::getRiderDetailBypId(pid: $pid);
        $schoolData = SchoolController::loadSchoolNotificationDetail(getSchoolPid());
        SchoolNotificationController::sendSchoolMail($schoolData, $user, $msg);
    }
    public function riderProfile($pid){
        return view('school.lists.rider.rider-profile',compact('pid'));
    }
    public function viewRiderProfile(Request $request){
        $data = DB::table('school_riders as r')
                    ->join('users as u','u.pid','r.user_pid')
                    ->join('user_details as d','d.user_pid','r.user_pid')
                    // ->join('student_pick_up_riders as p','p.rider_pid','r.pid')
                    ->where(['r.school_pid'=>getSchoolPid(),'r.pid'=>base64Decode($request->pid)])
                    ->select(DB::raw('gsm,email,username,fullname,address,dob,title,gender,religion,passport,r.pid'))
                    // ->groupBy('r.pid')
                    // ->groupBy('u.gsm')
                    ->first();
        echo formatRiderProfile($data);
    }
    public function viewRiderStudent(Request $request){
        // $data = Student::join('student_pick_up_riders', 'student_pid','students.pid')
        //                 ->where(['s.school_pid' => getSchoolPid()])->get('students.*');
                        $data = DB::table('students as s')
                        ->join('student_pick_up_riders as p','p.student_pid','s.pid')
                        ->where(['s.school_pid'=>getSchoolPid(),'p.rider_pid'=>base64Decode($request->pid)])
                        ->select('s.fullname','s.reg_number','p.created_at','s.address','p.status','note')
                        ->orderByDesc('s.fullname')->get();
            return datatables($data)
            ->editColumn('date',function($data){
                return date('d F Y',strtotime($data->created_at));
            })
            ->editColumn('status',function($data){
                return matchStudentRiderStatus($data->status);
            })
            ->make(true);
    }



    public function linkStudentToRider(Request $request){
        $validator = Validator::make($request->all(),[
            'rider_pid'=>'required',
            'student_pid'=>'required',
        ],['rider_pid.required'=>'Select Care/Rider', 'student_pid.required'=>'Select 1 Student at least']);

        if(!$validator->fails()){
            $data = [
                'staff_pid' => getSchoolUserPid(),
                'rider_pid' => $request->rider_pid,
                'school_pid' => getSchoolPid(),
            ];
            foreach($request->student_pid as $std) {
                $data['student_pid'] = $std;
                $result = StudentController::linkPickUperRiderToStudent($data);
            }
            if($result){
                
                return response()->json(['status'=>1,'message'=>'Student Linked to Care/Rider']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong... error logged']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }
    public static function riderUniqueId()
    {
        $id = self::countRider() + 1;
        $id = strlen($id) == 1 ? '0' . $id : $id;
        return SchoolController::getSchoolHandle() . '/' . strtoupper(date('yMd')) . $id; // concatenate shool handle with Rider id
    }
    public static function getRiderDetailBypId(string $pid)
    {
        $data = SchoolRider::join('user_details', 'user_details.user_pid', 'school_riders.user_pid')
        ->join('users', 'users.pid', 'school_riders.user_pid')
        ->where(['school_riders.school_pid' => getSchoolPid(), 'school_riders.pid'=>$pid])
            ->first(['fullname', 'gsm', 'email','title']);
        return $data;
    }
    public static function countRider()
    {
        return SchoolRider::where(['school_pid' => getSchoolPid()])
            ->where('rider_id', 'like', '%' . date('yMd') . '%')->count('id');
    }
}
