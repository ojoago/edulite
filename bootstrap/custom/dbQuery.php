<?php

use App\Models\School\Framework\Session\ActiveSession;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Term\ActiveTerm;
use Illuminate\Support\Facades\DB;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Student\Assessment\AffectiveDomain\AffectiveDomainRecord;
use App\Models\School\Student\Assessment\Psychomotor\PsychomotorRecord;
use App\Models\School\Student\Assessment\StudentScoreSheet;
use App\Models\Users\UserDetail;

    function activeSession()
    {
        $session = ActiveSession::where('school_pid',getSchoolPid())->orderBy('id', 'DESC')->pluck('session_pid')->first();
        return $session;
    }

    function activeTerm(){
        $term = ActiveTerm::where('school_pid', getSchoolPid())->orderBy('id','DESC')->pluck('term_pid')->first();
        return $term;
    }

    function authUsername(){
        return UserDetail::where('user_pid',getUserPid())->pluck('fullname')->first();
    }

    function getTitleScore($student,$pid,$param=null,$subject=null){
              return  $score = DB::table('student_score_params as p')
                                ->join('student_score_sheets as s','p.pid', 's.score_param_pid')
                                ->where([
                                    's.student_pid'=>$student,
                                    's.ca_type_pid'=>$pid,
                                    'p.subject_pid'=> $subject ?? session('subject'),
                                    'p.school_pid'=>getSchoolPid(),
                                    'p.pid'=> $param ?? getActionablePid()
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
function activeSessionName()
{
    $session = DB::table('active_sessions as a')
            ->join('sessions as s','s.pid','a.session_pid')
            ->where('a.school_pid',getSchoolPid())->orderBy('a.id', 'DESC')
            ->pluck('session')->first();
    return $session;
}

function activeTermName()
{
    $term = DB::table('active_terms as a')
            ->join('terms as t','t.pid','a.term_pid')
            ->where('a.school_pid', getSchoolPid())
            ->orderBy('a.id', 'DESC')->pluck('term')->first();
    // $term = ActiveTerm::where('school_pid', getSchoolPid())->orderBy('id', 'DESC')->pluck('term_pid')->first();
    return $term;
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