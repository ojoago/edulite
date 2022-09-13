<?php

use App\Models\School\Framework\Session\ActiveSession;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Term\ActiveTerm;
use Illuminate\Support\Facades\DB;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Student\Assessment\AffectiveDomain\AffectiveDomainRecord;
use App\Models\School\Student\Assessment\Psychomotor\PsychomotorRecord;
use App\Models\School\Student\Assessment\StudentScoreSheet;


    function activeSession()
    {
        $session = ActiveSession::where('school_pid',getSchoolPid())->orderBy('id', 'DESC')->pluck('session_pid')->first();
        return $session;
    }

    function activeTerm(){
        $term = ActiveTerm::where('school_pid', getSchoolPid())->orderBy('id','DESC')->pluck('term_pid')->first();
        return $term;
    }


    function uniqueNess($tbl,$key,$val){
        $query = DB::select("SELECT {$key} FROM {$tbl} WHERE {$key} = '$val' ");
        if($query){
            return $val .' exists in the table';
        }
        return null;
    }

    function getTitleScore($student,$pid,$param=null,$subject=null){
        $score = StudentScoreSheet::join('student_score_params', 'student_score_params.pid',
                                    'student_score_sheets.score_param_pid')->where([
                                    'student_score_sheets.student_pid'=>$student,
                                    'student_score_sheets.ca_type_pid'=>$pid,
                                    'student_score_params.subject_pid'=> $subject ?? session('subject'),
                                    'student_score_params.school_pid'=>getSchoolPid(),
                                    'student_score_params.pid'=> $param ?? getActionablePid()
                                    ])->pluck('score')->first();
        return $score;
    }
    function getTitleAVGScore($student, $pid, $param,$sub){
        // dd($student, $pid, $param, $sub);
        
        $ca = DB::table('student_score_sheets as s')
                        ->join('student_score_params as p','s.score_param_pid','p.pid')
                        ->select(DB::raw("AVG(score) AS score"))
                        ->where([
                            's.student_pid' => $student,
                            's.ca_type_pid' => $pid,
                            'p.subject_type' => $sub,
                            'p.school_pid' => getSchoolPid(),
                            'p.class_param_pid' => $param
                        ])
                        // ->groupBy('type_pid')
                        ->groupBy('p.subject_type')
                        ->pluck('score')->first();//->toArray();
        return $ca;
    }
    function aggregate(){}
    function termName($pid){
        $term = Term::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('term')->first();
        return $term;
    }
    function sessionName($pid){
        $session = Session::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('session')->first();
        return $session;
    }

    // psychomoter 

    function getPsychoKeyScore($student,$param,$key){
        $score = PsychomotorRecord::where([
                            'student_pid'=>$student,
                            'class_param_pid'=>$param,
                            'key_pid'=>$key,
                            'school_pid' => getSchoolPid()
                        ])->pluck('score')->first();
        return $score;
    }
    // psychomoter 

    function getDomainKeyScore($student,$param,$key){
        $score = AffectiveDomainRecord::where([
                            'student_pid'=>$student,
                            'class_param_pid'=>$param,
                            'key_pid'=>$key,
                            'school_pid'=>getSchoolPid()
                        ])->pluck('score')->first();
        return $score;
    }