<?php

namespace App\Http\Controllers\School\Student\Results\Cumulative;

use Illuminate\Http\Request;
use App\Models\School\School;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;

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
        Cache::add($request->arm,$data);

        return redirect()->route('view.class.cumulative.result',['key'=> $request->arm]);


        $class = DB::table('student_class_score_params')->where($data)->pluck('pid')->first();
        $dtl = DB::table('student_class_results as r')
        ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
        ->join('students as s', 's.pid', 'r.student_pid')
        ->select(DB::raw('distinct(r.student_pid),reg_number,fullname,
                                        class_teacher_comment,principal_comment,
                                        portal_comment,r.class_param_pid,r.total'))
        ->where('r.class_param_pid', $class); //->get()->dd();
        $rank = DB::table('student_class_results as r')
        ->joinSub($dtl, 'dtl', function ($dt) {
            $dt->on('r.student_pid', '=', 'dtl.student_pid');
        })->select(DB::raw('r.student_pid,r.total,
                                RANK() OVER (ORDER BY r.total DESC) AS position,
                                reg_number,fullname,
                                dtl.class_teacher_comment,dtl.principal_comment,
                                dtl.portal_comment,r.class_param_pid'))
        ->groupBy('r.student_pid')
        ->orderBy('r.total', 'DESC')
        ->groupBy('r.total')
        ->where(['r.class_param_pid' => $class]); //->get()->dd();
        $result = DB::table('student_subject_results as sr')->joinSub($rank, 'rn', function ($rank) {
            $rank->on('sr.student_pid', '=', 'rn.student_pid');
        })->select(DB::raw(
            'COUNT(subject_type) as count,
            rn.total/COUNT(subject_type) as average,
            rn.total,position,
            rn.student_pid,reg_number,
            fullname,rn.class_teacher_comment,
            rn.principal_comment,rn.portal_comment,
            rn.class_param_pid
            '
        ))->groupBy('sr.student_pid')->orderBy('position')
        ->where(['sr.class_param_pid' => $class, 'seated' => 1])->get(); //->dd();
        $className = ClassController::getClassArmNameByPid($data['arm_pid']);
        return [
            'class' => $className,
            'data' => $result,
            // 'param' => $param
        ];
    
    }

    public function loadClassCumulativeResult(Request $request){

        $data = Cache::get($request->key);
        $rank = DB::table('student_class_results as r')->join('student_class_score_params as p','p.pid', 'r.class_param_pid')
                    ->where(['p.school_pid'=>getSchoolPid(),'p.session_pid'=>$data['session_pid'],'arm_pid'=>$data['arm_pid']])
                    ->select(DB::raw('r.student_pid,AVG(r.total) AS total,COUNT(DISTINCT(r.class_param_pid)) AS terms,RANK() OVER (ORDER BY AVG(r.total) DESC) AS position'))
        ->groupBy('r.student_pid')
        ->groupBy('p.session_pid');
        $result = DB::table('students as s')->joinSub($rank, 'rank', function ($sub) {
            $sub->on('s.pid', '=', 'rank.student_pid');
        })->select(
            'reg_number','fullname','position','terms','total','student_pid','session_pid',
        )->get();
        $className = ClassController::getClassArmNameByPid($data['arm_pid']);
        $session = [
            'session' => sessionName($data['session_pid']),
            'class' => $className
        ];
        return view('school.student.result.cumulative.cumulative-result', compact('result', 'session'));

    }



    public function studentCumulativeReportCard($session, $spid)
    { //class param & student pid

        $arm_pid = DB::table('student_class_results as r')->join('student_class_score_params as p', 'p.pid', 'r.class_param_pid')
        ->where(['p.school_pid' => getSchoolPid(), 'p.session_pid' => $session, 'r.student_pid' => $spid])->pluck('arm_pid')->first();

        $rank = DB::table('student_class_results as r')
        ->join('student_class_score_params as p', 'p.pid', 'r.class_param_pid')
        ->join('class_arms as a', 'a.pid', 'p.arm_pid')
        ->join('sessions as s', 's.pid', 'p.session_pid')
        ->where(['p.school_pid' => getSchoolPid(), 'p.session_pid' => $session, 'arm_pid' => $arm_pid])
        ->select(DB::raw('s.session,a.arm,p.session_pid,r.student_pid,AVG(r.total) AS total,COUNT(DISTINCT(r.class_param_pid)) AS terms,RANK() OVER (ORDER BY AVG(r.total) DESC) AS position'))
        ->groupBy('r.student_pid')
        ->groupBy('p.session_pid')
        ->groupBy('a.arm')
        ->groupBy('s.session');
        $result = DB::table('students as s')->joinSub($rank, 'rank', function ($sub) {
            $sub->on('s.pid', '=', 'rank.student_pid');
        })->leftjoin('attendance_records as ar', function ($join) {
            $join->on('rank.session_pid', 'ar.session_pid');
        })->leftjoin('attendances as an', 'an.record_pid', 'ar.pid')
            ->select(DB::raw("reg_number,fullname,position,terms,total,arm,session,
                                COUNT(CASE WHEN an.status = 1 THEN 'present' END) as 'present',
                                COUNT(CASE WHEN an.status = 2 THEN 'excused' END) as 'excused',
                                    COUNT(CASE WHEN an.status = 0 THEN 'absent' END) as 'absent'
                                    "))
       ->where(['s.pid' => $spid])->groupBy('an.student_pid')->first();
// dd($result);
        $subjectResults = [];
        $scoreSettings = [];
        $params = DB::table('student_class_results as r')->join('student_class_score_params as p', 'p.pid', 'r.class_param_pid')->join('terms as t','t.pid','p.term_pid')
            ->where(['p.school_pid' => getSchoolPid(), 'p.session_pid' => $session, 'arm_pid' => $arm_pid,'student_pid'=>$spid])->orderBy('p.created_at')->select('term','p.pid')->get();//->dd();
            foreach($params as $pm):
                $param = $pm->pid;
                $scoreSettings[] = ScoreSettingsController::loadClassScoreSettings($param);

            $subdtl = DB::table('student_subject_results as sr')
            // the next 4 joins bring subject teahcer name 
            ->leftjoin('subject_score_params AS ssp', 'ssp.class_param_pid', 'sr.class_param_pid')
            ->leftjoin('subject_totals AS st', 'ssp.pid', 'st.subject_param_pid')
            ->leftjoin('school_staff AS stf', 'ssp.subject_teacher', 'stf.pid')
            ->leftjoin('user_details AS d', 'd.user_pid', 'stf.user_pid')
            // end of subject teacher name join 
            ->join('subject_types AS s', 's.pid', 'sr.subject_type')
            ->where([
                'sr.class_param_pid' => $param,
                'sr.school_pid' => getSchoolPid()
            ])->select(DB::raw('sr.subject_type,s.subject_type as subject,MIN(sr.total) AS min, 
                                        MAX(sr.total) AS max, AVG(sr.total) AS avg, SUM(sr.total) AS subTotal,d.fullname as subject_teacher')) // subTotal is the sum of all student score for eacher subject 
            ->groupBy('sr.subject_type')
            ->groupBy('d.fullname')
                ->groupBy('s.subject_type'); //->get()->dd();
            $subRank = DB::table('student_subject_results as sr')->joinSub($subdtl, 'd', function ($d) {
                $d->on('sr.subject_type', '=', 'd.subject_type');
            })
                ->where([
                    'sr.class_param_pid' => $param,
                    'sr.school_pid' => getSchoolPid()
                ])
                ->select(DB::raw('total, sr.subject_type AS type,sr.student_pid,min,max,avg,subTotal,subject,
                                    RANK() OVER (PARTITION BY sr.subject_type ORDER BY total DESC) AS position,d.subject_teacher
                                    '))
                ->groupBy('sr.subject_type')
                ->groupBy('sr.student_pid')
                ->groupBy('d.subject')
                ->groupBy('d.min')
                ->groupBy('d.max')
                ->groupBy('d.avg')
                ->groupBy('d.subTotal')
                ->groupBy('d.subject_teacher')
                ->groupBy('total');
            $subResult = DB::table('student_subject_results as sr')
            ->joinSub($subRank, 'sub', function ($sub) {
                $sub->on('sr.subject_type', '=', 'sub.type');
            })
                ->where([
                    'sr.class_param_pid' => $param,
                    'sr.school_pid' => getSchoolPid(),
                    'sub.student_pid' => $spid,
                ])
                ->select('sub.*', 'sr.class_param_pid')
                ->groupBy('sr.subject_type')
                ->get();
                 $subjectResults[] = $subResult;
            endforeach;
            // dd($subjectResults, $scoreSettings);
        $school = School::where('pid',getSchoolPid())->first(['school_email', 'school_website', 'school_logo', 'school_moto', 'school_address', 'school_contact']);
        $std = StudentController::studentName($spid);
        $grades = DB::table('grade_keys AS g')->where('class_param_pid', $param)->get(['grade', 'title', 'min_score', 'max_score']);
        return view('school.student.result.cumulative.student-cumulative-report-card', compact('result', 'subjectResults', 'scoreSettings','school','std', 'params', 'grades'));

    }
}
