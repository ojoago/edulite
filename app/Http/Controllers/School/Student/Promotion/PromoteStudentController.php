<?php

namespace App\Http\Controllers\School\Student\Promotion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Student\Student;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Class\SwapClassHistory;
use Illuminate\Support\Facades\Validator;

class PromoteStudentController extends Controller
{
    public function __construct(){
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

   public function loadStudent(Request $request){

    // dd($request->all());
        try {
            $nextClass = Classes::where([
                'school_pid' => getSchoolPid(),
                'category_pid' => $request->category,
                'status' => 1
            ])->get(['pid', 'class', 'class_number']);
            //$carm = $request->class;
            $armNumber = ClassArm::where(['school_pid' => getSchoolPid(), 'pid' => $request->arm])->pluck('arm_number')->first();
            $currentClassNumber = Classes::where(['school_pid' => getSchoolPid(), 'pid' => $request->class])->pluck('class_number')->first();
            $nextArm = DB::table('classes as c')->join('class_arms as a', 'class_pid', 'c.pid')
                ->select('a.arm', 'a.pid', 'a.arm_number')
                ->where([
                    'c.school_pid' => getSchoolPid(),
                    'c.category_pid' => $request->category,
                    'c.class_number' => $currentClassNumber + 1,
                    'a.status' => 1
                ])
                // ->where('c.class_number',function($query) use($carm){
                //     $query->where('c.pid');
                // })
                ->get();
            // Classes::join('class_arms','class_pid','classes.pid')->where(['classes.school_pid'=>getSchoolPid(), 'classes.category_pid' => $request->category, 'classes.class_number'=>$cll+1])->get()->dd();
            // dd($cll);
            // ClassArm::where('',function($query){})->get();
            // Model::where(function ($query) {
            //     $query->where('a', '=', 1)
            //     ->orWhere('b', '=', 1);
            // })->where(function ($query) {
            //     $query->where('c', '=', 1)
            //     ->orWhere('d', '=', 1);
            // });
            // $arms = ClassArm::where(['school_pid'=>getSchoolPid(),'class_pid'=>$request->class, 'status' => 1])->get(['arm_number', 'pid', 'arm'])->dd();
            // ClassArm::join('classes','classes.pid','class_pid')->where(['classes.school_pid'=>getSchoolPid(), 'class_arms.pid'=>$request->arm])->get()->dd();
            $className = getClassArmNameByPid($request->arm);
            $students = Student::where(['current_class_pid' => $request->arm])->get(['pid', 'reg_number', 'fullname', 'passport', 'current_class_pid']);
            return view('school.student.promotion.promote-student', compact('students', 'nextClass', 'armNumber', 'currentClassNumber', 'nextArm', 'className'));
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return redirect()->back()->with('warning',ER_500);
        }
   }


   public function promoteStudent(Request $request){
        try{
            $count = count($request->pid);
            $session = Student::where(['school_pid' => getSchoolPid(), 'pid' => $request['pid'][0]])->pluck('current_session_pid')->first();
            if ($session == activeSession()) {
                return redirect()->back()->with('warning', 'Contact Admin to change Session from '. activeSessionName() .' to the current year');
            }
            for ($i = 0; $i < $count; $i++) {
                if (!isset($request['next_class'][$i])) {
                    continue;
                }
                $data = ['student_pid' => $request['pid'][$i], 'arm' => $request['next_class'][$i]];
                $result = $this->moveStudent($data);
            }
            if($result){
                return redirect()->back()->with('success','Student promoted successfully...');
            }
            return redirect()->back()->with('warning','Something Went Wrong...');
        }catch(\Throwable $e){
            logError($e->getMessage());
            return redirect()->back()->with('error','Something Went Wrong... error log');
        }
   }


//    swap 

   public function loadStudentByArm(Request $request){
        $data = DB::table('students as s')->join('class_arms as a','a.pid', 's.current_class_pid')
                        ->where(['s.current_class_pid' => $request->arm,'s.school_pid'=>getSchoolPid()])
                        ->get(['s.pid', 's.reg_number', 's.fullname', 's.passport', 'a.arm']);
        $className = getClassArmNameByPid($request->arm);
        return view('school.student.promotion.swap-student',compact('data', 'className'));
   }

   public function swapStudent(Request $request){
        $validator = Validator::make($request->all(),[
            'category'=>'required',
            'class'=>'required',
            'arm'=>'required',
        ]);
        if(!$validator->fails()){
            try{
                $data = ['student_pid'=>$request->pid,'arm'=>$request->arm];
                $this->moveStudent($data);
                return response(['status' => 1, 'message' => 'Student Swap']);
            }catch(\Throwable $e){
                logError($e->getMessage());
                return response(['status'=>'error','message'=>'Something Went Wrong... error log']);
            }
        }
        return response(['status'=>0,'message'=>'fill the form correctly','error'=>$validator->errors()->toArray()]);
   }

   private function moveStudent(array $data){
        try{
            $student = Student::where(['school_pid' => getSchoolPid(), 'pid' => $data['student_pid']])->first();
            if ($student) {
                $history = [
                    'school_pid' => getSchoolPid(),
                    'student_pid' => $data['student_pid'],
                    'new_class' => $data['arm'],
                    'previus_class' => $student->current_class_pid,
                    'session_pid' => activeSession(),
                    'term_pid' => activeTerm(),
                    'created_by' => getSchoolUserPid()
                ];
                $student->current_class_pid = $data['arm'];
                $student->current_session_pid = activeSession();
                $result = $student->save();
                if ($result) {
                    return $this->saveHistory($history);
                }
                return false;
            }
            return false;
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }
   }

   private function saveHistory(array $data){
        try{
            return SwapClassHistory::create($data);
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }
   }

}
