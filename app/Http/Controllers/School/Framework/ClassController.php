<?php

namespace App\Http\Controllers\School\Framework;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\StaffClass;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\ClassArmSubject;
use App\Models\School\Student\Result\StudentClassScoreParam;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function loadCategory()
    {
        $data = Category::where(['school_pid' => getSchoolPid()])
            ->get(['pid', 'category', 'created_at', 'description']);
        return datatables($data)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->addColumn('action', function ($data) {
                return view('school.framework.class.category-action-buttons', ['data' => $data]);
            })
            ->make(true);
        
    }
    public function loadCategoryByPid(Request $request)
    {
        $data = Category::where(['school_pid'=>getSchoolPid(),'pid'=>base64Decode($request->pid)])
                        ->first(['category', 'description','pid']);
        return response()->json($data);   
    }


    public function loadClasses()
    {
        $data = Classes::join('categories', 'categories.pid', 'classes.category_pid')
        ->where(['classes.school_pid' => getSchoolPid()])
            ->get(['classes.pid', 'category', 'classes.created_at', 'class', 'classes.status', 'classes.category_pid','class_number']);
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
        $data = ClassArm::from('class_arms as a')->join('classes as c', 'c.pid', 'a.class_pid')
        // ->leftjoin('staff_classes as f', 'f.arm_pid', 'a.pid')
        // ->leftjoin('school_staff as s', 's.pid', 'f.teacher_pid')
        // ->join('user_details as d', 'd.user_pid', 's.user_pid')
        ->where(['a.school_pid' => getSchoolPid()])->orderBy('arm') //->distinct('arm')
            ->get(['a.pid', 'class','arm', 'a.created_at', 'a.status',
            // 'fullname',
            'arm_number','category_pid','class_pid']);
        return datatables($data)
            ->addColumn('action', function ($data) {
                return view('school.framework.class.class-arm-action-buttons', ['data' => $data]);
            })
            // ->editColumn('created_at', function ($data) {
            //     return $data->created_at->diffForHumans();
            // })
            // ->editColumn('status', function ($data) {
            //     return $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
            //     // return $html;
            // })
            ->addIndexColumn()
            // ->rawColumns(['data', 'status'])
            ->make(true);
    }
    public function loadClassArmSubject(Request $request)
    {
        if(isset($request->param)){
            $where =['class_arm_subjects.school_pid' => getSchoolPid(), 'arm_pid' => $request->param];
        }else{
            $where = ['class_arm_subjects.school_pid' => getSchoolPid()];
        }
        $data = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
        ->join('subjects', 'subjects.pid', 'subject_pid')
        // ->join('sessions', 'sessions.pid', 'session_pid')
        // ->join('school_staff', 'school_staff.pid', 'class_arm_subjects.staff_pid')
        // ->leftjoin('user_details', 'user_details.user_pid', 'school_staff.user_pid')
        ->where($where)
            ->get([
                    'class_arm_subjects.pid','arm','subject', 
                    'class_arm_subjects.created_at', 'class_arm_subjects.status']);
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
            ->addIndexColumn()
            ->rawColumns(['data', 'status'])
            ->make(true);
    }
    
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category' => ['required',Rule::unique('categories')->where(function($param)use ($request){
                $param->where('school_pid','=',getSchoolPid())->where('pid','!=',$request->pid);
            })],
            // 'head_pid'=>'required'
        ],[
            'head_pid.required'=>'Select Category Head or Principal',
            'category.unique'=>$request->category. ' Category Already exists',
        ]);
        if(!$validator->fails()){
            $data = [
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid(),
                    'pid' => $request->pid ?? public_id(),
                    'category' => $request->category,
                    'head_pid' => $request->head_pid ?? 'null',
                    'description' => $request->description
                ];
            $result = $this->insertOrUpdateCategory($data);
            if ($result) {
                $msg = 'New School Category created successfully';
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
            $error = ['error' => $e->getMessage(), 'file' => __FILE__,'line' => __LINE__];
            logError($error);
            return false;
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
                'pids' => $request->pid,
                'category_pid' => $request->category_pid,
            ];

            $result = $this->prepareClassData($data);
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

    public function updateClass(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_pid' => 'required',
                'class' => [
                    'required',
                Rule::unique('classes')->where(function ($param) use ($request) {
                    $param->where('pid', '<>', $request->pid)->where('school_pid',getSchoolPid());
                })
            ],
            'class_number' => 'required']
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
                'pids' => $request->pid,
                'classes' => $request->class,
                'category_pid' => $request->category_pid,
            ];
            $result = $this->prepareClassData($data);
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

    private function prepareClassData($data){
        try {
            $count = count($data['classes']);
            for ($i=0; $i < $count; $i++) {
                if (empty($data['classes'][$i]) || empty($data['number'][$i])) {
                    continue;
                }
               $data['pid'] = $data['pids'][$i] ?? public_id();
               $data['class'] = $data['classes'][$i];
               $data['class_number'] = $data['number'][$i];
                $this->updateOrCreateClass($data);
            }
            return true;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    private function updateOrCreateClass($data){
        try {
            return Classes::updateOrCreate(['school_pid' => $data['school_pid'], 'pid' => $data['pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
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
                'className'=> $request->prepend ? self::getClassNameByPid($request->class_pid).' ' : '',
            ];
            $result = $this->updateOrCreaateClassArm($data);
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

    private function updateOrCreaateClassArm($data){
        try {
            $count = count($data['arms']);
            for ($i=0; $i < $count; $i++) { 
                if(empty($data['arms'][$i])|| empty($data['numbers'][$i])){
                    continue;
                }
                $data['pid']=public_id();
                $data['arm']=$data['className'].$data['arms'][$i];
                $data['arm_number']=$data['numbers'][$i];
                ClassArm::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
            }
            return true;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    
    public function createClassArmSubject(Request $request){
       $validator = Validator::make($request->all(),[
                        'category_pid'=>'required',
                        'class_pid'=>'required',
                        'arm_pid'=>'required',
                        'subject_pid'=> 'required',
                        // 'session_pid'=> 'required',
       ],[
            'category_pid.required'=>'Select Category',
            'class_pid.required'=>'Select Class',
            'arm_pid.required'=>'Select Class Arm at least',
            'subject_pid.required'=>'Select one subject at least',
            // 'session_pid.required'=>'Select Session',
        ]);
            
        if(!$validator->fails()){
            $data = [
                'session_pid'=>$request->session_pid,
                'sid'=>$request->subject_pid,
                // 'arm_pid'=>$request->arm_pid,
                'school_pid'=>getSchoolPid(),
                'staff_pid'=>getSchoolUserPid(),
                'session_pid'=>activeSession(),
            ];
            foreach($request->arm_pid as $arm){
                $data['arm_pid'] = $arm;
                $result = $this->updateOrCreateArmSubject($data);
            }
            if($result){
                return response()->json(['status'=>1,'message'=>'Class Subject Created successfully!!!']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }

    private function updateOrCreateArmSubject($data){
        try {

                    $dupParams = $data ;
                    unset($dupParams['sid']);
                    $dataArray = $dupParams;
                    unset($dupParams['staff_pid']);
        // $sid = (array) ;
                    $datas = [];
                    foreach($data['sid'] as $pid){
                       $dupParams['subject_pid'] = $pid;
                        $id = ClassArmSubject::where($dupParams)->first('id');
                        if(!$id){
                            $dataArray['pid']=public_id();
                            $dataArray['subject_pid'] =  $pid;//
                            $dataArray['updated_at'] = $dataArray['created_at'] = date('Y-m-d H:i:s');
                            $datas[] = $dataArray;
                        }
                    }
                    
                return ClassArmSubject::insert($datas);

        } catch (\Throwable $e) {
            $error =  $e->getMessage();
            logError($error);
        }
    }

    public static function GetClassArmSubjectType($class_subject){
        $data =   DB::table('class_arm_subjects as c')->join('subjects as s','s.pid','c.subject_pid')
                                            ->join('subject_types as t','t.pid', 's.subject_type_pid')
                                            ->where(['s.school_pid'=>getSchoolPid(),'c.pid'=> $class_subject])
                                            ->first(['s.subject', 's.subject_type_pid', 't.subject_type']);
        return $data;
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

    // public static function getClassSubjectByPid($pid){
    //     $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
    //         ->join('subjects', 'subjects.pid', 'subject_pid')
    //         ->where(['class_arms.school_pid' => getSchoolPid(), 'class_arm_subjects.pid' => $pid])
    //         ->first(['arm', 'subject']);
    //     return $result;
    // }
    public static function createClassParam(array $data)
    {
        // $teacher = $data['teacher_pid'];
        // unset($data['teacher_pid']);// class tec
        $pid = StudentClassScoreParam::where($data)->pluck('pid')->first();//check if param already created
        if ($pid) {
            return $pid;
        }
        $teacher = self::getClassTeacherPid(session: $data['session_pid'],term: $data['term_pid'],arm: $data['arm_pid']);
        $data['teacher_pid'] = self::getClassTeacherPid(session: $data['session_pid'],term: $data['term_pid'],arm: $data['arm_pid']);
        if($teacher){
            $data['teacher_pid'] = $teacher->teacher_pid;
            $data['teacher_name'] = $teacher->fullname;
            $data['principal_pid'] = self::getCategoryHeadPid($data['arm_pid']);
            $data['pid'] = public_id();
            $data['term'] = termName($data['term_pid']) ;
            $data['session'] = sessionName($data['session_pid']);
            $data['arm'] = getClassArmNameByPid($data['arm_pid']);
            $result = StudentClassScoreParam::create($data); // create class param
            return $result->pid;
        }
        return false;
    }
    public static function getClassTeacherPid($arm,$session,$term){
        try {
           $data = DB::table('staff_classes as c')->join('school_staff as s', 's.pid', 'c.teacher_pid')
                                                ->join('user_details as d', 'd.user_pid', 's.user_pid')
                                        ->where([
                                            'c.arm_pid' => $arm,
                                            'c.session_pid' => $session,
                                            'c.term_pid' => $term,
                                            'c.school_pid' => getSchoolPid()
                                        ])->first(['teacher_pid', 'fullname']);
            return $data;
            // $pid = StaffClass::where([
            //         'arm_pid' => $arm,
            //         'session_pid' => $session,
            //         'term_pid' => $term,
            //         'school_pid' => getSchoolPid()
            //     ])->pluck('teacher_pid')->first();
            // return $pid;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    public static function getCategoryHeadPid($arm){
       $pid = DB::table('class_arms as a')
                ->join('classes as c','c.pid','a.class_pid')
                ->join('categories as cg','cg.pid','c.category_pid')
                ->where(['a.pid'=>$arm,'a.school_pid'=>getSchoolPid()])->pluck('head_pid')->first();
        return $pid;
    }

    // load class arms 
    public static function loadAllClassArms(){
        $arms = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1])->get(['pid', 'arm']);
        return $arms;
    }

}
