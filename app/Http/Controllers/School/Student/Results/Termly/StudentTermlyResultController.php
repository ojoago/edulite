<?php

namespace App\Http\Controllers\School\Student\Results\Termly;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Student\Assessment\AffectiveDomain\AffectiveDomainRecord;
use App\Models\School\Student\Assessment\Psychomotor\PsychomotorRecord;
use App\Models\School\Student\Assessment\StudentScoreParam;
use App\Models\School\Student\Result\StudentClassScoreParam;

class StudentTermlyResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $class = DB::table('student_class_score_params')->where($data)->select('pid');
        // $param = StudentClassScoreParam::where($data)->pluck('pid')->first();
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
            'count',
            'class_param_pid',
        )->get();
        $className = ClassController::getClassArmNameByPid($data['arm_pid']);
        return [
            'class' => $className,
            'data' => $result,
            // 'param' => $param
        ];
    }

    public function studentReportCard($param,$spid){ //class param & student pid
        $classParam = StudentClassScoreParam::where('pid',$param)->first(['session_pid','term_pid','arm_pid']);
        // StudentScoreParam::join('student_score_sheets','score_param_pid','student_score_params.pid')->where('class_param_pid',$param)->get()->dd();
        if(!$classParam){

        }else{
            $scoreSettings = ScoreSettingsController::loadClassScoreSettings($classParam->term_pid,$classParam->session_pid,$classParam->arm_pid);
            $std = StudentController::studentName($spid);
            $strSub = DB::table('student_subject_results as sr')
                        ->join('subject_types AS s', 's.pid', 'sr.subject_type')
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.student_pid' => $spid,
                            'sr.school_pid' => getSchoolPid()
                        ])
                ->select(DB::raw('total,s.subject_type AS subject,
                                  s.pid AS type,RANK() OVER (ORDER BY total DESC) AS position'))
                // ->groupBy('ssp.type_pid')
                ->orderBy('s.subject_type')
                ;//->get()->dd();

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
                //->join('student_score_params as ssp', 'ssp.class_param_pid', 'sr.class_param_pid')
            ->joinSub($strSub, 'sub', function ($sub) {
                $sub->on('sr.subject_type', '=', 'sub.type');
            })
                ->where([
                // 'sr.subject_type' => $strSub->type,
                    'sr.class_param_pid' => $param,
                    'sr.school_pid' => getSchoolPid()
                ])
                ->select(DB::raw('type,subject,sub.total,position,MIN(sr.total) AS min, 
                                        MAX(sr.total) AS max, AVG(sr.total) AS avg, SUM(sr.total) AS subjectTotal'))
                ->groupBy('sr.subject_type')
                ->get();
            $subResult;//= $strSub;
            
            $psycho = PsychomotorRecord::join('psychomotors', 'psychomotors.pid','key_pid')
                                            ->where(['class_param_pid'=>$param,
                                                    'student_pid'=>$spid])
                                            ->get(['score', 'title', 'max_score']);
            $domains = AffectiveDomainRecord::join('affective_domains', 'affective_domains.pid','key_pid')
                                            ->where(['class_param_pid'=>$param,
                                                    'student_pid'=>$spid])
                                            ->get(['score', 'title', 'max_score']);


        }

        return view('school.student.result.termly-result.student-report-card', compact('subResult', 'std', 'scoreSettings','param','psycho','domains'));

    }
}
