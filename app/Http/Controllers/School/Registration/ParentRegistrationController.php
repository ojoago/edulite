<?php

namespace App\Http\Controllers\School\Registration;

use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Parent\ParentController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\Users\UserDetailsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParentRegistrationController extends Controller
{
    private $pwd = 1243657;
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerParent(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname'=> 'required|string|min:3',
            'lastname'=>'required|string|min:3',
            // 'othername'=>'required',
            'gsm'=>'required|min:11|max:11|unique:users,gsm',
            'username'=>'string|nullable|unique:users,username',
            'email'=>'string|email|nullable|unique:users,email',
            'gender'=>'required',
            // 'dob'=>'',
            // 'religion'=>'required|string|',
            'state'=>'required',
            'lga'=>'required',
            'address'=>'required|string',
        ],[
            'firstname.required'=>'Enter Parent First-Name',
            'lastname.required'=>'Enter Parent First-Name',
            'gsm.required'=>'Enter Parent Phone Number',
            'gsm.unique'=> 'Phone Number exists, parent can provide his/her EduLite username for linking',
            'gsm.min'=> 'Phone Number is 11 Digit',
            'gsm.max'=> 'Phone Number is 11 Digit',
            'address.required'=> 'Enter Parent Address',
        ]);
        
        if(!$validator->fails()){
            $data = [
                'password'=>$this->pwd,
                'gsm'=>$request->gsm,
                'username'=>$request->username ?? AuthController::uniqueUsername($request->firstname),
                'email'=>$request->email,
                'account_status'=> 1,
            ];
            $userDetail = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'othername'=> $request->othername,
                'gender' => $request->gender,
                'dob'=> $request->dob,
                'religion'=> $request->religion,
                'state' => $request->state,
                'lga' => $request->lga,
                'address' => $request->address,
            ];
            $parent = [
                // 'user_pid'=>$user->pid,
                'school_pid'=>getSchoolPid(),
                'pid'=>public_id(),
                'parent_image_path'=>$request->file,
            ];
            try {
               $user= AuthController::createUser($data);
               if($user){
                    $parent['user_pid'] = $userDetail['user_pid'] = $user->pid;
                    $details = UserDetailsController::insertUserDetails($userDetail);
                    if($details){
                        $parentData = ParentController::createSchoolParent($parent);
                        if($parentData){
                            if($request->student_pid){
                                StudentController::linkParentToStudent($request->student_pid, $parentData->pid);
                                return response()->json(['status'=>1,'message'=> 'Parent account created successfully and linked to Student']);
                            }
                            return response()->json(['status'=>1,'message'=> 'Parent account created successfully!!!']);
                        }
                        return response()->json(['status'=>1,'message'=> 'Parent account created successfully!!!']);
                    }
                    return response()->json(['status'=>2,'message'=> 'user account created, but not linked to school, use phone number to link parent to school']);
               }
               return response()->json(['status'=>2,'message'=>'user account created but detail not complete, login to update details then link parent to school and student']);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                logError($error);
            }
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }

}
