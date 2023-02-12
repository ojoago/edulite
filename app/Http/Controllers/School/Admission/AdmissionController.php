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
use App\Models\School\Admission\AdminssionHistory;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Framework\Admission\AdmissionSetup;

class AdmissionController extends Controller
{
    private $pwd = 654321;
    public function index($code=null){
        dd('continue working');
    }
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
                                            ->where($cnd)
                                            ->select('admission_number','a.pid','a.status','a.created_at', 'a.fullname',
                                                    'a.gsm','contact_gsm','contact_person','contact_email','class','arm')->get();

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
    
    public function loadAppliedAllAdmission(){
        $class = DB::table('classes as c')
                ->join('admission_setups as s','s.class_pid', 'c.pid')
                ->join('active_admissions as a','a.admission_pid','s.admission_pid')
                ->where(['a.school_pid'=>getSchoolPid()])->get(['c.pid','c.class']);
        $data = Admission::where(['school_pid'=>getSchoolPid(),'status'=>1])->get(['admission_number', 'fullname', 'arm_pid', 'class_pid', 'pid', 'created_at']);
        return view('school.admission.process-admission',compact('data','class'));
    }

    public function batchAdmission(Request $request){
        $count = count($request->pid);
        if($count==0){
            return redirect()->back()->with('info','No Applicant Selected');
        }
        $n=0;
        for($i=0;$i<$count; $i++){
            if(isset($request->pid[$i]) && isset($request->class[$i]) && isset($request->arm[$i])){
                $data = DB::table('admissions')->where(['school_pid' => getSchoolPid(), 'pid' => $request->pid[$i]])->first();
                $data->class_pid = $request->class[$i];
                $data->arm_pid = $request->arm[$i];
                $sts = $this->grantingAdmission($data);
                if($sts){
                    $n++;
                }
            }
        }
        if($n>0){
            return redirect()->back()->with('success',$n.' Admission Processed successfully');
        }
        return redirect()->back()->with('info','Selected at one class and class arm');
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
            'pid' => public_id(),
        ];
        // if email is not empty and it exist does not exist 
        if(!empty($info->email) && !AuthController::findEmail($info->email)){
            $data['email'] = $info->email;
        }
        
        // if gsm is not empty and it exist does not exist 
        if(!empty($info->gsm) && !AuthController::findGsm($info->gsm)){
            $data['gsm'] =  $info->gsm;
        }
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
            'contact_person'=>$info->contact_person, 
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
                        Admission::where(['school_pid'=>getSchoolPid(),'pid'=>$info->pid])->update(['status'=>2]);
                        // dd($up);
                        // $info->status = 2;
                        // $info->save();
                        // send mail to parent
                        // if($info->contact_email){} 
                        // if($info->email){} 
                        //$data['contact_email']
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

    // submit admission form 
    public function submitAdmission(Request $request){
        $params = DB::table('active_admissions as a')->join('admission_details as d', 'd.pid', 'a.admission_pid')->where(['a.school_pid' => getSchoolPid()])->first(['d.to','d.pid']);
        if(!$params){
            return response()->json(['status' => 'error', 'message' => 'there is no admission ongoing for now']);
        }
        if(today() > $params->to){
            return response()->json(['status' => 'error', 'message' => 'Admission has closed on '.$params->to]);
        }
        // logError(getInitials("ja n d ankpa"));
        $validator = Validator::make(
            $request->all(),
            [
                'firstname' => "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
                'lastname' => "required|string|min:3|regex:/^[a-zA-Z0-9'\s]+$/",
                'othername' => "nullable|string|regex:/^[a-zA-Z0-9'\s]+$/",
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
                'contact_gsm' => 'required_without:parent_pid|nullable|digits:11',
                'contact_email' => 'nullable|email',
                'contact_person' => 'required_without:parent_pid|nullable|string',
                'gender' => 'required|int',
                'dob' => 'required|date',
                'religion' => 'required',
                'address' => 'required',
                'type' => 'required',
                // 'session_pid' => 'required_without:pid|string',
                // 'term_pid' => 'required_without:pid|string',
                // 'category_pid' => 'required_without:pid|string',
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
                // 'category_pid.required_without' => 'Select Category for Student',
                'class_pid.required_without' => 'Select Class for Student',
                // 'arm_pid.required_without' => 'Select Class Arm for Student',
                'gsm.digits' => 'phone number should be empty 11 digits',
                'lastname.regex' => 'Special character is not allowed',
                'lastname.regex' => 'Special character is not allowed',
                'othername.regex' => 'Special character is not allowed',
                'contact_gsm.required_without' => 'Enter contact person phone number',
                'contact_person.required_without' => 'Enter name of contact person',
                'class_pid.required_without' => 'Select Class',
            ]
        );

        if(!$validator->fails()){
            $amount = AdmissionSetup::where(['class_pid' => $request->class_pid,'admission_pid'=>$params->pid,'school_pid'=>getSchoolPid()])->pluck('amount')->first();
            $applicant = [
                'school_pid'=>getSchoolPid(),
                'pid'=>$request->pid ?? public_id(),
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'othername'=>$request->othername,
                'username' => $request->username ?? self::uniqueUsername($request->firstname),
                // 'state'=>$request->state,
                // 'lga'=>$request->lga,
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
                'session_pid'=>activeSession(),
                'term_pid'=>activeTerm(),
                'staff_pid'=>getSchoolUserPid(),
                'admission_pid'=>$params->pid,
                'status'=> ($amount > 0) ? 0:1,
            ];
            if ($request->parent_pid) {
                $applicant['parent_pid'] = $request->parent_pid;
                if (empty($applicant['contact_person'])) {
                    $prnt = $this->loadParentData($applicant['parent_pid']);
                    if($prnt){
                        $applicant['contact_person']= $prnt->fullname;
                        $applicant['contact_email']= $prnt->email;
                        $applicant['contact_gsm']= $prnt->gsm;
                    }
                }
            }
            $msg = 'Applicant admission created successfully!!!';
            if (!$request->pid) {
                $applicant['admission_number'] = self::applicantId();
                $msg = 'Applicant admission updated successfully!!!';
                $applicant['class_pid'] = $request->class_pid;
                $applicant['arm_pid'] = $request->arm_pid;
                $applicant['state'] = $request->state;
                $applicant['lga'] = $request->lga;
            } else{
                // $applicant['admission_number'] = $request->admission_number;
                $applicant['status'] = $this->getAdmissionStatus($request->pid);
                if (isset($request->class_pid)) {
                    $applicant['class_pid'] = $request->class_pid;
                }
                if (isset($request->arm_pid)) {
                    $applicant['arm_pid'] = $request->arm_pid;
                }

                if (isset($request->state)) {
                    $applicant['state'] = $request->state;
                }
                if (isset($request->lga)) {
                    $applicant['lga'] = $request->lga;
                }
            }
            if ($request->passport) {
                $name = 'AP '.($applicant['admission_number'] ?? $applicant['pid']) . '-passport';
                $applicant['passport'] = saveImg(image: $request->file('passport'), name: $name);
            }
            $applicant['fullname'] = self::concatFullname($applicant);
            $sts = $this->updateOrCreateAdmission($applicant);
            if($sts){
                return response()->json(['status' => 1, 'message' => $msg, 'admission_number'=> $applicant['admission_number'] ?? $applicant['pid'] ]);
            }
            return response()->json(['status' =>'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);

    }
    private function loadParentData($pid){
        try{
            $data = DB::table('school_parents as p')
            ->join('users as u', 'u.pid', 'p.user_pid')
                ->join('user_details as d', 'd.user_pid', 'p.user_pid')
                ->where(['p.school_pid' => getSchoolPid(), 'p.pid' => $pid])
                ->first(['d.fullname', 'u.gsm', 'u.email']);
            return $data;
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }
    }
    private function getAdmissionStatus($pid){
        try{
            return Admission::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->pluck('status')->first();
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }
    }
    private function updateOrCreateAdmission(array $data){
        try{
            $result = Admission::updateOrCreate(['pid'=>$data['pid']],$data);
            return $result;
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }
    }
    public function admissionFeeForm(Request $request){
        if ($request->has('param')) {
            $applicantNumber = $request->input('param');
        }
  
        $data = DB::table('admissions as a')->join('admission_setups as s',function($join){
                                            $join->on('s.admission_pid', 'a.admission_pid')->on('s.class_pid', 'a.class_pid');
                                            })
                            ->where([['a.school_pid', getSchoolPid()], ['admission_number', $applicantNumber]])
                            ->orWhere([['a.school_pid' , getSchoolPid()], ['a.pid' , $applicantNumber]])
                            ->first(['contact_person', 'a.fullname', 
                                        'contact_email', 'admission_number', 'a.address', 'a.dob',
                                        'amount','gender','religion', 'a.passport', 'a.contact_gsm', 'a.status','a.pid'
                                    ]);
        return view('school.admission.admission-payment',compact('data'));
    }


    public static function applicantId()
    {
        $id = self::countStudent() + 1;
        $id = strlen($id) == 1 ? '0' . $id : $id;
        return (SchoolController::getSchoolCode() ?? SchoolController::getSchoolHandle()) . '/' . strtoupper(date('y')) . $id; // concatenate shool handle with student id
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
        $rm = [' ',"'",];
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


    // load admission for editing 
    public function loadAdmissionByPid($pid=null){
        return view('school.admission.admission-form',compact('pid'));
    }

    public function loadAdmissionDetail(Request $request){
        $data = DB::table('admissions')
        ->where(['school_pid' => getSchoolPid(), 'pid' => base64Decode($request->pid)])
            ->first();
        return response()->json($data);
    }
}
