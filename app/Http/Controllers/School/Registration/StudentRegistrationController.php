<?php

namespace App\Http\Controllers\School\Registration;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\School\School;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Models\School\Framework\Class\ClassArm;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Student\StudentController;

class StudentRegistrationController extends Controller
{
    private  $pwd = 123456;
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
        // $cnd = ['school_pid',getSchoolPid()];
        // $data = User::get(['pid','username']);
        // $school = School::get(['pid','school_name']);
        // $arm = ClassArm::get(['pid','arm']);
        // return view('school.registration.student.index',compact('data','school','arm'));
    }

    public function registerStudent(Request $request){
         
        $validator = Validator::make($request->all(),[
            'firstname'=> "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
            'lastname'=> "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
            'othername'=> "nullable|string|regex:/^[a-zA-Z0-9'\s]+$/",
            'gsm'=>['nullable','digits:11',
                                Rule::unique('users')->where(function($param) use ($request){
                                    $param->where('pid', '<>', $request->user_pid);
                                })],
            'username'=>['nullable', 'string', 'min:3', "regex:/^[a-zA-Z0-9\s]+$/", 
                                Rule::unique('users')->where(function ($param) use ($request) {
                                        $param->where('pid','<>', $request->user_pid);
                                    })],
            'email'=>['nullable', 'string', 'email', "regex:/^[a-zA-Z0-9.@\s]+$/",
                                Rule::unique('users')->where(function ($param) use ($request) {
                                        $param->where('pid', '<>', $request->user_pid);
                                    })],//|||unique:users,email
            'gender'=>'required',
            'dob'=>'required|date',
            'religion'=>'required',
            'address'=>'required',
            'type'=>'required',
            'category_pid'=>'required_without:pid|string', 
            'class_pid'=>'required_without:pid|string',
            'arm_pid'=>'required_without:pid|string',
            'passport'=> 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]
        ,[
            'dob.required'=>'Student Date of Birth is required',
            'firstname.required'=>'Enter Student First-Name',
            'lastname.required'=>'Enter Student Lasst-Name',
            'religion.required'=>'Select Student Religion',
            // 'state.required'=>'Select Student State of Origin',
            // 'lga.required'=>'Select LGA of Origin',
            'address.required'=>'Enter Student Residence Address',
            'type.required'=>'Select Student Type',
            'session_pid.required_without'=>'Select Session for Student',
            'term_pid.required_without'=>'Select Term for Student',
            'category_pid.required_without'=>'Select Category for Student',
            'class_pid.required_without'=>'Select Class for Student',
            'arm_pid.required_without'=>'Select Class Arm for Student',
            'gsm.digits'=> 'phone number should be empty 11 digits',
            'lastname.regex'=> 'Special character is not allowed',
            'lastname.regex'=> 'Special character is not allowed',
            'othername.regex'=> 'Special character is not allowed',
        ]

    );
        if(!$validator->fails()){
            $data = [
                'account_status' => 1,
                'password' => $this->pwd,
                'username' => $request->username ?? AuthController::uniqueUsername($request->firstname),
                'gsm' => $request->gsm,
                'pid' => $request->user_pid,
            ];
            if($request->email){ // do this check cos email comes as '' and cause dup, so if email is empty then ignore email column
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
            if(!$request->pid){
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
                // create user 
                $user = AuthController::createUser($data);
                if ($user) {
                    $detail['user_pid'] = $request->user_pid ?? $user->pid;// grt user pid and foreign key
                    // create user detail 
                    $userDetails = UserDetailsController::insertUserDetails($detail);
                    if ($userDetails) {
                        $student['fullname'] = $userDetails->fullname ?? UserDetailsController::getFullname($request->pid);//get student fullname and save along with student info
                        $student['user_pid'] = $request->user_pid ?? $user->pid;//get student user pid and save along with student info
                        // and prevent update if student leaves school 
                        if($request->passport){
                            $name = ($request->reg_number ?? $student['reg_number']);
                            $student['passport'] = saveImg(image: $request->file('passport'),name:$name);
                        }

                        $studentDetails = SchoolController::createSchoolStudent($student);// create school student
                        if ($studentDetails) {
                            if($request->parent_pid){
                                $student_pid =  $studentDetails->pid ?? $request->pid;
                                StudentController::linkParentToStudent(parentPid: $request->parent_pid,studentPid: $student_pid);
                            }
                            // student class history  
                            if(!$request->pid){
                                $studentClass['student_pid'] = $studentDetails->pid;
                                StudentController::createStudentClassRecord($studentClass);
                                return response()->json(['status'=>1,'message'=>'Account  created Successfully!!! here is Student Reg. No. '. $studentDetails->reg_number]);
                            }
                            return response()->json(['status'=>1,'message'=>'Student Account Updated Successfully!!']);
                        }
                        return response()->json(['status'=>1,'message'=>'account completely  created but student class details not taken, so please use '. $studentDetails->reg_number.' to take create history']);
                    }

                    return response()->json(['status'=>1,'message'=>'account created completely but student profile not created, so please use '.$user->username.' link to school']);
                }
                return response()->json(['status'=>1,'message'=>'account created but not completed, so please use '.$user->username.' to update details and link to school']);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                logError(['error'=>$e->getMessage(),'line'=>__LINE__]);
                return response()->json(['status'=>'error','message'=>'Something went Wrong... error logged']);
             }
            
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
      
    }

}
