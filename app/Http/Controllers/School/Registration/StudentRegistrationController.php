<?php

namespace App\Http\Controllers\School\Registration;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\School\School;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Models\School\Framework\Class\ClassArm;

class StudentRegistrationController extends Controller
{
    private  $pwd = 654321;
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
        $cnd = ['school_pid',getSchoolPid()];
        $data = User::get(['pid','username']);
        $school = School::get(['pid','school_name']);
        $arm = ClassArm::get(['pid','arm']);
        return view('school.registration.student.index',compact('data','school','arm'));
    }

    public function registerStudent(Request $request){
         
        $validator = Validator::make($request->all(),[
            'firstname'=> 'required|string|min:3|regex:/^[a-zA-Z0-9\s]+$/',
            'lastname'=> 'required|string|min:3|regex:/^[a-zA-Z0-9\s]+$/',
            'othername'=> 'nullable|string|regex:/^[a-zA-Z0-9\s]+$/',
            'gsm'=>'nullable|unique:users,gsm|min:11|max:11',
            'username'=>'nullable|string|unique:users,username|min:3',
            'email'=>'nullable|string|email|unique:users,email',
            'gender'=>'required|int',
            'dob'=>'required|date',
            'religion'=>'required',
            // 'state'=>'required',
            // 'lga'=>'required',
            'address'=>'required',
            'type'=>'required',
            'session_pid'=>'required|string',
            'term_pid'=>'required|string',
            'category_pid'=>'required|string', 
            'class_pid'=>'required|string',
            'arm_pid'=>'required|string',
            'passport'=> 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]
        // ,[
        //     'dob.required'=>'Select Student Date of birth',
        //     'firstname.required'=>'Enter Student First-Name',
        //     'lastname.required'=>'Enter Student Lasst-Name',
        //     'religion.required'=>'Select Student Religion',
        //     // 'state.required'=>'Select Student State of Origin',
        //     // 'lga.required'=>'Select LGA of Origin',
        //     'address.required'=>'Enter Student Residence Address',
        //     'type.required'=>'Select Student Type',
        //     'session_pid.required'=>'Select Session for Student',
        //     'term_pid.required'=>'Select Term for Student',
        //     'category_pid.required'=>'Select Category for Student',
        //     'class_pid.required'=>'Select Class for Student',
        //     'arm_pid.required'=>'Select Class Arm for Student',
        // ]
    );
        if(!$validator->fails()){
            $data = [
                'account_status' => 1,
                'password' => $this->pwd,
                'username' => $request->username ?? AuthController::uniqueUsername($request->firstname),
                'email' => $request->email,
                'gsm' => $request->gsm,
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
            $student = [
                'reg_number' => StudentController::studentUniqueId(),
                'gender' => $request->gender,
                'dob' => $request->dob,
                'religion' => $request->religion,
                'state' => $request->state,
                'lga' => $request->lga,
                'address' => $request->address,
                'type' => $request->type,
                'session_pid' => $request->session_pid,
                'term_pid' => $request->term_pid,
                'admitted_class' => $request->arm_pid,
                'current_class' => $request->arm_pid,
                'current_session_pid' => $request->session_pid,
                'staff_pid' => getSchoolUserPid(),
                'school_pid'=>getSchoolPid(),
                'pid'=>public_id(),
            ];
            

            $studentClass = [
                'session_pid' => $request->session_pid,
                'arm_pid' => $request->arm_pid,
                'school_pid' => $student['school_pid'],
                'staff_pid' => getSchoolUserPid(),
            ];
             try {
                // create user 
                $user = AuthController::createUser($data);
                if ($user) {
                    $detail['user_pid'] = $user->pid;// grt user pid and foreign key
                    // create user detail 
                    $userDetails = UserDetailsController::insertUserDetails($detail);
                    
                    if ($userDetails) {
                        $student['fullname'] = $userDetails->fullname;//get student fullname and save along with student info
                        $student['user_pid'] = $user->pid;//get student fullname and save along with student info
                        // and prevent update if student leaves school 
                        if($request->passport){
                            $name = $student['reg_number'].'-passport';
                            $student['passport'] = saveImg(image: $request->file('passport'),name:$name);
                        }
                        $studentDetails = StudentController::createSchoolStudent($student);// create school student
                        if ($studentDetails) {
                            // student class history  
                            $studentClass['student_pid'] = $studentDetails->pid;
                            
                            StudentController::createStudentClassRecord($studentClass);
                            
                            return response()->json(['status'=>1,'message'=>'Account  created Successfully!!! here is Student Reg. No. '. $studentDetails->reg_number]);
                        }
                        return response()->json(['status'=>1,'message'=>'account completely  created but student class details not taken, so please use '. $studentDetails->reg_number.' to take create history']);
                    }

                    return response()->json(['status'=>1,'message'=>'account created completely but student profile not created, so please use '.$user->username.' link to school']);
                }
                return response()->json(['status'=>1,'message'=>'account created but not completed, so please use '.$user->username.' to update details and link to school']);
             } catch (\Throwable $e) {
                $error = $e->getMessage();
                logError($error);
             }
            
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
      
    }

    
}
