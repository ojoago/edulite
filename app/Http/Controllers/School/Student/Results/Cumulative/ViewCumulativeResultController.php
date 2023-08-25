<?php

namespace App\Http\Controllers\School\Student\Results\Cumulative;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Framework\ClassController;

class ViewCumulativeResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadStudentCumulativeResult(Request $request)
    {
        $data = [
            'school_pid' => getSchoolPid(),
            'session_pid' => $request->session,
            // 'term_pid' => $request->term,
            'arm_pid' => $request->arm,
        ];
        $class = DB::table('student_class_score_params')->where($data)->select('pid', 'session_pid');
        // $param = StudentClassScoreParam::where($data)->pluck('pid')->first();
        $rank = DB::table('student_class_results as r')->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
        ->joinSub($class, 'class', function ($sub) {
            $sub->on('r.class_param_pid', '=', 'class.pid');
        })->select(DB::raw('r.student_pid,AVG(r.total) AS total,COUNT(DISTINCT(r.class_param_pid)) AS terms,
                                RANK() OVER (ORDER BY AVG(r.total) DESC) AS position'))
        ->groupBy('r.student_pid')->get()->dd();
        // ->groupBy('class.session_pid')->get()->dd();

        $result = DB::table('students as s')->joinSub($rank, 'rank', function ($sub) {
            $sub->on('s.pid', '=', 'rank.student_pid');
        })->select(
            'reg_number',
            'fullname',
            'position',
            'terms',
            'total',
            'student_pid',
            'session_pid',
        )->get();
        $className = ClassController::getClassArmNameByPid($data['arm_pid']);
        $session = [
            'session'=>sessionName($data['session_pid']),
            'class'=>$className
        ];
        return view('school.student.result.cumulative.cumulative-result',compact('result', 'session'));
    }




    public function studentCumulativeReportCard($session, $spid)
    { //class param & student pid
        $result = DB::table('student_class_score_params as p')
                    ->join('student_class_results as r','p.pid','r.class_param_pid')
                    ->join('terms as t','t.pid', 'p.term_pid')
                    ->where([
                        'p.session_pid'=>$session,
                        'r.student_pid'=>$spid,
                        'r.school_pid'=>getSchoolPid(),
                        'p.school_pid'=>getSchoolPid()
                        ])->select(DB::raw('total,class_param_pid,student_pid,session_pid,term'))->orderBy('p.id')->get();//->dd();
        $sub = DB::table('student_class_score_params as p')
                    ->join('student_class_results as r','p.pid','r.class_param_pid')
                    ->join('terms as t','t.pid', 'p.term_pid')
                    ->where([
                        'p.session_pid'=>$session,
                        'r.student_pid'=>$spid,
                        'r.school_pid'=>getSchoolPid(),
                        'p.school_pid'=>getSchoolPid()
                        ])->select(DB::raw('class_param_pid,student_pid,session_pid'))->orderBy('p.id');//->get()->dd();

        $subjects = DB::table('student_subject_results as sr')
                        ->join('subject_types AS s','s.pid','sr.subject_type')
                        ->joinSub($sub, 'sub', function ($sb) {
                            $sb->on('sub.class_param_pid', '=', 'sr.class_param_pid');
                        })->where([
                            'sr.student_pid' => $spid,
                            'sr.school_pid' => getSchoolPid()
                        ])->select(DB::raw('DISTINCT(s.subject_type) AS subject,s.pid AS type'))
                        ->get();

        return view('school.student.result.cumulative.student-cumulative-report-card', compact('result', 'subjects'));

    }
}
