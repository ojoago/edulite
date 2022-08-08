<?php

namespace App\Http\Controllers\School\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\StaffClass;
use App\Models\School\Staff\SchoolStaff;
use App\Models\School\Staff\StaffSubject;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
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
                        'role_id','school_staff.pid', 'school_staff.created_at'
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
        })->addIndexColumn()
        ->editColumn('role_id', function ($data) {
            return matchStaffRole($data->role_id);
        })
        ->make(true);
    }
    public function staffProfile($id)
    {
        setActionablePid($id);
        return redirect()->route('view.staff.profile');
    }
    public function viewStaffProfile()
    {
        
        return view('school.staff.staff-profile');
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
        ],['gsm.required'=>'Enter Phone Number','dob.required'=>'Enter you date of birth']);
        
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
            ];
            $user = AuthController::createUser($data);
            if($user){
                $detail['user_pid'] = $user->pid;
                $userDetails = UserDetailsController::insertUserDetails($detail);
                if($userDetails){
                   $result = $this->registerStaffToSchool(['role'=>$request->role,'user_pid'=>$user->pid]);
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

    private function registerStaffToSchool(array $data){
        try {
            $data = [
                'staff_id' =>    self::staffUniqueId(),
                'school_pid' =>  getSchoolPid(),
                'user_pid' =>    $data['user_pid'],
                'pid' =>         public_id(),
                'role_id' =>     $data['role'],
            ];
            return SchoolStaff::create($data);
           
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    public static function staffUniqueId(){
        $id = self::countStaff() + 1;
        $id =strlen($id) == 1 ? '0'.$id : $id;
        return strtoupper(date('yM')).$id;
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

    public function StaffClass(Request $request){
        
        try {
            $request['school_pid'] = getSchoolPid();
            $request['pid'] = public_id();
            $result = StaffClass::create($request->all());
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
    public function StaffSubject(Request $request){
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
