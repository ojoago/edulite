<?php

namespace App\Http\Controllers\School\Student\Results\Termly;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Framework\Psychomotor\PsychomotorBase;
use App\Models\School\School;
use App\Models\School\Student\Result\StudentClassScoreParam;

class StudentTermlyResultController extends Controller
{

    public function loadStudentResult(Request $request)
    {
        session(['viewResultParam' => [
            'school_pid' => getSchoolPid(),
            'session_pid' => $request->session,
            'term_pid' => $request->term,
            'arm_pid' => $request->arm,
        ]]);
        return redirect()->route('view.student.result');
    }

    public function classResult()
    {
        $data = session('viewResultParam');
        $result = self::studentResultParams($data);
        $data = $result['data'];
        $class = $result['class'];
        // $param = $result['param'];
        return view('school.student.result.termly-result.view-termly-result', compact('data', 'class',));
    }

    public static function studentResultParams(array $data)
    {
        $class = DB::table('student_class_score_params')->where($data)->pluck('pid')->first();
        $dtl = DB::table('student_class_results as r')
                    ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
                    ->join('students as s','s.pid','r.student_pid')
                    ->select(DB::raw('distinct(r.student_pid),reg_number,fullname,
                                        class_teacher_comment,principal_comment,
                                        portal_comment,r.class_param_pid,r.total'))
                                        ->where('r.class_param_pid',$class); //->get()->dd();
        $rank = DB::table('student_class_results as r')
                ->joinSub($dtl,'dtl',function($dt){
                    $dt->on('r.student_pid','=','dtl.student_pid');
                })->select(DB::raw('r.student_pid,r.total,
                                RANK() OVER (ORDER BY r.total DESC) AS position,
                                reg_number,fullname,
                                dtl.class_teacher_comment,dtl.principal_comment,
                                dtl.portal_comment,r.class_param_pid'))
        ->groupBy('r.student_pid')
            ->orderBy('r.total', 'DESC')
            ->groupBy('r.total')
            ->where(['r.class_param_pid' => $class]);//->get()->dd();
        $result = DB::table('student_subject_results as sr')->joinSub($rank,'rn',function($rank){
            $rank->on('sr.student_pid','=','rn.student_pid');
        })->select(DB::raw(
            'COUNT(subject_type) as count,
            rn.total/COUNT(subject_type) as average,
            rn.total,position,
            rn.student_pid,reg_number,
            fullname,rn.class_teacher_comment,
            rn.principal_comment,rn.portal_comment,
            rn.class_param_pid
            '))->groupBy('sr.student_pid')->orderBy('position')
            ->where(['sr.class_param_pid' => $class, 'seated' => 1])->get();//->dd();
        $className = ClassController::getClassArmNameByPid($data['arm_pid']);
        return [
            'class' => $className,
            'data' => $result,
            // 'param' => $param
        ];
    }

    // a particular student result 
    public function studentReportCard($param,$spid){ //class param & student pid
        
        $classParam = StudentClassScoreParam::where('pid',$param)->first(['session_pid','term_pid','arm_pid']);
        // dd($classParam);
        // StudentScoreParam::join('student_score_sheets','score_param_pid','student_score_params.pid')->where('class_param_pid',$param)->get()->dd();
        if(!$classParam){

        }else{
            $scoreSettings = ScoreSettingsController::loadClassScoreSettings($param);
            $std = StudentController::studentName($spid);
            // query subject result 
            $subdtl = DB::table('student_subject_results as sr')
                        // the next 4 joins bring subject teahcer name 
                        ->join('student_score_params AS ssp', 'ssp.class_param_pid', 'sr.class_param_pid')
                        ->join('subject_totals AS st', 'ssp.pid', 'st.subject_param_pid')
                        ->join('school_staff AS stf', 'ssp.subject_teacher', 'stf.pid')
                        ->join('user_details AS d', 'd.user_pid', 'stf.user_pid')
                        // end of subject teacher name join 
                        ->join('subject_types AS s', 's.pid', 'sr.subject_type')
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid()
                        ])->select(DB::raw('sr.subject_type,s.subject_type as subject,MIN(sr.total) AS min, 
                                        MAX(sr.total) AS max, AVG(sr.total) AS avg, SUM(sr.total) AS subTotal,d.fullname as subject_teacher'))// subTotal is the sum of all student score for eacher subject 
                                  ->groupBy('sr.subject_type')
                                  ->groupBy('d.fullname')
                                  ->groupBy('s.subject_type');//->get()->dd();
            $subRank = DB::table('student_subject_results as sr')->joinSub($subdtl,'d',function($d){
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
            // $select = DB::table('student_subject_results as sr');
            // $ca = DB::table('student_score_params as ssp')
            //             ->join('student_score_sheets as sss','score_param_pid','ssp.pid')
            //             ->joinSub($strSub,'sb',function($sb){
            //                 $sb->on('ssp.subject_type','=','sb.subject_type');
            //             })
            //             ->select(DB::raw("ca_type_pid,sb.subject_type"))
            //             ->where(['class_param_pid'=> $param,'ssp.school_pid'=>getSchoolPid()])
            //             ->groupBy('ca_type_pid');//->get()->dd();//->toArray();
            // $value = DB::table('student_score_params as ssp')
            //             ->join('student_score_sheets as sss','score_param_pid','ssp.pid')
            //             ->joinSub($ca,'ca',function($sub){
            //                 $sub->on('ssp.subject_type','=','sb.subject_type');
            //             })
            //             ->select(DB::raw("MAX(CASE())"))
            //             ->where(['class_param_pid'=> $param,'ssp.school_pid'=>getSchoolPid()])
            //             ->groupBy('ca_type_pid')->get()->dd();

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
                ->get();//->dd();
            
            
            // query class result 
// individual student result and class position 
            $dtl = DB::table('student_class_results as r')
            ->join('student_class_score_params as p', 'p.pid', 'r.class_param_pid')
            ->join('school_staff as stf', 'stf.pid', 'p.principal_pid')
            ->join('user_details as d', 'd.user_pid', 'stf.user_pid')
            ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
            ->join('students as s', 's.pid', 'r.student_pid')
            ->select(DB::raw('distinct(r.student_pid),reg_number,s.fullname as student_name,type,
                                        class_teacher_comment,principal_comment,
                                        portal_comment,r.class_param_pid,r.total,d.fullname as principal,p.status as exam_status'))
            ->where('r.class_param_pid', $param);//->get()->dd();
            $rank = DB::table('student_class_results as r')
            ->joinSub($dtl, 'dtl', function ($dt) {
                $dt->on('r.student_pid', '=', 'dtl.student_pid');
            })->select(DB::raw('r.student_pid,r.total,
                                RANK() OVER (ORDER BY r.total DESC) AS position,
                                reg_number,student_name,type,
                                dtl.class_teacher_comment,dtl.principal_comment,
                                dtl.portal_comment,r.class_param_pid,principal,exam_status'))
            ->groupBy('r.student_pid')
            ->orderBy('r.total', 'DESC')
            ->groupBy('r.total')
            ->where(['r.class_param_pid' => $param]); //->get()->dd();
            $result = DB::table('student_subject_results as sr')->joinSub($rank, 'rn', function ($rank) {
                $rank->on('sr.student_pid', '=', 'rn.student_pid');
            })->select(DB::raw(
                'COUNT(subject_type) as count,
                rn.total/COUNT(subject_type) as average,
                rn.total,position,
                rn.student_pid,reg_number,type,
                student_name,rn.class_teacher_comment,
                rn.principal_comment,rn.portal_comment,
                rn.class_param_pid,principal,exam_status'))->groupBy('sr.student_pid')->orderBy('position')
            ->where(['sr.class_param_pid' => $param, 'seated' => 1]);//->get()->dd();
            $results = DB::table('student_class_results as r')
            ->join('student_class_score_params  as srp', 'srp.pid', 'r.class_param_pid')
            ->join('terms  as t', 't.pid', 'srp.term_pid')
            ->join('sessions  as s', 's.pid', 'srp.session_pid')
            ->join('class_arms  as a', 'a.pid', 'srp.arm_pid')
            ->join('school_staff  as st', 'st.pid', 'srp.teacher_pid')
            ->join('user_details  as d', 'd.user_pid', 'st.user_pid')
            ->join('active_term_details  as atm',function($join){
                $join->on('atm.term_pid','srp.term_pid')->on('atm.session_pid','srp.session_pid');
            })
            // ->leftJoin('attendances as ad','')
            ->joinSub($result,'rs',function($r){
                $r->on('r.student_pid','=', 'rs.student_pid');
            })->leftjoin('attendance_records as ar',function($join){
                $join->on('srp.term_pid', '=', 'ar.term_pid')->on('srp.session_pid', '=', 'ar.session_pid');
            })->leftjoin('attendances as an','an.record_pid','ar.pid')
            ->select(DB::raw("rs.*,d.fullname as class_teacher,st.signature,t.term,s.session,a.arm,atm.begin,atm.end,rs.student_pid,
                                COUNT(CASE WHEN an.status = 1 THEN 'present' END) as 'present',
                                    COUNT(CASE WHEN an.status = 0 THEN 'absent' END) as 'absent'
                                    "))
            ->where([
                'r.class_param_pid'=> $param,
                'rs.student_pid'=>$spid,
                // 'an.student_pid'=>$spid
                ])
            ->groupBy('an.student_pid')->first();
            // add principal commnet if not added 
            if($results){
                if(!$results->principal_comment || ($results->principal_comment && $results->exam_status==1)){
                    $results->principal_comment = $this->getPrincipalComment($results->class_param_pid, $results->average);
                }
                if (!$results->class_teacher_comment || ($results->class_teacher_comment && $results->exam_status == 1)) {
                    $results->class_teacher_comment = $this->getClassTeacherComment($results->class_param_pid, $results->average);
                }
            }
            // dd($results);
            $psycho = PsychomotorBase::where(['school_pid'=>getSchoolPid()])
                                            ->get(['psychomotor', 'pid']);
            $school = School::where('pid',getSchoolPid())
                    ->first(['school_email', 'school_website', 'school_logo', 'school_moto', 'school_address', 'school_contact']);
           $grades = DB::table('grade_keys AS g')->where('class_param_pid',$param)->get(['grade','title','min_score','max_score']);
        }
        return view('school.student.result.termly-result.student-report-card', compact('subResult', 'std', 'scoreSettings','param','psycho','results','grades','school'));

    }
    // load a particular student result for student or parents 
    public function viewStudentResult(Request $request)
    {
        $dtl = DB::table('student_class_results as r')
        ->join('student_class_score_params as p', 'p.pid', 'r.class_param_pid')
        ->join('terms as t', 't.pid', 'p.term_pid')
        ->join('sessions as ss', 'ss.pid', 'p.session_pid')
        ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
        ->select(DB::raw('distinct(r.student_pid),
                                r.class_param_pid,r.total,term,session,p.id'))->where(['r.school_pid'=>getSchoolPid()]);
        $rank = DB::table('student_class_results as r')
        ->joinSub($dtl, 'dtl', function ($dt) {
            $dt->on('r.student_pid', '=', 'dtl.student_pid');
        })->select(DB::raw('r.student_pid,r.total,
                                RANK() OVER (PARTITION BY dtl.class_param_pid ORDER BY r.total DESC) AS position,
                                r.class_param_pid,term,session,dtl.id'));
        $results = DB::table('students as s')
        ->joinSub($rank, 'rank', function ($rnk) {
            $rnk->on('s.pid', '=', 'rank.student_pid');
        })->select(DB::raw('rank.*'))
        ->orderBy('rank.id', 'DESC')
            ->where(['rank.student_pid' => base64Decode($request->pid)])
            ->get();
        return datatables($results)
            ->editColumn('position', function ($data) {
                return ordinalFormat($data->position);
            })->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('school.lists.student.result-action-buttons', ['data' => $data]);
            })
            ->make(true);
    }


    private function getPrincipalComment($param,$score){
        $comment = DB::table('principal_comments as c')
                        ->join('student_class_score_params as p','p.principal_pid','c.principal_pid')
                        ->where(['c.school_pid'=>getSchoolPid(),'p.pid'=>$param])
                        ->whereRaw('? between c.min and c.max', [$score])->pluck('comment')->first();
        return $comment;
    }
    private function getClassTeacherComment($param,$score){
        $comment = DB::table('form_master_comments as c')
                        ->join('student_class_score_params as p','p.teacher_pid','c.teacher_pid')
                        ->where(['c.school_pid'=>getSchoolPid(),'p.pid'=>$param])
                        ->whereRaw('? between c.min and c.max', [$score])->pluck('comment')->first();
        return $comment;
    }
}



// $rank = DB::table('student_class_results as r')
//     ->select(DB::raw('r.student_pid,r.total,
//                         RANK() OVER (ORDER BY r.total DESC) AS position'))
//                         ->groupBy('r.student_pid')
//                         ->orderBy('r.total','DESC')
//                         // ->groupBy('subject_type')
//                         // ->groupBy('r.class_teacher_comment')
//                         // ->groupBy('r.principal_comment')
//                         // ->groupBy('r.portal_comment')
//                         ->groupBy('r.total')
//                         // ->groupBy('r.class_param_pid')
//     ->where(['r.class_param_pid'=>$class])->get()->dd();
// $avg = DB::table('student_subject_results as sr')
//     ->select(DB::raw('COUNT(subject_type) as count,'))->groupBy('sr.student_pid')->where(['sr.class_param_pid' => $class, 'seated' => 1])->get()->dd();

// $rank = DB::table('student_class_results as r')->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
//     // ->joinSub($class, 'class', function ($sub) {
//     //     $sub->on('r.class_param_pid', '=', 'class.pid');
//     // })
//     ->select(DB::raw('r.student_pid,r.total,
//                                 RANK() OVER (ORDER BY r.total DESC) AS position'))
//     ->groupBy('r.student_pid')
//     ->orderBy('r.total', 'DESC')
//     // ->groupBy('subject_type')
//     // ->groupBy('r.class_teacher_comment')
//     // ->groupBy('r.principal_comment')
//     // ->groupBy('r.portal_comment')
//     ->groupBy('r.total')
//     // ->groupBy('r.class_param_pid')
//     ->where(['r.class_param_pid' => $class]);

// $result = DB::table('students as s')->joinSub($rank, 'rank', function ($sub) {
//     $sub->on('s.pid', '=', 'rank.student_pid');
// })->select(
//     'reg_number',
//     'fullname',
//     'position',
//     'rank.total',
//     'rank.student_pid',
//     // 'class_teacher_comment',
//     // 'principal_comment',
//     // 'portal_comment',
//     // 'average',
//     // 'count',
//     // 'class_param_pid',
// )->get()->dd();

// $rank = DB::table('student_subject_results as sr')->joinSub($result, 'result', function ($sr) {
//     $sr->on('sr.student_pid', '=', 'result.student_pid');
// })->select(DB::raw('COUNT()'));
