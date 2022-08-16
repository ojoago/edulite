<?php

use App\Models\School\Framework\Session\Session;
use Illuminate\Support\Facades\DB;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Student\Assessment\StudentScoreSheet;
    function uniqueNess($tbl,$key,$val){
        $query = DB::select("SELECT {$key} FROM {$tbl} WHERE {$key} = '$val' ");
        if($query){
            return $val .' exists in the table';
        }
        return null;
    }

    function getTitleScore($student,$pid){
        $score = StudentScoreSheet::join('student_score_params', 'student_score_params.pid',
                                     'student_score_sheets.assessment_pid')->where([
                                    'student_score_sheets.student_pid'=>$student,
                                    'student_score_sheets.ca_type_pid'=>$pid,
                                    'student_score_params.subject_pid'=>session('subject'),
                                    'student_score_params.school_pid'=>getSchoolPid(),
                                    'student_score_params.pid'=>getActionablePid()
                                    ])->pluck('score')->first();
        return $score;
    }

    function termName($pid){
        $term = Term::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('term')->first();
        return $term;
    }
    function sessionName($pid){
        $session = Session::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('session')->first();
        return $session;
    }