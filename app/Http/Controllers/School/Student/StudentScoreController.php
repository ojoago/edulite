<?php

namespace App\Http\Controllers\School\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Framework\ClassController;
use App\Models\School\Student\Student;
use App\Http\Controllers\School\Staff\StaffController;
use App\Models\School\Student\Assessment\StudentScoreParam;
use App\Models\School\Student\Assessment\StudentScoreSheet;
use App\Models\School\Framework\Assessment\ScoreSettingParam;

class StudentScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function loadAssessmentRecord(Request $request)
    {
    //    dd($request->all());
    session([
        'session'=> $request->session,
        'term'=> $request->term,
        'subject'=>$request->subject,
        'arm'=>$request->arm,
    ]);
    setActionablePid();//set assessment pid to null
    // self::useClassArmSubjectToGetSubjectScroe();
    
    return redirect()->route('enter.student.score');
}

public function enterStudentScore(){
        $schoolPid = getSchoolPid();
        $session = session('session');
        $term = session('term');
        $arm = session('arm');
        $scoreParams = ScoreSettingParam::join('class_arms', 'class_arms.class_pid', 'score_setting_params.class_pid')
            ->join('score_settings', 'score_data_pid', 'score_setting_params.pid')
            ->join('assessment_titles', 'assessment_titles.pid', 'score_settings.assessment_title_pid')
            ->orderBy('order')
            ->where([
                'term_pid' => $term,
                'session_pid' => $session,
                'class_arms.pid' => $arm
            ])->get(['title', 'score', 'assessment_title_pid']);
        //  
        $data = Student::where([
            'current_class' => $arm,
            'school_pid'=>getSchoolPid()
        ])->get([
                'fullname', 'reg_number', 'pid',
                // 'student_score_sheets.ca_type_pid', 'student_score_sheets.score'
        ]);
        $class = ClassController::GetClassSubjectAndName(session('subject'));
        $this->createScoreSheetParams();
        
        return view('school.student.assessment.enter-student-score', compact('data', 'scoreParams','class'));
    }
    public function submitCaScore(Request $request){
        $pid = getActionablePid();
        $data = [
            'assessment_pid'=>$pid,
            'student_pid'=>$request->student_pid,
            'ca_type_pid'=>$request->titlePid,
            'school_pid'=>getSchoolPid()
        ];
        $dupParams = $data;
        $data['score'] = $request->score;
        try {
            StudentScoreSheet::updateOrCreate($dupParams, $data);
            return 'Score Submitted';
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            return 'Score not Submitted';
        }
    }

    public static function sumStudentSubjectScore($pid,$student,$subject){

    }
    private function createScoreSheetParams(){
        // if(getActionablePid()){
        //     return getActionablePid();
        // }
        $schoolPid = getSchoolPid();
        $session =  session('session');
        $term =     session('term');
        $arm =      session('arm');
        $subject =  session('subject');
        $teacher = StaffController::getSubjectTeacherPid($session, $term, $subject);
        if(!$teacher){
            return redirect()->back();
        }
        $pid = StudentScoreParam::where([
                                'school_pid'=> $schoolPid, 
                                // 'teacher_pid'=>$teacher,
                                'session_pid'=>$session,
                                'subject_pid'=>$subject,
                                'term_pid'=>$term,
                                'arm_pid'=>$arm,
                            ])->pluck('pid')->first();
        if($pid){
            setActionablePid($pid);
            return;
        }
        $subject_type = ClassController::GetClassArmSubjectType($subject);
        $data = [
            'teacher_pid'=>$teacher,
            'session_pid'=>$session,
            'term_pid'=>$term,
            'subject_pid'=>$subject,
            'pid'=>public_id(),
            'arm_pid'=>$arm,
            'subject_type'=> $subject_type,
            'school_pid'=> $schoolPid,
        ];
        $result = StudentScoreParam::create($data);
        setActionablePid($result->pid);
    }
    
    
    public static function useClassArmSubjectToGetSubjectScroe($student= '0580129569123187USA4G0A0298T',$pid= '0U18263086G0223EU2T9003B0051'){
        dd(DB::select("SELECT SUM(s.score) AS score, student_pid,subject_type_pid AS subject_type
                    FROM 
                    student_score_sheets s INNER JOIN student_score_params p 
                    ON p.pid = s.assessment_pid
                    INNER JOIN class_arm_subjects cas ON cas.pid = p.subject_pid 
                    INNER JOIN subjects sb ON sb.pid = cas.subject_pid
                    GROUP BY student_pid,subject_type_pid
                    "));
        DB::table('student_score_sheets as s')
                ->join('student_score_params AS p', 'p.pid','s.assessment_pid')
                // ->join('class_arm_subjects AS am', 'am.subject_pid','p.subject_pid')
                // ->join('subjects AS sb', 'am.subject_pid','sb.pid')
                ->select(DB::raw("SUM(s.score) AS score, student_pid 
                                    "))->groupBy("GROUP BY student_pid")->get()->dd();
        // DB::table('student_score_sheets as s')
        //         ->join('student_score_params AS p', 'p.pid','s.assessment_pid')
        //         ->join('class_arm_subjects AS am', 'am.subject_pid','p.subject_pid')
        //         ->join('subjects AS sb', 'am.subject_pid','sb.pid')
        //         ->select(DB::raw("SUM(s.score) AS score, subject_type_pid as subject_type 
        //                             "))->groupBy("GROUP BY subject_type_pid")->get()->dd();
    }
}

