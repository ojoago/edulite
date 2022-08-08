<?php

namespace App\Http\Controllers\School\Rider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Rider\SchoolRider;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Student\StudentController;

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

        $validator = Validator::make($request->all(),[
            'firstname'=>'required',
            'lastname'=>'required',
            // 'othername',
            'gsm'=>'required|min:11|max:11|unique:users,gsm',
            'username'=>'nullable|unique:users,username',
            'email'=>'nullable|unique:users,email|email',
            'gender'=>'required',
            // 'dob',
            'religion'=>'required',
            'state'=>'required',
            'lga'=>'required',
            // 'student_pid',
            'address'=>'required',
        ],[
            'gsm.required'=>'Enter Phone Number',
            'gsm.min'=>'Phone Number is 11 Digit',
            'gsm.max'=>'Phone Number is 11 Digit',
        ]);

        if(!$validator->fails()){
            $schoolPid = getSchoolPid();
            $data = [
                'email' => $request->email,
                'gsm' => $request->gsm,
                'password' => $this->pwd,
                'username' => $request->username ?? AuthController::uniqueUsername($request->firstname),
            ];
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
            if($user){
                $userDetail['user_pid'] = $user->pid;
                $detail = UserDetailsController::insertUserDetails($userDetail);
                $schoolRider = [
                    'school_pid' => $schoolPid,
                    'user_pid' => $user->pid,
                    'pid' => public_id(),
                    'rider_id'=>$this->riderUniqueId(),
                ];
                $rider = self::createSchoolRider($schoolRider);
                if($rider){
                    if($detail){
                        return response()->json(['status'=>1,'message'=>'School Rider Pick up Rider Account created Successfully!!!']);
                    }
                    if($request->student_pid){
                        $data = [
                            'student_pid'=>$request->student_pid,
                            'rider_pid'=>$rider->pid,
                            'school_pid'=>$schoolPid,
                        ];
                        StudentController::linkPickUperRiderToStudent($data);
                    }
                    return response()->json(['status'=>1,'message'=>'Pick up Rider Account not completed, please update details']);
                }
                return response()->json(['status'=>1,'message'=>'Pick up Rider Account not Linked to School, link differently']);
                    
            }
            
            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }
    
    public static function createSchoolRider($data){
        $dupParams = [
          'user_pid'=>$data['user_pid'],    
          'school_pid'=>$data['school_pid'],
          'pid'=>$data['pid']  
        ];
        try {
            return SchoolRider::updateOrCreate($dupParams,$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    private function riderUniqueId()
    {
        $id = self::countRider() + 1;
        $id = strlen($id) == 1 ? '0' . $id : $id;
        return SchoolController::getSchoolHandle() . '/' . strtoupper(date('yMd')) . $id; // concatenate shool handle with Rider id
    }
    public static function countRider()
    {
        return SchoolRider::where(['school_pid' => getSchoolPid()])
            ->where('rider_id', 'like', '%' . date('yMd') . '%')->count('id');
    }
}
