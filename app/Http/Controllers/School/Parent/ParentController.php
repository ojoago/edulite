<?php

namespace App\Http\Controllers\School\Parent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Models\School\Registration\SchoolParent;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\School\Framework\Events\SchoolNotificationController;

class ParentController extends Controller
{
    private $pwd = 7654321;

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(){
        $data = SchoolParent::join('user_details', 'school_parents.user_pid', 'user_details.user_pid')
                            ->join('users','users.pid', 'school_parents.user_pid')
                            ->where('school_parents.school_pid', getSchoolPid())
                            ->get(['fullname', 'gsm', 'email', 'address', 'username', 'school_parents.pid', 'school_parents.created_at', 'school_parents.status', 'user_details.user_pid']);
        // $data = DB::table('school_parents as p')
        //             ->join('user_details as d','p.user_pid','d.user_pid')
        //             ->join('users as u','u.pid','p.user_pid')
        //             ->leftJoin('students as s','s.parent_pid','p.pid')
        //             ->where('p.school_pid',getSchoolPid())
        //             ->select(DB::raw('COUNT(s.parent_pid) AS count, d.fullname,gsm,p.pid,email,d.address,username,p.created_at,p.status'))
        //             // ->groupBy('p.pid')
        //             ->get();
                     return datatables($data)
                        ->editColumn('date',function($data){
                                return date('d F Y',strtotime($data->created_at));
                        })
                        ->editColumn('count',function($data){
                                return $data->wardCount();
                        })
                        // ->editColumn('status',function($data){
                        //         return $data->status==1 ? '<span class="text-success">Enabled</span>' : '<span class="text-success">Disabled</span>';
                        // })
                        ->addColumn('action',function($data){
                                return view('school.lists.parent.parent-action-buttons',['data'=>$data]);
                        })
                        ->addIndexColumn()->make(true);
    }


  
    public static function parentProfile ($id){
        $data = SchoolParent::join('user_details', 'school_parents.user_pid', 'user_details.user_pid')
        ->join('users', 'users.pid', 'school_parents.user_pid')
        ->where(['school_parents.school_pid'=> getSchoolPid(), 'school_parents.pid'=> base64Decode($id)])
            ->first(['fullname', 'gsm', 'email', 'address',
                     'username', 'school_parents.pid', 'school_parents.created_at',
                      'school_parents.status', 'gender', 'religion', 'title', 'state', 'lga',
                       'passport', 'account_status as status', 'school_parents.pid']);
        // $data = DB::table('school_parents as p')->join('users as u','u.pid','p.user_pid')
        //                 ->join('user_details as d','d.user_pid','p.user_pid')
        //                 ->leftJoin('students as s','s.parent_pid','p.pid')->where('p.pid',base64Decode($id))
        //                 ->select(DB::raw('COUNT(s.parent_pid) AS count,d.fullname,d.address,d.dob,gsm,username,email,d.gender,d.religion,d.title,d.state,d.lga,p.passport,account_status as status,p.pid'))->groupBy('p.pid')->first();
        return view('school.lists.parent.parent-profile', compact('data'));
    }

    public function myWards($id){
        $data = DB::table("students as s")->leftjoin("class_arms as a",'a.pid', 's.current_class_pid')
                ->join('sessions as e','e.pid', 's.current_session_pid')
                ->join('users as u','u.pid','s.user_pid')
                ->join('user_details as d','d.user_pid','s.user_pid')
                ->where(['s.school_pid'=>getSchoolPid(),'parent_pid'=>base64Decode($id)])->orderByDesc('s.id')
                ->get(['reg_number', 's.fullname', 'type', 's.status','passport', 's.religion','session','arm','username','gsm','s.gender','dob', 'parent_pid','s.pid']);
        return view('school.lists.parent.wards.parent-wards',compact('data'));
    }

    public static function getParentFullname($pid){
        return SchoolParent::join('user_details','user_details.user_pid','school_parents.user_pid')
                            ->where('school_parents.pid',$pid)->pluck('fullname')->first();
    }
    public static function getParentDetailBypId($pid){
        $data = SchoolParent::join('user_details', 'school_parents.user_pid', 'user_details.user_pid')
        ->join('users', 'users.pid', 'school_parents.user_pid')
        ->where(['school_parents.school_pid' => getSchoolPid(), 'school_parents.pid' => $pid])
        ->first(['fullname', 'gsm', 'email', 'title']);
        return $data;
    }

    public function toggleParentStatus(Request $request){
        if($request->pid)
            return self::updateParentStatus(base64Decode($request->pid));
        else 
        return 'Wrong Parameter sent';
    }

    public static function updateParentStatus($pid){
        $parent = SchoolParent::where('pid',$pid)->first(['id','status']);
        $parent->status = $parent->status == 1 ? 0 : 1;
        $parent->save();
        return 'Status updated';
    }


    public function wardLogin($pid){
//         parent child operation
// 1 pay fees
// 2 view result
// 3 view attendance
// 4 view timebale
// 5 view notification
// 6 view rider
    }


    // register parent goes here 

    public function registerParent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
            'lastname' => "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
            'othername' => "nullable|string|regex:/^[a-zA-Z0-9'\s]+$/",
            'gsm' => 'required|min:11|max:11|unique:users,gsm',
            'username' => "string|nullable|unique:users,username|regex:/^[a-zA-Z0-9\s]+$/",
            'email' => 'string|email|nullable|unique:users,email|regex:/^[a-zA-Z0-9\s]+$/',
            'gender' => 'required',
            'dob' => 'nullable|before:' . confrimYear(),
            // 'religion'=>'required|string|',
            'state' => 'required',
            'lga' => 'required',
            'passport' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'address' => 'required|string',
        ], [
            'firstname.required' => 'Enter Parent First-Name',
            'lastname.required' => 'Enter Parent First-Name',
            'gsm.required' => 'Enter Parent Phone Number',
            'gsm.unique' => 'Phone Number exists, parent can provide his/her EduLite username for linking',
            'gsm.min' => 'Phone Number is 11 Digit',
            'gsm.max' => 'Phone Number is 11 Digit',
            'address.required' => 'Enter Parent Address',
            'dob.before' => 'Parent must be 18 years/above',
        ]);

        if (!$validator->fails()) {
            $data = [
                'password' => $this->pwd,
                'gsm' => $request->gsm,
                'username' => $request->username ?? AuthController::uniqueUsername($request->firstname),
                // 'email'=>$request->email,
                'account_status' => 1,
            ];
            if ($request->email) {
                $data['email'] = $request->email;
            }
            $userDetail = [
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
            $parent = [
                // 'user_pid'=>$user->pid,
                'school_pid' => getSchoolPid(),
                'pid' => public_id(),
            ];
            try {
                $user = AuthController::createUser($data);
                if ($user) {
                    $parent['user_pid'] = $userDetail['user_pid'] = $user->pid;
                    $details = UserDetailsController::insertUserDetails($userDetail);
                    if ($details) {
                        if ($request->passport) {
                            $name = $parent['pid'] . '-passport';
                            $parent['passport'] = saveImg($request->file('passport'), name: $name);
                        }
                        $parentData = SchoolController::createSchoolParent($parent);
                        if ($parentData) {
                            if ($request->student_pid) {
                                foreach ($request->student_pid as $pid) {
                                    StudentController::linkParentToStudent($pid, $parentData->pid);
                                }
                                if ($request->email) {
                                    $msg = "Your registration is successfull, your user username: {$user->username}, and your password is {$this->pwd}. You can always reset your password anytime anywhere. NB. you can login with either your username, phone number or email along with your password";
                                    $this->mailNotification(pid: $parentData->pid, msg: $msg);
                                }

                                return response()->json(['status' => 1, 'message' => 'Parent account created successfully and linked to Student']);
                            }
                            return response()->json(['status' => 1, 'message' => 'Parent account created successfully!!!']);
                        }
                        return response()->json(['status' => 1, 'message' => 'Parent account created successfully!!!']);
                    }
                    return response()->json(['status' => 2, 'message' => 'user account created, but not linked to school, use phone number to link parent to school']);
                }
                return response()->json(['status' => 2, 'message' => 'user account created but detail not complete, login to update details then link parent to school and student']);
            } catch (\Throwable $e) {
                $error = $e->getMessage();

                logError($error);
                return response()->json(['status' => 'error', 'message' => 'contact admin, error has be logged']);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    // $msg = "Your registration is successfull, your user username: {$user->username}, and your password is {$this->pwd}. You can always reset your password anytime anywhere. NB. you can login with either your username, phone number or email with along with your password";
    //                             $this->mailNotification(pid:$parentData->pid,msg:$msg);
    private function mailNotification($msg, $pid)
    {
        $user = ParentController::getParentDetailBypId(pid: $pid);
        $schoolData = SchoolController::loadSchoolNotificationDetail(getSchoolPid());
        SchoolNotificationController::sendSchoolMail($schoolData, $user, $msg);
    }
}
