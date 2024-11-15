<?php

namespace App\Http\Controllers\School\Student\Results\Termly;

// use PDF;
use Barryvdh\DomPDF\Facade\PDF;
// use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\School\School;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Framework\Psychomotor\PsychomotorBase;
use App\Models\School\Student\Result\StudentClassResultParam;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;

class StudentTermlyResultController extends Controller
{

    public function loadStudentResult(Request $request)
    {
        $data = [
            'school_pid' => getSchoolPid(),
            'session_pid' => $request->session,
            'term_pid' => $request->term,
            'arm_pid' => $request->arm,
        ];
        $result = self::studentResultParams($data);
        ['data' => $data , 'class' => $class , 'subjects' => $subjects ] = $result;
      
        $term = termName($request->term); 
        $session = sessionName($request->session);

        return view('school.student.result.termly-result.view-termly-result', compact('data', 'class', 'subjects', 'session','term'));
        return redirect()->route('view.student.result');
    }

   

    public static function studentResultParams(array $data)
    {
        $class = DB::table('student_class_result_params')->where($data)->pluck('pid')->first();
        // $rank = DB::table('student_class_results as r')
        // ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
        // // ->join('student_class_result_params as p','p.pid', 'r.class_param_pid')
        // ->select(DB::raw('r.student_pid,r.total,
        //                         COUNT(sr.subject_type) as count,r.total/COUNT(sr.subject_type) as average,
        //                         RANK() OVER (ORDER BY r.total DESC) AS position, r.class_param_pid'))
        // ->groupBy('r.class_param_pid')
        // ->groupBy('r.student_pid')
        // ->orderBy('r.total', 'DESC')
        // ->groupBy('r.total')->where(['r.class_param_pid' => $class, 'sr.class_param_pid' => $class])->get()->dd();

        $rank = DB::table('student_class_results as r')
                            // ->join('student_class_result_params as p','p.pid', 'r.class_param_pid')
                            ->select(DB::raw('r.student_pid,r.total,
                                RANK() OVER (ORDER BY r.total DESC) AS position, r.class_param_pid'))
            ->groupBy('r.class_param_pid')
            ->groupBy('r.student_pid')
            ->orderBy('r.total', 'DESC')
            ->groupBy('r.total')->where(['class_param_pid' => $class]);//->get(); //->dd();
        $summary = DB::table('student_subject_results as sr')->joinSub($rank, 'rn', function ($rank) {
            $rank->on('sr.student_pid', 'rn.student_pid')->on('sr.class_param_pid', 'rn.class_param_pid');
        })->select(DB::raw(
            'COUNT(subject_type) as count,rn.total/COUNT(subject_type) as average, rn.total,position,sr.student_pid'
        ))->groupBy('sr.student_pid', 'rn.total', 'position')->orderBy('position')
        ->where(['sr.seated' => 1 , 'sr.class_param_pid' => $class]);//->get()->dd();

        $result = DB::table('student_class_results as r')
        ->join('students as s', 's.pid', 'r.student_pid')
        ->joinSub($summary,'sm',function($sm){
            $sm->on('sm.student_pid', 'r.student_pid');//->on('sm.class_param_pid', 'r.class_param_pid');
        })
        // ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
        ->select('sm.*','reg_number','fullname','class_teacher_comment','principal_comment','portal_comment', 'r.class_param_pid')
        ->where('r.class_param_pid', $class)->get(); //->dd();

        // $class = DB::table('student_class_result_params as p')->where($data)->pluck('pid')->first();
        // $dtl = DB::table('student_class_results as r')
        //             ->join('students as s','s.pid','r.student_pid')
        //             ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
        //             ->select(DB::raw('distinct(r.student_pid),reg_number,fullname,
        //                                 class_teacher_comment,principal_comment,
        //                                 portal_comment,r.class_param_pid,r.total'))
        //                                 ->where('r.class_param_pid',$class); //->get()->dd();
        // $rank = DB::table('student_class_results as r')
        //         ->joinSub($dtl,'dtl',function($dt){
        //             $dt->on('r.student_pid','=','dtl.student_pid');
        //         })->select(DB::raw('r.student_pid,r.total,
        //                         RANK() OVER (ORDER BY r.total DESC) AS position,
        //                         reg_number,fullname,
        //                         dtl.class_teacher_comment,dtl.principal_comment,
        //                         dtl.portal_comment,r.class_param_pid'))
        // ->groupBy('r.student_pid')
        //     ->orderBy('r.total', 'DESC')
        //     ->groupBy('r.total')
        //     ->where(['r.class_param_pid' => $class])->get();//->dd();
        //   dd($ranks,$rank) ; 
        // $result = DB::table('student_subject_results as sr')->joinSub($rank,'rn',function($rank){
        //     $rank->on('sr.student_pid','=','rn.student_pid');
        // })->select(DB::raw(
        //     'COUNT(subject_type) as count,
        //     rn.total/COUNT(subject_type) as average,
        //     rn.total,position,
        //     rn.student_pid,reg_number,
        //     fullname,rn.class_teacher_comment,
        //     rn.principal_comment,rn.portal_comment,
        //     rn.class_param_pid
        //     '))->groupBy('sr.student_pid')->orderBy('position')
        //     ->where(['sr.class_param_pid' => $class, 'seated' => 1])->get();//->dd();



        // $class = DB::table('student_class_result_params')->where($data)->pluck('pid')->first();
        // $dtl = DB::table('student_class_results as r')
        //             ->join('students as s','s.pid','r.student_pid')
        //             ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
        //             ->select(DB::raw('distinct(r.student_pid),reg_number,fullname,
        //                                 class_teacher_comment,principal_comment,
        //                                 portal_comment,r.class_param_pid,r.total'))
        //                                 ->where('r.class_param_pid',$class); //->get()->dd();
        // $rank = DB::table('student_class_results as r')
        //         ->joinSub($dtl,'dtl',function($dt){
        //             $dt->on('r.student_pid','=','dtl.student_pid');
        //         })->select(DB::raw('r.student_pid,r.total,
        //                         RANK() OVER (ORDER BY r.total DESC) AS position,
        //                         reg_number,fullname,
        //                         dtl.class_teacher_comment,dtl.principal_comment,
        //                         dtl.portal_comment,r.class_param_pid'))
        // ->groupBy('r.student_pid')
        //     ->orderBy('r.total', 'DESC')
        //     ->groupBy('r.total')
        //     ->where(['r.class_param_pid' => $class])->get()->dd();
        // $result = DB::table('student_subject_results as sr')->joinSub($rank,'rn',function($rank){
        //     $rank->on('sr.student_pid','=','rn.student_pid');
        // })->select(DB::raw(
        //     'COUNT(subject_type) as count,
        //     rn.total/COUNT(subject_type) as average,
        //     rn.total,position,
        //     rn.student_pid,reg_number,
        //     fullname,rn.class_teacher_comment,
        //     rn.principal_comment,rn.portal_comment,
        //     rn.class_param_pid
        //     '))->groupBy('sr.student_pid')->orderBy('position')
        //     ->where(['sr.class_param_pid' => $class, 'seated' => 1])->get();//->dd();

        $subjects = true;
        if($result->empty()){
            $result = DB::table('student_class_results as r')
                ->join('students as s', 's.pid', 'r.student_pid')
                ->where('r.class_param_pid', $class)->select('reg_number','fullname','class_teacher_comment','principal_comment','portal_comment', 'total', 'class_param_pid', 'student_pid')->get();//->dd();
            $subjects = false;
        }
        $className = ClassController::getClassArmNameByPid($data['arm_pid']);
        return [
            'class' => $className,
            'data' => $result,
            'subjects' => $subjects
        ];
    }

    // a particular student result 
    public function studentReportCard($param,$spid){ //class param & student pid
    //  StudentClassResult::where('student_pid',$spid)->get()->dd();   
     try {
            $classParam = StudentClassResultParam::where('pid', $param)->first(['session_pid', 'term_pid', 'arm_pid']);
            // dd($classParam);
            // StudentScoreParam::join('student_score_sheets','score_param_pid','subject_score_params.pid')->where('class_param_pid',$param)->get()->dd();
            if (!$classParam) {
            } else {
                // load template path 
                $result_config = DB::table('result_configs as r')->join('classes as c', 'c.category_pid', 'r.category_pid')
                    ->join('class_arms as a', 'a.class_pid', 'c.pid')
                    ->join('student_class_result_params as p', 'p.arm_pid', 'a.pid')->where('p.pid', $param)->select('r.*')->first();

                $terms = DB::table('student_class_result_params as p')->join('student_class_results as r', 'r.class_param_pid','p.pid')->where(['session_pid' => $classParam->session_pid, 'r.student_pid' => $spid])->orderByDesc('p.id')->get(['p.pid', 'term', 'session_pid']);
                $scoreSettings = ScoreSettingsController::loadClassScoreSettings($param);
                $std = StudentController::studentName($spid);
                // query subject result 
                // query subject result base on subject type: 
                    // if subject type equal 1 then load take average of individual subject from student_subject_results table
                    // if subject type equal 2 then load take average of individual subject from subject_total
                    // if subject type equal 2 then load take average of individual subject from subject_total and display them under the subject type 
                if($result_config->subject_type == 3){
                    $subdtl = DB::table('student_subject_results as sr')
                        // this join bring subject teahcer name and subject name
                        ->join('subject_score_params AS p', function ($q) {
                            $q->on('p.class_param_pid', 'sr.class_param_pid')
                                ->on('p.subject_type', 'sr.subject_type');
                        })
                        ->join('subject_totals AS st', 'p.pid', 'st.subject_param_pid')
                        ->where([
                            'st.seated' => 1,
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid()
                        ])->select(DB::raw('sr.subject_type,p.subject_type_name as subject,MIN(sr.total) AS min, 
                                        MAX(sr.total) AS max, AVG(sr.total) AS avg, SUM(sr.total) AS subTotal,p.subject_teacher_name')) // subTotal is the sum of all student score for eacher subject 
                        ->groupBy('sr.subject_type')
                        ->groupBy('p.subject_teacher_name')
                        ->groupBy('p.subject_type_name'); //->get()->dd();
                    $subRank = DB::table('student_subject_results as sr')->joinSub($subdtl, 'd', function ($d) {
                        $d->on('sr.subject_type', '=', 'd.subject_type');
                    })
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid(),
                            // 'sr.student_pid' => $spid
                        ])
                        ->select(DB::raw('total, sr.subject_type AS type,sr.student_pid,min,max,avg,subTotal,subject,
                                    RANK() OVER (PARTITION BY sr.subject_type ORDER BY total DESC) AS position,d.subject_teacher_name
                                    '))
                        ->groupBy('sr.subject_type')->groupBy('sr.student_pid')
                        ->groupBy('d.subject')->groupBy('d.min')
                        ->groupBy('d.max')->groupBy('d.avg')
                        ->groupBy('d.subTotal')->groupBy('d.subject_teacher_name')
                        ->groupBy('total'); //->get()->dd();

                    $subResult = DB::table('student_subject_results as sr')
                        ->joinSub($subRank, 'sub', function ($sub) {
                            $sub->on('sr.subject_type', '=', 'sub.type');
                            $sub->on('sr.student_pid', '=', 'sub.student_pid');
                        })
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid(),
                            'sub.student_pid' => $spid,
                        ])
                        ->select('sub.*', 'sr.class_param_pid', 'sr.grade', 'sr.title')
                        // ->groupBy('sr.subject_type')
                        ->get();//->dd();

                }
                elseif($result_config->subject_type == 2){
                    $subdtl = DB::table('student_subject_results as sr')
                        // this join bring subject teahcer name and subject name
                        ->join('subject_score_params AS p', function ($q) {
                            $q->on('p.class_param_pid', 'sr.class_param_pid')
                                ->on('p.subject_type', 'sr.subject_type');
                        })
                        ->join('subject_totals AS st', 'p.pid', 'st.subject_param_pid')
                        ->where([
                            'st.seated' => 1,
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid()
                        ])->select(DB::raw('sr.subject_type,p.subject_type_name as subject,MIN(sr.total) AS min, 
                                        MAX(sr.total) AS max, AVG(sr.total) AS avg, SUM(sr.total) AS subTotal,p.subject_teacher_name')) // subTotal is the sum of all student score for eacher subject 
                        ->groupBy('sr.subject_type')
                        ->groupBy('p.subject_teacher_name')
                        ->groupBy('p.subject_type_name'); //->get()->dd();
                    $subRank = DB::table('student_subject_results as sr')->joinSub($subdtl, 'd', function ($d) {
                        $d->on('sr.subject_type', '=', 'd.subject_type');
                    })
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid(),
                            // 'sr.student_pid' => $spid
                        ])
                        ->select(DB::raw('total, sr.subject_type AS type,sr.student_pid,min,max,avg,subTotal,subject,
                                    RANK() OVER (PARTITION BY sr.subject_type ORDER BY total DESC) AS position,d.subject_teacher_name
                                    '))
                        ->groupBy('sr.subject_type')->groupBy('sr.student_pid')
                        ->groupBy('d.subject')->groupBy('d.min')
                        ->groupBy('d.max')->groupBy('d.avg')
                        ->groupBy('d.subTotal')->groupBy('d.subject_teacher_name')
                        ->groupBy('total'); //->get()->dd();
                    // $select = DB::table('student_subject_results as sr');
                    // $ca = DB::table('subject_score_params as ssp')
                    //             ->join('student_score_sheets as sss','score_param_pid','ssp.pid')
                    //             ->joinSub($strSub,'sb',function($sb){
                    //                 $sb->on('ssp.subject_type','=','sb.subject_type');
                    //             })
                    //             ->select(DB::raw("ca_type_pid,sb.subject_type"))
                    //             ->where(['class_param_pid'=> $param,'ssp.school_pid'=>getSchoolPid()])
                    //             ->groupBy('ca_type_pid');//->get()->dd();//->toArray();
                    // $value = DB::table('subject_score_params as ssp')
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
                            $sub->on('sr.student_pid', '=', 'sub.student_pid');
                        })
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid(),
                            'sub.student_pid' => $spid,
                        ])
                        ->select('sub.*', 'sr.class_param_pid', 'sr.grade', 'sr.title')
                        // ->groupBy('sr.subject_type')
                        ->get();//->dd();

                }else{
                    $subdtl = DB::table('student_subject_results as sr')
                        // this join bring subject teahcer name and subject name
                        ->join('subject_score_params AS p', function ($q) {
                            $q->on('p.class_param_pid', 'sr.class_param_pid')
                                ->on('p.subject_type', 'sr.subject_type');
                        })
                        ->join('subject_totals AS st', 'p.pid', 'st.subject_param_pid')
                        ->where([
                            'st.seated' => 1,
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid()
                        ])->select(DB::raw('sr.subject_type,p.subject_type_name as subject,MIN(sr.total) AS min, 
                                        MAX(sr.total) AS max, AVG(sr.total) AS avg, SUM(sr.total) AS subTotal,p.subject_teacher_name')) // subTotal is the sum of all student score for eacher subject 
                        ->groupBy('sr.subject_type')
                        ->groupBy('p.subject_teacher_name')
                        ->groupBy('p.subject_type_name'); //->get()->dd();
                    $subRank = DB::table('student_subject_results as sr')->joinSub($subdtl, 'd', function ($d) {
                        $d->on('sr.subject_type', '=', 'd.subject_type');
                    })
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid(),
                            // 'sr.student_pid' => $spid
                        ])
                        ->select(DB::raw('total, sr.subject_type AS type,sr.student_pid,min,max,avg,subTotal,subject,
                                    RANK() OVER (PARTITION BY sr.subject_type ORDER BY total DESC) AS position,d.subject_teacher_name
                                    '))
                        ->groupBy('sr.subject_type')->groupBy('sr.student_pid')
                        ->groupBy('d.subject')->groupBy('d.min')
                        ->groupBy('d.max')->groupBy('d.avg')
                        ->groupBy('d.subTotal')->groupBy('d.subject_teacher_name')
                        ->groupBy('total'); //->get()->dd();
                    // $select = DB::table('student_subject_results as sr');
                    // $ca = DB::table('subject_score_params as ssp')
                    //             ->join('student_score_sheets as sss','score_param_pid','ssp.pid')
                    //             ->joinSub($strSub,'sb',function($sb){
                    //                 $sb->on('ssp.subject_type','=','sb.subject_type');
                    //             })
                    //             ->select(DB::raw("ca_type_pid,sb.subject_type"))
                    //             ->where(['class_param_pid'=> $param,'ssp.school_pid'=>getSchoolPid()])
                    //             ->groupBy('ca_type_pid');//->get()->dd();//->toArray();
                    // $value = DB::table('subject_score_params as ssp')
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
                            $sub->on('sr.student_pid', '=', 'sub.student_pid');
                        })
                        ->where([
                            'sr.class_param_pid' => $param,
                            'sr.school_pid' => getSchoolPid(),
                            'sub.student_pid' => $spid,
                        ])
                        ->select('sub.*', 'sr.class_param_pid', 'sr.grade', 'sr.title')
                        // ->groupBy('sr.subject_type')
                        ->get();//->dd();

                }


                // query class result 
                
                // individual student result and class position 
                $class = DB::table('student_subject_results as r')
                            ->select(DB::raw('SUM(r.total)/COUNT(r.id) as class_average,COUNT(distinct(student_pid)) as students,class_param_pid'))
                            ->where('r.class_param_pid', $param)->groupBy('r.class_param_pid'); //->get()->dd();

                $rank = DB::table('student_class_results as r')
              
                ->select(DB::raw('r.student_pid,r.total,r.class_param_pid,
                                RANK() OVER (ORDER BY r.total DESC) AS position'))
                ->groupBy('r.student_pid', 'r.total', 'r.class_param_pid')
                ->orderBy('r.total', 'DESC')
                    ->where(['r.class_param_pid' => $param]);//->get()->dd();


                $query = DB::table('student_subject_results as sr')
                ->joinSub($rank, 'rn', function ($rank) {
                    $rank->on('sr.student_pid', 'rn.student_pid')->on('sr.class_param_pid', 'rn.class_param_pid');
                })
               
                ->select(DB::raw(
                    'COUNT(subject_type) as count,
                    rn.total/COUNT(subject_type) as average,
                    rn.total,position,
                    rn.student_pid,
                    rn.class_param_pid'
                ))->groupBy('sr.student_pid','rn.total','position','rn.student_pid','rn.class_param_pid')->orderBy('position')
                ->where(['sr.class_param_pid' => $param, 'seated' => 1]); //->get()->dd();

                $params = DB::table('student_class_result_params as p')
                ->join('student_class_results  as r', 'p.pid', 'r.class_param_pid')
                
                ->join('active_term_details as atm', function ($join) { // term begin / term end details
                    $join->on('atm.term_pid', 'p.term_pid')->on('atm.session_pid', 'p.session_pid');
                })
               
                    ->leftjoin('attendance_records as ar', function ($join) {
                        $join->on('p.term_pid', 'ar.term_pid')->on('p.session_pid', 'ar.session_pid');
                    })
                    // ->leftjoin('attendances as an', 'an.record_pid', 'ar.pid')
                ->leftjoin('school_staff as st', 'st.pid', 'p.teacher_pid')
                    ->select('term', 'session', 'arm', 'atm.begin', 'atm.end', 'atm.next_term', 'r.student_pid', 'st.signature')
                    ->where([
                        'p.pid' => $param,
                        // 's.student_pid' => $spid,
                        'r.student_pid' => $spid
                    ])
                    ->groupBy('r.student_pid', 'term', 'session', 'arm', 'atm.begin', 'atm.end', 'atm.next_term', 'st.signature');//->get()->dd();

                $atc = DB::table('student_class_result_params as p')
                ->join('student_class_results  as r', 'p.pid', 'r.class_param_pid')
                    ->leftjoin('attendance_records as ar', function ($join) {
                        $join->on('p.term_pid', 'ar.term_pid')->on('p.session_pid', 'ar.session_pid');
                    })->leftjoin('attendances as an', function ($j){
                        $j->on('an.student_pid', 'r.student_pid')->on('an.record_pid', 'ar.pid');
                    })
                    ->select(DB::raw("r.student_pid,
                                COUNT(CASE WHEN an.status = 1 THEN 'Present' END) as 'present',
                                COUNT(CASE WHEN an.status = 2 THEN 'Excused' END) as 'excused',
                                COUNT(CASE WHEN an.status = 0 THEN 'Absent' END) as 'absent' "))
                    ->where([
                        'p.pid' => $param,
                        // 's.student_pid' => $spid,
                        'r.student_pid' => $spid
                    ])
                    ->groupBy('r.student_pid');//->get()->dd();


                $result = DB::table('student_class_results as r')
                    ->joinSub($query,'q',function($q){
                        $q->on('q.student_pid', 'r.student_pid')->on('q.class_param_pid', 'r.class_param_pid');
                    })
                    ->joinSub($class,'cls',function($cls){
                        $cls->on('r.class_param_pid', 'cls.class_param_pid');
                    })
                    ->joinSub($atc,'a',function($a){
                        $a->on('r.student_pid', 'a.student_pid');
                    })
                    ->joinSub($params,'pr',function($sub){
                        $sub->on('r.student_pid', 'pr.student_pid');
                    })
                    ->join('student_class_result_params as p', 'p.pid', 'r.class_param_pid')
                    ->leftjoin('school_staff as stf', 'stf.pid', 'p.principal_pid')
                    // ->leftjoin('user_details as d', 'd.user_pid', 'stf.user_pid')
                    ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
                    ->join('students as s', 's.pid', 'r.student_pid')
                    ->select(DB::raw('r.student_pid,reg_number,type,class_average,students,
                                        class_teacher_comment,principal_comment,
                                        portal_comment,r.class_param_pid,r.total,principal_name,teacher_name,
                                        p.status as exam_status,r.updated_at as date,stf.signature as principal_signature,q.*,a.*,pr.*'))
                    ->where(['r.class_param_pid' => $param])->first();

                    // dd($result);
                  
                    // dd($result);
                // add principal commnet if not added 
                if ($result) {
                    if ($result->principal_comment == null /* || ($result->principal_comment && $result->exam_status == 1) */ ) {
                        $result->principal_comment = $this->getPrincipalComment($result->class_param_pid, $result->average);
                    }
                    if ($result->class_teacher_comment == null /* || ($result->class_teacher_comment && $result->exam_status == 1) */ ) {
                        
                        $result->class_teacher_comment = $this->getClassTeacherComment($result->class_param_pid, $result->average);
                    }
                }else{
                    $result = DB::table('student_class_results as r')
                        ->join('student_class_result_params  as srp', 'srp.pid', 'r.class_param_pid')
                        // ->join('terms as t', 't.pid', 'srp.term_pid')
                        // ->join('sessions as s', 's.pid', 'srp.session_pid')
                        // ->join('class_arms as a', 'a.pid', 'srp.arm_pid')
                        ->leftjoin('school_staff as st', 'st.pid', 'srp.teacher_pid')
                        ->leftjoin('user_details as d', 'd.user_pid', 'st.user_pid')
                        ->join('active_term_details as atm', function ($join) {// term begin and term end details
                            $join->on('atm.term_pid', 'srp.term_pid')->on('atm.session_pid', 'srp.session_pid');
                        })
                        ->join('students as s', 's.pid', 'r.student_pid')
                        
                        ->where(['r.class_param_pid' => $param , 'r.student_pid' => $spid])
                        ->select('term', 'session' , 'arm', 'teacher_name', 'principal_name', 'portal_name', 'reg_number','atm.next_term',
                                 's.fullname', 's.gender' , 's.weight','s.height', 'class_teacher_comment', 'principal_comment', 'portal_comment', 'total', 'class_param_pid', 'student_pid','r.updated_at as date')->first();
                }

                // dd($result);
                // StudentClassResultParam
                $psycho = PsychomotorBase::from('psychomotor_bases as b')->join('classes as c', 'c.category_pid', 'b.category_pid')
                                                            ->join('class_arms as a','a.class_pid','c.pid')
                                                            ->join('student_class_result_params as p','p.arm_pid','a.pid')
                                                            ->where(['p.pid' => $param, 'b.school_pid' => getSchoolPid()])->select('b.psychomotor','b.pid', 'obtainable_score as max', 'grade')->get();//->dd();
                                                            

                $school = School::where('pid', getSchoolPid())
                    ->first(['school_email', 'school_website', 'school_logo', 'school_moto', 'school_address', 'school_contact']);
                
                $grades = DB::table('grade_key_bases as b')->join('class_arms as a','a.class_pid','b.class_pid')->where('a.pid',$classParam->arm_pid)->select('grade', 'title', 'min_score', 'max_score')->get();//->dd();
                // $grades = DB::table('grade_keys AS g')->where('class_param_pid', $param)->get([]);
            }

            // default template 

            $basePath = 'school.student.result.';
            $path = 'termly-result.student-report-card';
            $path = 'termly-result.general-template';
            
            // if($result_config){
            //     $basePath = $result_config->base_dir;
            //     $path = '.' . $result_config->sub_dir . '.' . $result_config->file_name;
            // }
            $cache = [
                'path' => $basePath . $path,  'subResult' => $subResult, 'std' =>$std , 'scoreSettings' => $scoreSettings , 'param' => $param , 
                'psycho' => $psycho, 'result' => $result , 'grades' => $grades , 'school' => $school , 'terms' => $terms, 'result_config' => $result_config
            ];
            // dd($cache['path']);
            
            Cache::pull($param . $spid);
            Cache::add($param . $spid,$cache);
            if(view()->exists($basePath . $path)){
                return view($basePath.$path, compact('subResult', 'std', 'scoreSettings', 'param', 'psycho', 'result', 'grades', 'school', 'terms', 'result_config'));
            }else{
                $path = '.termly-result.student-report-card';
                $cache = [
                    'path' => $basePath . $path,  'subResult' => $subResult, 'std' => $std, 'scoreSettings' => $scoreSettings, 'param' => $param,
                    'psycho' => $psycho, 'result' => $result, 'grades' => $grades, 'school' => $school, 'terms' => $terms, 'result_config' => $result_config
                ];
                // dd($cache['path']);
                Cache::pull($param . $spid);
                Cache::add($param . $spid, $cache);
                return view($basePath. $path, compact('subResult', 'std', 'scoreSettings', 'param', 'psycho', 'result', 'grades', 'school', 'terms', 'result_config'));
            }

     } catch (\Throwable $e) {
        logError($e->getMessage());
        dd($e);
     }
    }

    public function loadStudentResultPdf($prm,$spid){
        // set_time_limit(360);
        ['path' => $path,  'subResult' => $subResult, 'std' => $std, 'scoreSettings' => $scoreSettings, 'param' => $param,
            'psycho' => $psycho, 'result' => $result, 'grades' => $grades, 'school' => $school, 'terms' => $terms, 'result_config' => $result_config
        ] =  Cache::get($prm . $spid);
        // dd($d);
        // $pdf = new ();
        // $pdf = PDF::loadView('welcome')->setOptions([ 'defaultFont' => 'sans-serif']);
        // dd($path);
       
        return view('school.student.result.termly-result.print-student-report-card', compact('subResult', 'std', 'scoreSettings', 'param', 'psycho', 'result', 'grades', 'school', 'terms', 'result_config','path'));

        // return $pdf->download($std->fullname . 'Report Card'.'.pdf');
        $pdf = PDF::loadView($path, ['subResult' => $subResult , 'std' =>$std, 'scoreSettings' => $scoreSettings, 'param' =>$param, 'psycho' =>$psycho, 'result' =>$result, 'grades'=> $grades, 'school'=>$school, 'terms' =>$terms, 'result_config' => $result_config])->setOptions([ 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true]);
        // dd($path);
        return $pdf->download($std->fullname . 'Report Card'.'.pdf');
        return view($path, );

    }

    // load a particular student result for student or parents 
    public function viewStudentResult(Request $request)
    {
        try {
            $params = DB::table('student_class_results')->where(['student_pid' => $request->pid])->select('class_param_pid')->orderByDesc('created_at')->pluck('class_param_pid');
            $results = [];
            if($params) :
                foreach($params as $pid):
                    $dtl = DB::table('student_class_results as r')
                    ->join('student_class_result_params as p', 'p.pid', 'r.class_param_pid')
                    // ->join('terms as t', 't.pid', 'p.term_pid')
                    // ->join('sessions as ss', 'ss.pid', 'p.session_pid')
                    // ->join('class_arms as a', 'a.pid', 'p.arm_pid')
                        // ->join('student_subject_results as sr', 'sr.class_param_pid', 'r.class_param_pid')
                        ->select(DB::raw('distinct(r.student_pid),
                                r.class_param_pid,r.total,term,session,p.id,p.arm'))->where(['r.school_pid' => getSchoolPid(), 'r.class_param_pid' => $pid]);
                    $rank = DB::table('student_class_results as r')
                    ->joinSub($dtl, 'dtl', function ($dt) {
                        $dt->on('r.student_pid', 'dtl.student_pid');
                    })->where(['r.class_param_pid' => $pid])->select(DB::raw('r.student_pid,r.total,arm,
                                RANK() OVER (PARTITION BY dtl.class_param_pid ORDER BY r.total DESC) AS position,
                                dtl.class_param_pid,term,session,dtl.id'));
                    $result = DB::table('students as s')
                        ->joinSub($rank, 'rank', function ($rnk) {
                            $rnk->on('s.pid',  'rank.student_pid');
                        })->select(DB::raw('rank.*'))
                        ->orderBy('rank.id', 'DESC')
                        ->where(['rank.student_pid' => $request->pid])
                        ->first();
                    $results[] = $result;
                endforeach;
            endif;
            return datatables($results)
            ->editColumn('position', function ($data) {
                return ordinalFormat($data->position);
            })->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('school.lists.student.result-action-buttons', ['data' => $data]);
            })
            ->make(true);
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }

    // load principal default comment 
    private function getPrincipalComment($param,$average){
        try {
            $comment = DB::table('principal_comments as c')
            ->join('student_class_result_params as p', 'p.principal_pid', 'c.principal_pid')
            ->where(['c.school_pid' => getSchoolPid(), 'p.pid' => $param])
            ->whereRaw('? between c.min and c.max', [$average])->pluck('comment')->first();
            return $comment;
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }

    //load class teacher default comment based on average
    private function getClassTeacherComment($param,$average){
        try {
            $comment = DB::table('form_master_comments as c')
            ->join('student_class_result_params as p', 'p.teacher_pid', 'c.teacher_pid')
            ->where(['c.school_pid' => getSchoolPid(), 'p.pid' => $param])
            ->whereRaw('? between c.min and c.max', [$average])->pluck('comment')->first();
            return $comment;
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
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




// $atc = DB::table('student_class_result_params as p')
                // ->join('student_class_results  as r', 'p.pid', 'r.class_param_pid')
                // // ->join('terms as t', 't.pid', 'srp.term_pid')
                // // ->join('sessions as s', 's.pid', 'srp.session_pid')
                // // ->join('class_arms as a', 'a.pid', 'srp.arm_pid')
                // // ->leftjoin('school_staff as st', 'st.pid', 'srp.teacher_pid')
                //     // ->leftjoin('user_details as d', 'd.user_pid', 'st.user_pid')
                //     ->join('active_term_details as atm', function ($join) { // term begin / term end details
                //         $join->on('atm.term_pid', 'p.term_pid')->on('atm.session_pid', 'p.session_pid');
                //     })
                //     // ->leftJoin('attendances as ad','')
                //     // ->joinSub($query, 'rs', function ($r) {
                //     //     $r->on('r.student_pid', 'rs.student_pid');
                //     // })
                //     ->leftjoin('attendance_records as ar', function ($join) {
                //         $join->on('p.term_pid', 'ar.term_pid')->on('p.session_pid', 'ar.session_pid');
                //     })->leftjoin('attendances as an', 'an.record_pid', 'ar.pid')
                //     ->select(DB::raw("term,session,arm,atm.begin,atm.end,atm.next_term,
                //                 COUNT(CASE WHEN an.status = 1 THEN 'Present' END) as 'present',
                //                 COUNT(CASE WHEN an.status = 2 THEN 'Excused' END) as 'excused',
                //                 COUNT(CASE WHEN an.status = 0 THEN 'Absent' END) as 'absent' "))
                //     ->where([
                //         'p.pid' => $param,
                //         // 's.student_pid' => $spid,
                //         'r.student_pid'=>$spid
                //     ])
                //     ->groupBy('an.student_pid', 'term', 'session', 'arm', 'atm.begin', 'atm.end', 'atm.next_term');//->get()->dd();
                // $class = DB::table('student_class_results as r')
                //     ->joinSub($dtl, 'dtl', function ($dt) {
                //         $dt->on('r.student_pid', 'dtl.student_pid');
                //     })->select(DB::raw('r.student_pid,r.total,
                //                 RANK() OVER (ORDER BY r.total DESC) AS position,
                //                 reg_number,type, dtl.class_teacher_comment,dtl.principal_comment,
                //                 dtl.portal_comment,r.class_param_pid,principal_name,exam_status,teacher_name,date,principal_signature,class_average,students'))
                //     ->groupBy('r.student_pid')
                //     ->orderBy('r.total', 'DESC')
                //     ->groupBy('r.total')
                //     ->where(['r.class_param_pid' => $param])->get()->dd();

                // $rank = DB::table('student_class_results as r')
                //     ->joinSub($dtl, 'dtl', function ($dt) {
                //         $dt->on('r.student_pid', 'dtl.student_pid');
                //     })->select(DB::raw('r.student_pid,r.total,r.class_param_pid,
                //                 RANK() OVER (ORDER BY r.total DESC) AS position'))
                //     ->groupBy('r.student_pid', 'r.total', 'r.class_param_pid')
                //     ->orderBy('r.total', 'DESC')
                //     ->where(['r.class_param_pid' => $param])->get()->dd();

                    // reg_number,type, dtl.class_teacher_comment,dtl.principal_comment,
                    //             dtl.portal_comment,r.class_param_pid,principal_name,exam_status,teacher_name,date,principal_signature,class_average,students

                // $rank = DB::table('student_class_results as r')
                //             ->select(DB::raw('r.student_pid,r.total,
                //                 RANK() OVER (ORDER BY r.total DESC) AS position,
                //                 reg_number,type, dtl.class_teacher_comment,dtl.principal_comment,
                //                 dtl.portal_comment,r.class_param_pid,principal_name,exam_status,teacher_name,date,principal_signature,class_average,students'))
                //         ->groupBy('r.student_pid')
                //         ->orderBy('r.total', 'DESC')
                //         ->groupBy('r.total')
                //         ->where(['r.class_param_pid' => $param])->get()->dd();

                // $query = DB::table('student_subject_results as sr')->joinSub($rank, 'rn', function ($rank) {
                //     $rank->on('sr.student_pid', 'rn.student_pid');
                // })->select(DB::raw(
                //     'COUNT(subject_type) as count,
                //     rn.total/COUNT(subject_type) as average,
                //     rn.total,position,
                //     rn.student_pid,reg_number,type,rn.class_teacher_comment, 
                //     rn.principal_comment,rn.portal_comment,
                //     rn.class_param_pid,principal_name,exam_status,teacher_name,date,principal_signature,class_average,students'
                // ))->groupBy('sr.student_pid')->orderBy('position')
                //     ->where(['sr.class_param_pid' => $param, 'seated' => 1])->get()->dd();

                // $result = DB::table('student_class_results as r')
                //     ->join('student_class_result_params  as srp', 'srp.pid', 'r.class_param_pid')
                //     // ->join('terms as t', 't.pid', 'srp.term_pid')
                //     // ->join('sessions as s', 's.pid', 'srp.session_pid')
                //     // ->join('class_arms as a', 'a.pid', 'srp.arm_pid')
                //     ->leftjoin('school_staff as st', 'st.pid', 'srp.teacher_pid')
                //     // ->leftjoin('user_details as d', 'd.user_pid', 'st.user_pid')
                //     ->join('active_term_details as atm', function ($join) { // term begin / term end details
                //         $join->on('atm.term_pid', 'srp.term_pid')->on('atm.session_pid', 'srp.session_pid');
                //     })
                //     // ->leftJoin('attendances as ad','')
                //     ->joinSub($query, 'rs', function ($r) {
                //         $r->on('r.student_pid', 'rs.student_pid');
                //     })->leftjoin('attendance_records as ar', function ($join) {
                //         $join->on('srp.term_pid', 'ar.term_pid')->on('srp.session_pid', 'ar.session_pid');
                //     })->leftjoin('attendances as an', 'an.record_pid', 'ar.pid')
                //     ->select(DB::raw("rs.*,st.signature,term,session,arm,atm.begin,atm.end,rs.student_pid,atm.next_term,
                //                 COUNT(CASE WHEN an.status = 1 THEN 'Present' END) as 'present',
                //                 COUNT(CASE WHEN an.status = 2 THEN 'Excused' END) as 'excused',
                //                 COUNT(CASE WHEN an.status = 0 THEN 'Absent' END) as 'absent' "))
                //     ->where([
                //         'r.class_param_pid' => $param,
                //         'rs.student_pid' => $spid,
                //         // 'an.student_pid'=>$spid
                //     ])
                //     ->groupBy('an.student_pid')->first();
