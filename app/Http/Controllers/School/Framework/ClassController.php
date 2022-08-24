<?php

namespace App\Http\Controllers\School\Framework;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\ClassArmSubject;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadCategory()
    {
        $data = Category::join('school_staff', 'school_staff.pid', 'categories.staff_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->where(['categories.school_pid' => getSchoolPid()])
            ->get(['categories.pid', 'category', 'categories.created_at', 'description', 'username']);
        return datatables($data)
            // ->addColumn('action', function ($data) {
            //     $html = '
            //     <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#editSubjectModal' . $data->pid . '">
            //         <i class="bi bi-box-arrow-up" aria-hidden="true"></i>
            //     </button>
            //     <div class="modal fade" id="editSubjectModal' . $data->pid . '" tabindex="-1">
            //         <div class="modal-dialog">
            //             <div class="modal-content">
            //                 <div class="modal-header">
            //                     <h5 class="modal-title">Edit Lite S</h5>
            //                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            //                 </div>
            //                 <div class="modal-body">
            //                     <form action="" method="post" class="" id="createSubjectForm">
            //                         <p class="text-danger category_pid_error"></p>
            //                         <input type="text" name="subject" value="' . $data->subject_type . '" class="form-control form-control-sm" placeholder="name of school" required>
            //                         <p class="text-danger subject_error"></p>
            //                         <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required>' . $data->description . '</textarea>
            //                         <p class="text-danger description_error"></p>
            //                     </form>
            //                 </div>
            //                 <div class="modal-footer">
            //                     <button type="button" class="btn btn-primary" id="createSubjectBtn">Submit</button>
            //                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            //     ';
            //     return $html;
            // })
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            // ->rawColumns(['data', 'action'])
            ->make(true);
        
    }


    public function loadClasses()
    {
        $data = Classes::join('school_staff', 'school_staff.pid', 'classes.staff_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->join('categories', 'categories.pid', 'classes.category_pid')
        ->where(['classes.school_pid' => getSchoolPid()])
            ->get(['classes.pid', 'category', 'classes.created_at', 'class', 'classes.status','username']);
        return datatables($data)
            ->addColumn('action', function ($data) {
                return view('school.framework.class.class-action-buttons',['data'=>$data]);
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->editColumn('status', function ($data) {
                $html = $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
                return $html;
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }
    public function loadClassArm()
    {
        $data = ClassArm::join('school_staff', 'school_staff.pid', 'classes.staff_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->join('classes', 'classes.pid', 'class_arms.class_pid')
        ->where(['class_arms.school_pid' => getSchoolPid()])
            ->get(['class_arms.pid', 'class','arm', 'class_arms.created_at', 'class_arms.status','username']);
        return datatables($data)
            ->addColumn('action', function ($data) {
                return view('school.framework.class.class-arm-action-buttons', ['data' => $data]);
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
                // return $html;
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }
    public function loadClassArmSubject()
    {
        $data = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
        ->join('subjects', 'subjects.pid', 'subject_pid')
        ->join('sessions', 'sessions.pid', 'session_pid')
        ->join('school_staff', 'school_staff.pid', 'class_arm_subjects.staff_pid')
        ->join('user_details', 'user_details.user_pid', 'school_staff.user_pid')
        ->where(['class_arm_subjects.school_pid' => getSchoolPid()])
            ->get(['class_arm_subjects.pid', 'session','arm','subject', 'class_arm_subjects.created_at', 'class_arm_subjects.status', 'user_details.fullname']);
        return datatables($data)
            ->addColumn('action', function ($data) {
                return view('school.framework.class.class-subject-action-buttons',['data'=>$data]);
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->editColumn('status', function ($data) {
                $html = $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
                return $html;
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }
    
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category' => 'required',
            'head_pid'=>'required'
        ],['head_pid.required'=>'Select Category Head or Principal']);
        if(!$validator->fails()){
            $data = [
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid(),
                    'pid' => public_id(),
                    'category' => $request->category,
                    'head_pid' => $request->head_pid,
                    'description' => $request->description
                ];
            $result = $this->insertOrUpdateCategory($data);
            if ($result) {
                $msg = 'New School category created successfully';
                if(isset($request->pid)){
                    $msg = 'School category update successfully';
                }
                return response()->json(['status'=>1,'message'=>$msg]);
            }
            return response()->json(['status'=>'2', 'message'=>'Operation Failed']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function insertOrUpdateCategory($data){
        try {
            return Category::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
           
        }
    }

    public function createClass(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_pid' => 'required',
            'class' => 'required|array',
            'class_number' => 'required|array']
            ,[
            'category_pid.required'=>'select school category',
            'class.required'=>'Enter class Name',
            'class_number.required'=>'select Class number',
            'class_number.int'=>'class number must a number',
            ]
        );
        if(!$validator->fails()){
            $data = [
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid(),
                'number' => $request->class_number,
                'classes' => $request->class,
                'category_pid' => $request->category_pid,
            ];
            $result = $this->insertOrUpdateClass($data);
            if ($result) {
                $msg = 'school class created successfully';
                if(isset($request->pid)){
                    $msg = 'class updated successfully';
                }
                return response()->json(['status'=>1,'message'=> $msg]);
            }
            return response()->json(['status'=>'error','message'=> 'operation failed']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function insertOrUpdateClass($data){
        try {
            for ($i=0; $i < count($data['classes']); $i++) { 
               $data['pid'] = public_id();
               $data['class'] = $data['classes'][$i];
               $data['class_number'] = $data['number'][$i];
               Classes::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
            }
            return true;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }
    public function createClassArm(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'arm' => 'required|array|min:1',
            'arm_number' => 'required|array|min:1',
            'class_pid' => 'required',
        ],[
            'class_pid.required' => 'select school category',
            'arm.required' => 'Enter class Arm e.g grade 1 a for grade 1 & jss 1 a for jss 1',
            'arm.max' => 'Maxismum of 25 character',
            'arm.min' => 'Minimum of 3 character',
        ]);
        if(!$validator->fails()){
            $data = [
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid(),
                'arms' => $request->arm,
                'numbers' => $request->arm_number,
                'class_pid' => $request->class_pid,
                'className'=> $request->prepend ? self::getClassNameByPid($request->class_pid).' ' : ' ',
            ];
            $result = $this->insertOrUpdateClassArm($data);
            if ($result) {
                $msg = 'Class arm created successfully';
                if(isset($request->pid)){
                    $msg = 'Class arm updated successfully';
                }
                return response()->json(['status'=>1,'message'=> $msg]);
            }
            return response()->json(['status'=>'error','message'=> 'Operation Failed']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function insertOrUpdateClassArm($data){
        // try {
            $count = count($data['arms']);
            for ($i=0; $i < $count; $i++) { 
                if(empty($data['arms'][$i])){
                    continue;
                }
                $data['pid']=public_id();
                $data['arm']=$data['className'].$data['arms'][$i];
                $data['arm_number']=$data['numbers'][$i];
                ClassArm::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
            }
            return true;
        // } catch (\Throwable $e) {
        //     $error = $e->getMessage();
        //     logError($error);
        // }
    }
    
    public function createClassArmSubject(Request $request){
       $validator = Validator::make($request->all(),[
                        'category_pid'=>'required',
                        'class_pid'=>'required',
                        'arm_pid'=>'required',
                        'subject_pid'=> 'required',
                        'session_pid'=> 'required',
       ],[
            'category_pid.required'=>'Select Category',
            'class_pid.required'=>'Select Class',
            'arm_pid.required'=>'Select Class Arm',
            'subject_pid.required'=>'Select one subject at least',
            'session_pid.required'=>'Select Session',
        ]);
            
        if(!$validator->fails()){
            $data = [
                'session_pid'=>$request->session_pid,
                'sid'=>$request->subject_pid,
                'arm_pid'=>$request->arm_pid,
                'school_pid'=>getSchoolPid(),
                'staff_pid'=>getSchoolUserPid(),
            ];
            $result = $this->updateOrcreateArmSubject($data);
            if($result){
                return response()->json(['status'=>1,'message'=>'Class Subject Created successfully!!!']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }

    private function updateOrcreateArmSubject($data){
        try {
            $r = false;
            $dupParams = 
            ['school_pid' => $data['school_pid'],
                        // 'subject_pid' => $data['subject_pid'],
                        'session_pid' => $data['session_pid'],
                        'arm_pid' => $data['arm_pid'],
                    ];
                    // $sid = (array) ;
                    foreach($data['sid'] as $pid){
                        $data['subject_pid'] = $dupParams['subject_pid'] = $pid;
                        $data['pid']=public_id();
                       $r = ClassArmSubject::updateOrCreate($dupParams, $data);
                    }
                    return $r;

        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    public static function GetClassArmSubjectType($class_subject){
        $subject_type = ClassArmSubject::join('subjects','subjects.pid','class_arm_subjects.subject_pid')
                            ->where(['subjects.school_pid'=>getSchoolPid(),'class_arm_subjects.pid'=> $class_subject])
                            ->pluck('subject_type_pid')->first();
        return $subject_type;
    }
    public static function GetClassSubjectAndName($class_subject){
        $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
            ->join('subjects', 'subjects.pid', 'subject_pid')
            ->where(['class_arms.school_pid' => getSchoolPid(), 'class_arm_subjects.pid' => $class_subject])
            ->first(['arm','subject']); 
        return $result;
    }

    public static function getClassNameByPid($pid){
        $class = Classes::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('class')->first();

        return $class;
    }
    public static function getClassArmNameByPid($pid){
        $arm = ClassArm::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('arm')->first();

        return $arm;
    }
    // public function assignClassArmSubjectToTeacher(Request $request){

    // }
}
