<?php

namespace App\Http\Controllers\School\Admission;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Admission\Admission;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Admission\AdminssionHistory;

class AdmissionController extends Controller
{
    private $pwd = 654321;

    public function loadAppliedAdmission(){
        $cnd = ['a.school_pid' => getSchoolPid(),'a.status'=>1];
        return $this->loadAdmission($cnd);
    }
    public function loadGrantedAdmission(){
        $cnd = ['a.school_pid' => getSchoolPid(),'a.status' => 2];
        return $this->loadAdmission($cnd);
    }
    public function loadDeniedAdmission(){
        $cnd = ['a.school_pid' => getSchoolPid(),'a.status' => 3];
        return $this->loadAdmission($cnd);
    }
    public function loadAllAdmission($cnd){
        $cnd = ['a.school_pid' => getSchoolPid()];
        return $this->loadAdmission($cnd);
    }
    private function loadAdmission($cnd){
        $data = DB::table("admissions as a")->join('classes as c','c.pid','a.class_pid')
                                            ->join('class_arms as ca','ca.pid','a.arm_pid')
                                            ->leftJoin('school_parents as p','p.pid','a.parent_pid')
                                            ->leftJoin('user_details as d','d.user_pid','p.user_pid')
                                            ->leftJoin('users as u','u.pid','p.user_pid')
                                            ->where($cnd)
                                            ->select('admission_number','a.pid','a.status','a.created_at', 'a.fullname',
                                                    'a.gsm','contact_gsm','contact_person','contact_email','class','arm',
                                                    'u.gsm as mobile','d.fullname as names')->get();

        return datatables($data)
                    ->editColumn('date',function($data){
                        return date('d F Y', strtotime($data->created_at));
                    })
                    ->editColumn('action',function($data){
                        return view('school.admission.admission-action-buttons', ['data' => $data]);
                    })
                    ->addIndexColumn()
                    ->make(true);
    }
    

    public function grantAdmission(Request $request){
        $data = Admission::where(['school_pid'=>getSchoolPid(),'pid'=>base64Decode($request->pid)])->first();
        $sts = $this->grantingAdmission($data);
        if($sts){
            return response()->json(['status' => 1, 'message' => 'Admission granted!!!']);
        }
        return response()->json(['status' =>0, 'message' => 'Something Went Wrong']);
    }

    private function grantingAdmission($info){
        $data = [
            'account_status' => 1,
            'password' => $this->pwd,
            'username' => $info->username ? AuthController::uniqueUsername($info->username): AuthController::uniqueUsername($info->firstname),
            'email' => AuthController::findEmail($info->email) ? null: $info->email,
            'gsm' => AuthController::findGsm($info->gsm) ? null: $info->gsm,
            'pid' => public_id(),
        ];
        $detail = [
            'firstname' => $info->firstname,
            'lastname' => $info->lastname,
            'othername' => $info->othername,
            'gender' => $info->gender,
            'dob' => $info->dob,
            'religion' => $info->religion,
            'state' => $info->state,
            'lga' => $info->lga,
            'address' => $info->address,
            'fullname' => $info->fullname,
        ];
        $student = [
            'fullname' => $info->fullname,
            'parent_pid' => $info->parent_pid,
            'gender' => $info->gender,
            'dob' => $info->dob,
            'religion' => $info->religion,
            'state' => $info->state,
            'lga' => $info->lga,
            'address' => $info->address,
            'type' => $info->type,
            'pid' => public_id(),
            'reg_number' => StudentController::studentUniqueId(),
            'session_pid' => $info->session_pid,
            'term_pid' => $info->term_pid,
            'admitted_class' => $info->arm_pid,
            'current_class_pid' => $info->arm_pid,
            'current_session_pid' => $info->session_pid,
            'passport' => $info->passport,
            'staff_pid' => getSchoolUserPid(),
            'school_pid' => getSchoolPid(),
        ];
        $history = [
            'school_pid'=>$info->school_pid,
            'admission_number'=>$info->admission_number,
            'category_pid'=>$info->category_pid,
            'class_pid'=>$info->class_pid,
            'arm_pid'=>$info->arm_pid, 
            'admitted_arm_pid'=>$info->arm_pid,
            'session_pid'=>$info->session_pid, 
            'term_pid'=>$info->term_pid,
            'staff_pid'=>$info->staff_pid, 
            'contact_person'=>$info->contaact_person, 
            'contact_gsm'=>$info->contact_gsm, 
            'contact_email'=>$info->contact_email
        ];
        $studentClass = [
            'session_pid' => $info->session_pid,
            'arm_pid' => $info->arm_pid,
            'school_pid' => $student['school_pid'],
            'staff_pid' => getSchoolUserPid(),
        ];
        try {
            $user = AuthController::createUser($data);
            if($user){
                $student['user_pid'] = $detail['user_pid'] = $user->pid;
                // create user detail 
                $userDetails = UserDetailsController::insertUserDetails($detail);
                if($userDetails){
                    $studentDetails = SchoolController::createSchoolStudent($student);// create school student
                    if($studentDetails){
                        $history['student_pid'] = $studentClass['student_pid'] = $studentDetails->pid;
                        $this->createAdmissionHistory($history);
                        $info->status = 2;
                        $info->save();
                        return StudentController::createStudentClassRecord($studentClass);
                    }
                }
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    private function createAdmissionHistory(array $data){
        AdminssionHistory::create($data);
    }
    public function denyAdmission(Request $request){
        $data = Admission::where(['school_pid' => getSchoolPid(), 'pid' => base64Decode($request->pid)])->first(['id','status','staff_pid']);
        $sts = $this->denyingAdmission($data);
        if ($sts) {
            return response()->json(['status' => 1, 'message' => 'Admission Denied!!!']);
        }
        return response()->json(['status' => 0, 'message' => 'Something Went Wrong']); 
    }
    private function denyingAdmission($data){
        $data->status = 3;
        $data->staff_pid = getSchoolUserPid();
        return $data->save();
    }

    public function submitAdminssion(Request $request){
        
        // logError(getInitials("ja n d ankpa"));
        $validator = Validator::make(
            $request->all(),
            [
                'firstname' => 'required|string|min:3|regex:/^[a-zA-Z0-9\s]+$/',
                'lastname' => 'required|string|min:3|regex:/^[a-zA-Z0-9\s]+$/',
                'othername' => 'nullable|string|regex:/^[a-zA-Z0-9\s]+$/',
                'gsm' => [
                    'nullable', 'digits:11',
                    Rule::unique('admissions')->where(function ($param) use ($request) {
                        $param->where('pid', '!=', $request->pid)->where('school_pid',getSchoolPid());
                    })
                ],
                'username' => [
                    'nullable', 'string', 'min:3',
                    Rule::unique('admissions')->where(function ($param) use ($request) {
                        $param->where('pid', '!=', $request->pid)->where('school_pid', getSchoolPid());
                    })
                ],
                'email' => [
                    'nullable', 'string', 'email',
                    Rule::unique('admissions')->where(function ($param) use ($request) {
                        $param->where('pid', '!=', $request->pid)->where('school_pid', getSchoolPid());
                    })
                ], //|||unique:users,email
                'contact_gsm' => 'required_without:parent_pid|digits:11',
                'contact_email' => 'nullable|email',
                'contact_person' => 'required_without:parent_pid|string',
                'gender' => 'required|int',
                'dob' => 'required|date',
                'religion' => 'required',
                'address' => 'required',
                'type' => 'required',
                // 'session_pid' => 'required_without:pid|string',
                // 'term_pid' => 'required_without:pid|string',
                'category_pid' => 'required_without:pid|string',
                'class_pid' => 'required_without:pid|string',
                // 'arm_pid' => 'required_without:pid|string',
                'passport' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ],
            [
                'dob.required' => 'Student Date of Birth is required',
                'firstname.required' => 'Enter Student First-Name',
                'lastname.required' => 'Enter Student Lasst-Name',
                'religion.required' => 'Select Student Religion',
                // 'state.required'=>'Select Student State of Origin',
                // 'lga.required'=>'Select LGA of Origin',
                'address.required' => 'Enter Student Residence Address ',
                'type.required' => 'Select Student Type',
                // 'session_pid.required_without' => 'Select Session for Student',
                // 'term_pid.required_without' => 'Select Term for Student',
                'category_pid.required_without' => 'Select Category for Student',
                'class_pid.required_without' => 'Select Class for Student',
                // 'arm_pid.required_without' => 'Select Class Arm for Student',
                'gsm.digits' => 'phone number should be empty 11 digits',
                'lastname.regex' => 'Special character is not allowed',
                'lastname.regex' => 'Special character is not allowed',
                'othername.regex' => 'Special character is not allowed',
            ]
        );

        if(!$validator->fails()){
            $applicant = [
                'school_pid'=>getSchoolPid(),
                'pid'=>$request->pid ?? public_id(),
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'othername'=>$request->othername,
                'username' => $request->username ?? self::uniqueUsername($request->firstname),
                'state'=>$request->state,
                'lga'=>$request->lga,
                'dob'=>$request->dob,
                'gender'=> $request->gender,
                'religion'=>$request->religion,
                'address'=>$request->address,
                'contact_person'=>$request->contact_person,
                'contact_gsm'=>$request->contact_gsm,
                'contact_email'=>$request->contact_email,
                'gsm'=>$request->gsm,
                'email'=>$request->email,
                'category_pid'=>$request->category_pid,
                'class_pid'=>$request->class_pid,
                'arm_pid'=>$request->arm_pid,
                'session_pid'=>activeSession(),
                'term_pid'=>activeTerm(),
                'staff_pid'=>getSchoolUserPid(),
            ];
            if ($request->parent_pid) {
                $applicant['parent_pid'] = $request->parent_pid;
            }
            if (!$request->pid) {
                $applicant['admission_number'] = self::applicantId();
            }
            if ($request->passport) {
                $name = ($request->admission_number ?? $applicant['admission_number']) . '-passport';
                $applicant['passport'] = saveImg(image: $request->file('passport'), name: $name);
            }
            $applicant['fullname'] = self::concatFullname($applicant);
            $sts = Admission::create($applicant);
            if($sts){
                return response()->json(['status' => 1, 'message' => 'Applicatn admission created successfully!!!']);
            }
            return response()->json(['status' =>'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);

    }


    public static function applicantId()
    {
        $id = self::countStudent() + 1;
        $id = strlen($id) == 1 ? '0' . $id : $id;
        return SchoolController::getSchoolHandle() . '/' . strtoupper(date('y')) . $id; // concatenate shool handle with student id
    }
    public static function countStudent()
    {
        return Admission::where(['school_pid' => getSchoolPid()])
            ->where('admission_number', 'like', '%' . date('y') . '%')->count('id');
    }

    public static function uniqueUsername(string $firstname)
    {
        if (empty($firstname)) {
            return;
        }
        $rm = ['#', ' ', '`', "'", '#', '^', '%', '$', '', '*', '(', ')', ';', '"', '>', '<', '/', '?', '+', ',', ':', "|", '[', ']', '{', '}', '~'];
        $firstname = str_replace($rm, '', trim($firstname));
        $count = Admission::where('username', 'like', '%' . $firstname . '%')
            ->count('id');
        if ($count == 0) {
            return $firstname;
        }
        return $firstname . date('ym') . $count;
    }

    public static function concatFullname(array $data)
    {
        $names =  $data['lastname'] . ' ' . $data['firstname'] . ' ' . $data['othername'];
        return ucwords(trim($names));
    }
}
