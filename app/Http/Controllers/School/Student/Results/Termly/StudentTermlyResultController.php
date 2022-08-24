<?php

namespace App\Http\Controllers\School\Student\Results\Termly;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Models\School\Student\Result\StudentClassScoreParam;

class StudentTermlyResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loadStudentResult(Request $request){
        session(['viewResultParam' => [
            'school_pid' => getSchoolPid(),
            'session_pid' => $request->session,
            'term_pid' => $request->term,
            'arm_pid' => $request->arm,
        ]]);
        return redirect()->route('view.student.result');
    }

    public function studentResult(){
        $result = $this->studentResultParams();
        $data = $result['data'];
        $class = $result['class'];
        return view('school.student.result.termly-result.view-termly-result', compact('data', 'class'));
    }

    private function studentResultParams(){
        
        $data = session('viewResultParam');
        $class = DB::table('student_class_score_params')->where($data)->select('pid');
        $rank = DB::table('student_class_results as r')->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
            ->joinSub($class, 'class', function ($sub) {
                $sub->on('r.class_param_pid', '=', 'class.pid');
            })->select(DB::raw('r.student_pid,r.total,r.class_param_pid,
                                class_teacher_comment,principal_comment,portal_comment,
                                COUNT(DISTINCT(subject_type)) AS count,
                                r.total/COUNT(DISTINCT(subject_type)) AS average,
                                RANK() OVER (ORDER BY r.total DESC) AS position'))
            ->groupBy('r.student_pid')
            ->groupBy('r.class_param_pid');

        $result = DB::table('students as s')->joinSub($rank, 'rank', function ($sub) {
            $sub->on('s.pid', '=', 'rank.student_pid');
        })->select(
            'reg_number',
            'fullname',
            'position',
            'total',
            'student_pid',
            'class_teacher_comment',
            'principal_comment',
            'portal_comment',
            'average',
            'count'
        )->get();
        $className = ClassController::getClassArmNameByPid($data['arm_pid']);
        return [
            'class'=>$className,
            'data'=>$result
        ];
    }
}
