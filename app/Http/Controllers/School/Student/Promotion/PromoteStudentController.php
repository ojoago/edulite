<?php

namespace App\Http\Controllers\School\Student\Promotion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Student\Student;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\Classes;

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
    $nextClass = Classes::where([
                    'school_pid'=>getSchoolPid(),
                    'category_pid'=>$request->category,
                    'status'=>1
                    ])->get(['pid', 'class', 'class_number']);
    //$carm = $request->class;
    $armNumber = ClassArm::where(['school_pid'=>getSchoolPid(),'pid'=>$request->arm])->pluck('arm_number')->first();
    $currentClassNumber = Classes::where(['school_pid'=>getSchoolPid(),'pid'=>$request->class])->pluck('class_number')->first();
    $nextArm = DB::table('classes as c')->join('class_arms as a','class_pid','c.pid')
                            ->select('a.arm', 'a.pid','a.arm_number')
                            ->where([
                                'c.school_pid' => getSchoolPid(), 
                                'c.category_pid' => $request->category, 
                                'c.class_number' => $currentClassNumber + 1,
                                'a.status'=>1
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
       $student = Student::where(['current_class_pid'=>$request->arm])->get(['pid', 'reg_number', 'fullname', 'passport', 'current_class_pid']);

    return view('school.student.promotion.promote-student',
                compact(
                    'student',
                    'nextClass',
                    'armNumber',
                    'currentClassNumber',
                    'nextArm'
                ));
   }


   public function promoteStudent(Request $request){
    dd($request->all());
   }


//    swap 

   public function loadStudentByArm(Request $request){
        $data = DB::table('students as s')->join('class_arms as a','a.pid', 's.current_class_pid')
                        ->where(['s.current_class_pid' => $request->arm,'s.school_pid'=>getSchoolPid()])
                        ->get(['s.pid', 's.reg_number', 's.fullname', 's.passport', 'a.arm']);
        return view('school.student.promotion.swap-student',compact('data'));
   }

}
