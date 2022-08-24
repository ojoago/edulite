<?php

namespace App\Http\Controllers\School\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Http\Controllers\School\Staff\StaffController;
use App\Models\School\Student\Result\StudentClassResult;
use App\Http\Controllers\School\Framework\ClassController;
use App\Models\School\Student\Result\StudentSubjectResult;
use App\Models\School\Student\Assessment\StudentScoreParam;
use App\Models\School\Student\Assessment\StudentScoreSheet;
use App\Models\School\Framework\Assessment\ScoreSettingParam;
use App\Models\School\Student\Result\StudentClassScoreParam;

class StudentScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
//
    public function enterStudentScoreRecord(Request $request){
    //    dd($request->all());
    session([
        'category'=> $request->category,
        'class'=> $request->class,
        'session'=> $request->session,
        'term'=> $request->term,
        'subject'=>$request->subject,
        'arm'=>$request->arm,
    ]);
    setActionablePid(); //set assessment pid to null
        // self::useClassArmSubjectToGetSubjectScroe();
    return redirect()->route('enter.student.score');
    }
    public function changeSubject(Request $request){
    //    dd($request->all());
        session([
            // 'category'=> $request->category,
            // 'class'=> $request->class,
            // 'session'=> $request->session,
            // 'term'=> $request->term,
            'subject'=>$request->subject,
            // 'arm'=>$request->arm,
        ]);
        setActionablePid(); //set assessment pid to null
            // self::useClassArmSubjectToGetSubjectScroe();
        return redirect()->route('enter.student.score');
    }
    public function viewStudentScoreRecord(Request $request){
        session([
            'session'=> $request->session,
            'term'=> $request->term,
            'subject'=>$request->subject,
            'arm'=>$request->arm,
        ]);
        setActionablePid(); //set assessment pid to null
            // self::useClassArmSubjectToGetSubjectScroe();
        return redirect()->route('view.student.score');
    }

    
//
    public function enterStudentScore(){
        
        $params = $this->loadStudentAndScoreSetting();
        $data = $params['data']; //list of student in selected class
        $scoreParams = $params['scoreParams']; //score header
        $class = $params['class'];//selected class and subject
        if(!$this->createScoreSheetParams()){
            return redirect()->route('student.assessment.form')->with('error','Subject not Assigned to any teacher');
        }
       
        return view('school.student.assessment.enter-student-score', compact('data', 'scoreParams','class'));
    }
//
    private function loadStudentAndScoreSetting(){
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
            'school_pid' => getSchoolPid()
        ])->get([
            'fullname', 'reg_number', 'pid',
            // 'student_score_sheets.ca_type_pid', 'student_score_sheets.score'
        ]);
        $class = ClassController::GetClassSubjectAndName(session('subject'));

        return [
            'scoreParams'=> $scoreParams,
            'data'=> $data,
            'class'=> $class,
        ];
    }


    public function submitCaScore(Request $request){
        $pid = getActionablePid();
        $schoolPid = getSchoolPid();
        $data = [
            'score_param_pid'=>$pid,
            'student_pid'=>$request->student_pid,
            'ca_type_pid'=>$request->titlePid,
            'school_pid'=> $schoolPid
        ];
        $dupParams = $data;
        $data['score'] = $request->score;
        try {
            StudentScoreSheet::updateOrCreate($dupParams, $data);
            $ca = self::sumStudentSubjectScore($pid,$request->student_pid, session('subject'));
            $data = [
                'school_pid'=> $schoolPid,
                'student_pid'=> $request->student_pid,
                'class_param_pid'=> $ca->class_param_pid,
                'subject_type'=>$ca->subject_type,
                'total'=>$ca->score,
            ];
            $this->studentSubjectScore($data);
            return 'Score Submitted ';
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            return 'Score not Submitted';
        }
    }

    // sum individual score to form combined score
    private static function sumStudentSubjectScore($pid, $student, $subject)//combined
    {
        $subject_score = DB::table("student_score_sheets as s")
        ->join("student_score_params AS p", 'p.pid', 's.score_param_pid')
        ->where(['s.student_pid' => $student, 'p.subject_pid' => $subject, 'p.pid' => $pid])
            ->groupBy('p.subject_type')
            ->groupBy('p.class_param_pid')
            ->select(DB::raw('(SUM(s.score)/COUNT(DISTINCT(s.score_param_pid))) as score,p.subject_type,p.class_param_pid'))->first();

        return $subject_score;
    }
    private function studentSubjectScore(array $data){
        $dupParams = $data;
        unset($dupParams['total']);
        StudentSubjectResult::updateOrCreate($dupParams,$data);
        $total = $this->sumStudentTotalScore($data['class_param_pid'],$data['student_pid']);//sum student total score
        $data = [
            'class_param_pid'=>$data['class_param_pid'],
            'student_pid'=>$data['student_pid'],
            'total'=>$total,
            'school_pid'=>getSchoolPid()
        ];
        $this->recordStudentTotal($data);
    }
    private function sumStudentTotalScore($pid,$student){
        $student_total = StudentSubjectResult::where([
                                            'class_param_pid'=>$pid,
                                            'student_pid'=>$student,
                                            'school_pid'=>getSchoolPid()
                                            ])->sum('total');
        return $student_total;
    }

    private function recordStudentTotal($data){
        $dupParams = $data;
        unset($dupParams['total']);
        StudentClassResult::updateOrCreate($dupParams,$data);
    }
    
    private function createScoreSheetParams(){
        $schoolPid = getSchoolPid();
        $session =  session('session');
        $term =     session('term');
        $arm =      session('arm');
        $subject =  session('subject');
        $teacher = StaffController::getSubjectTeacherPid($session, $term, $subject);
        if(!$teacher){
            return false;
        }
        $data = [
            'school_pid' => $schoolPid,
            'teacher_pid' => $teacher,
            'session_pid' => $session,
            'term_pid' => $term,
            'arm_pid' => $arm,
        ];
        $class_pid = $this->createCLassParam($data);
        $subject_type = ClassController::GetClassArmSubjectType($subject);
        $pid = StudentScoreParam::where([
                                    'subject_pid'=>$subject, 
                                    'class_param_pid'=> $class_pid, 
                                    'school_pid'=>$schoolPid
                                ])->pluck('pid')->first();
        if($pid){
            setActionablePid($pid);
            return true;
        }
        $param = [
            // 'subject_teacher' => $teacher,
            'class_param_pid' => $class_pid,
            'subject_pid' => $subject,
            'pid' => public_id(),
            'subject_type' => $subject_type,
            'staff_pid' => getSchoolUserPid(),
            'school_pid' => $schoolPid
        ];
        $result = StudentScoreParam::create($param);
        setActionablePid($result->pid);
        return true;
    }
    
    private function createCLassParam($data){
        $teacher = $data['teacher_pid'];
        unset($data['teacher_pid']);
        $pid = StudentClassScoreParam::where($data)->pluck('pid')->first();
        if ($pid) {
            return $pid;
        }
        $data['teacher_pid']= $teacher;
        $data['pid']= public_id();
        $result = StudentClassScoreParam::create($data);
       return $result->pid;
    }
    public function changeSubjectResultStatus(Request $request){
        $pid = getActionablePid();
        $seated = $request->seated;
        $student_pid = $request->student_pid;
        $status = StudentSubjectResult::where(['assessment_pid'=>$pid,'student_pid'=>$student_pid])->update(['seated'=>$seated]);
        if($status){
            return 'Status Updated';
        }
        return 'Error, Could not update status';
    }
     

    // view subject result goes here  
    public function viewStudentScore(Request $request)
    {
        session([
            'session' => $request->session,
            'term' => $request->term,
            'subject' => $request->subject,
            'arm' => $request->arm,
        ]);
        setActionablePid(); //set assessment pid to null
        // self::useClassArmSubjectToGetSubjectScroe();
        return redirect()->route('view.student.score');
    }
    public function loadStudentScore()
    {
        $params = $this->loadStudentAndScoreSetting();
        $data = $params['data']; //list of student in selected class
        $scoreParams = $params['scoreParams']; //score header
        $class = $params['class'];//selected class and subject
        if (!$this->createScoreSheetParams()) {
            return redirect()->route('student.assessment.form')->with('error', 'Subject not Assigned to any teacher');
        }

        return view('school.student.assessment.view-student-score', compact('data', 'scoreParams', 'class'));
    }
}

