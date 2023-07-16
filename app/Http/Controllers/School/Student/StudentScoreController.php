<?php

namespace App\Http\Controllers\School\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Models\School\Student\Student;
use App\Http\Controllers\School\Staff\StaffController;
use App\Models\School\Student\Result\StudentClassResult;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Framework\Grade\GradeKeyController;
use App\Models\School\Student\Result\StudentSubjectResult;
use App\Models\School\Student\Assessment\StudentScoreParam;
use App\Models\School\Student\Assessment\StudentScoreSheet;
use App\Models\School\Student\Result\SubjectTotal;
use App\Models\School\Student\Results\Cumulative\CumulativeResult;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class StudentScoreController extends Controller
{
  
    
//
    public function enterStudentScoreRecord(Request $request){
        $request['session'] = activeSession();
        $request['term'] = activeTerm();
       $request->validate([
            'category'=>'required',
            'class'=>'required',
            'arm'=>'required',
            'subject'=>'required',
            'term'=>'required',
            'session'=>'required',
       ]);

       if(!$this->mySubjects($request->subject)){
            $cl = ClassController::GetClassSubjectAndName($request->subject);
            return redirect()->back()->with('warning',$cl->subject.' '.$cl->arm.' is not assigned to YOU');
       }
        
        // retrieve form data 
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
    private function mySubjects($pid){
        if(schoolAdmin()){
            return true;
        }
        return DB::table('staff_subjects')->where(['arm_subject_pid'=>$pid,'teacher_pid'=>getSchoolUserPid(),'term_pid'=>activeTerm(),'session_pid'=>activeSession(),'school_pid'=>getSchoolPid()])->exists();
    }


    // switch to another subject from the blade
    public function changeSubject(Request $request){
        $request->validate([
            'arm' => 'required',
            'subject' => 'required',
        ]);
        session([
            // 'category'=> $request->category,
            // 'class'=> $request->class,
            // 'session'=> $request->session,
            // 'term'=> $request->term,
            'subject'=>$request->subject,
            'arm'=>$request->arm,
        ]);
        setActionablePid(); //set assessment pid to null
            // self::useClassArmSubjectToGetSubjectScroe();
        return redirect()->route('enter.student.score');
    }

    // view subject score 
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
        // load student names and score settings 
        $params = $this->loadStudentAndScoreSetting();
        $data = $params['data']; //list of student in selected class
        $scoreParams = $params['scoreParams']; //score header
        $class = $params['class'];//selected class and subject
        if(!$this->createScoreSheetParams() || $this->createScoreSheetParams() === 'no class'){
            if($this->createScoreSheetParams()==='no class'){
                return redirect()->route('student.assessment.form')->with('error', ClassController::getClassArmNameByPid(session('arm')). '  not Assigned to any teacher for ' . termName(session('term')) . ' ' . sessionName(session('session')));
            }
            return redirect()->route('student.assessment.form')->with('error', 'Subject not Assigned to any teacher for ' . termName(session('term')) . ' ' . sessionName(session('session')).' & make sure proper term/ session is set');
        }
       
        return view('school.student.assessment.enter-student-score', compact('data', 'scoreParams','class'));
    }
//
    private function loadStudentAndScoreSetting(){
        $session = session('session');
        $term = session('term');
        $arm = session('arm');
        $class = session('class');
        // dd($session,$term,$arm);
        // load score setting 
        $data = [
            'school_pid' => getSchoolPid(),
            'session_pid' => $session,
            'term_pid' => $term,
            'arm_pid' => $arm,
        ];
        $class_param_pid = ClassController::createClassParam($data);// create class param key and return the pid

        ScoreSettingsController::createClassSoreSetting(param_pid: $class_param_pid,class_pid:$class); //copy score setting from base score setting
       
        GradeKeyController::createClassGradeKey(param_pid: $class_param_pid,class_pid:$class); //copy grade setting from base score setting

        $scoreParams = ScoreSettingsController::loadClassScoreSettings($class_param_pid);// load class score seetting 
        
        $data = Student::where([
            'current_class_pid' => $arm,
            'school_pid' => getSchoolPid(),
            'current_session_pid' => $session
        ])->get([
            'fullname', 'reg_number', 'pid',
            // 'student_score_sheets.ca_type_pid', 'student_score_sheets.score'
        ]);
        // load student 
        $class = ClassController::GetClassSubjectAndName(session('subject'));

        return [
            'scoreParams'=> $scoreParams,
            'data'=> $data,
            'class'=> $class,
        ];
    }


    // submit student CA on change from jquery 
    public function submitCaScore(Request $request){
        try {
            $data = [
                'score_param_pid' => getActionablePid(),
                'student_pid' => $request->student_pid,
                'ca_type_pid' => $request->titlePid,
                'school_pid' => getSchoolPid(),
                'score' => $request->score
            ];
            // $dupParams = $data;
            // $data['score'] = $request->score;
            $result = $this->processStudentScore($data);
            if ($result) {
                return response()->json(['status' => 1, 'message' => 'Score Submitted']);
            }
            return response()->json(['status' => 0, 'message' => 'Score not Submitted']);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    private function processStudentScore($data){
        $dupParams = $data;
        unset($dupParams['score']);
        try {
            StudentScoreSheet::updateOrCreate($dupParams, $data);
            $ca = self::sumStudentSubjectScore($data['score_param_pid'], $data['student_pid'], session('subject'));
            $data = [
                'school_pid' => getSchoolPid(),
                'student_pid' => $data['student_pid'],
                'class_param_pid' => $ca->class_param_pid,
                'subject_type' => $ca->subject_type,
                'subject_pid' => session('subject'),
                'total' => $ca->score,
                'subject_param_pid' => getActionablePid(),
            ];
            return $this->studentSubjectScore($data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }


    // sum individual score to form combined score
    private static function sumStudentSubjectScore($pid, $student, $subject) //combined
    {
        try {
            $subject_score = DB::table("student_score_sheets as s")
            ->join("student_score_params AS p", 'p.pid', 's.score_param_pid')
            ->where(['s.student_pid' => $student, 'p.subject_pid' => $subject, 'p.pid' => $pid])
            ->groupBy('p.subject_type')
            ->groupBy('p.class_param_pid')
            ->select(DB::raw('(SUM(s.score)/COUNT(DISTINCT(s.score_param_pid))) as score,p.subject_type,p.class_param_pid'))->first();
            return $subject_score;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    // subject result 
    private function studentSubjectScore(array $data){
        try {
            $dupParams = $data;
            unset($dupParams['total']);
            SubjectTotal::updateOrCreate($dupParams, $data); // sum all ca as to individual score
            unset($data['subject_pid']);
            unset($data['subject_param_pid']);
            unset($dupParams['subject_pid']);
            unset($dupParams['subject_param_pid']);
            return $this->updateCombineSubject($data);
        } catch (\Throwable $e) {
           logError($e->getMessage());
           return false;
        }
    }
    private function updateCombineSubject($data){
        try {
            $dupParams = $data;
            $data['total'] = $this->sumStudentCombinedScore($data); // take average of combined score as total and insert into subject type
            unset($dupParams['total']);
            StudentSubjectResult::updateOrCreate($dupParams, $data); //combine subject details
            $total = $this->sumStudentTotalScore($data['class_param_pid'], $data['student_pid']); //sum student total score
            $data = [
                'class_param_pid' => $data['class_param_pid'],
                'student_pid' => $data['student_pid'],
                'total' => $total,
                'school_pid' => getSchoolPid()
            ];
            return $this->recordStudentTotal($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    private function sumStudentCombinedScore($data){
        try {
            $param = [
                'class_param_pid' => $data['class_param_pid'],
                'student_pid' => $data['student_pid'],
                'subject_type' => $data['subject_type'],
                'school_pid' => getSchoolPid(),
                'seated' => 1,
            ];
            $total = SubjectTotal::where($param)->avg('total');
            return $total;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    
    // get combine subject score 
    private function sumStudentTotalScore($pid,$student){
        try {
            $student_total = StudentSubjectResult::where([
                'class_param_pid' => $pid,
                'student_pid' => $student,
                'school_pid' => getSchoolPid()
            ])->sum('total');
            return $student_total;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    // add subject score to total scroe  
    private function recordStudentTotal($data){
        try {
            $dupParams = $data;
            unset($dupParams['total']);
            return StudentClassResult::updateOrCreate($dupParams, $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    // update subject exam status 
    public function changeSubjectResultStatus(Request $request)
    {
       try {
            $status = SubjectTotal::where(['subject_param_pid' => getActionablePid(), 'student_pid' => $request->student_pid])->update(['seated' => $request->seated]);
            if ($status) {
                $sbj = SubjectTotal::where(['subject_param_pid' => getActionablePid(), 'student_pid' => $request->student_pid])->first();
                $data = [
                    'class_param_pid' => $sbj->class_param_pid,
                    'student_pid' => $sbj->student_pid,
                    'subject_type' => $sbj->subject_type,
                    // 'subject_pid' => $sbj->subject_pid,
                    'total' => $sbj->total,
                    'school_pid' => getSchoolPid(),
                    'seated' => 1,
                ];
                $this->updateCombineSubject($data);
                return 'Status Updated';
            }
            return 'Error, Could not update status';
       } catch (\Throwable $e) {
            logError($e->getMessage());
           return 'Something Went Wrong... error logged';
       }
    }
    

    private function createScoreSheetParams(){
        $session =  session('session');
        $term =     session('term');
        $arm =      session('arm');
        $subject =  session('subject');
        $teacher = StaffController::getSubjectTeacherPid(session:  $session,term: $term,subject: $subject);
        // dd($teacher, $session, $term, $subject);
        if(!$teacher){
            return false;
        }

        $data = [
            'school_pid' => getSchoolPid(),
            'session_pid' => $session,
            'term_pid' => $term,
            'arm_pid' => $arm,
        ];
        $class_pid = ClassController::createClassParam($data);
        if(!$class_pid){
            return 'no class';// if class is not assigned to teacher
        }
        $subject_type = ClassController::GetClassArmSubjectType($subject);
        $pid = StudentScoreParam::where([
                                    'subject_pid'=>$subject,
                                    'class_param_pid'=> $class_pid, 
                                    'school_pid'=>getSchoolPid()
                                ])->pluck('pid')->first();
        if($pid){
            setActionablePid($pid);
            return true;
        }
        $teacher = StaffController::getSubjectTeacherPid($session, $term, $subject);
        
        $param = [
            'subject_teacher' => $teacher,
            'class_param_pid' => $class_pid,
            'subject_pid' => $subject,
            'pid' => public_id(),
            'subject_type' => $subject_type,
            'staff_pid' => getSchoolUserPid(),
            'school_pid' =>getSchoolPid()
        ];
        $result = StudentScoreParam::create($param);
        setActionablePid($result->pid);
        return true;
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
        return redirect()->route('view.student.score');
    }
    public function loadStudentScore()
    {
        $params = $this->loadStudentAndScoreSetting();
        $data = $params['data']; //list of student in selected class
        $scoreParams = $params['scoreParams']; //score header
        $class = $params['class'];//selected class and subject
        if (!$this->createScoreSheetParams()) {
            return redirect()->route('student.assessment.form')->with('error', 'Subject not Assigned to any teacher '.termName(session('term')). ' ' . sessionName(session('session')));
        }

        return view('school.student.assessment.view-student-score', compact('data', 'scoreParams', 'class'));
    }


    private function StudentCumulative($data){
       $pid = CumulativeResult::where([
            'session_pid' => $data['session_pid'],
            'arm_pid' => $data['arm_pid'],
            'student_pid' => $data['student_pid'],
            'school_pid' => getSchoolPid()
        ])->pluck('pid')->first();
        if($pid){
            return;
        }
      CumulativeResult::create([
          'session_pid'=>$data['session_pid'],
          'arm_pid'=> $data['arm_pid'],
          'student_pid'=> $data['student_pid'],
          'pid'=>public_id(),
          'school_pid'=>getSchoolPid()
      ]);
    }
    
    // export student for score entering 
    public function exportStudentList(){
        try {
            $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z'];
            $params = $this->loadStudentAndScoreSetting();
            $class = $params['class'];
            $count = $params['scoreParams']->count();
            $title = $params['scoreParams'];
            $data = $params['data'];
            $name = $class->arm . ' ' . $class->subject;
            $file = new Spreadsheet();
            $file->getActiveSheet()->setTitle($name)->getColumnDimension('B')->setVisible(false); //->setTitle($name);//get the first shee
            $file->getActiveSheet()->getRowDimension(2)->setVisible(false); //->setTitle($name);//get the first shee
            $active_sheet = $file->getActiveSheet(); //->setTitle($name);//get the first shee
            $l  = $letters[$count + 4];
            $active_sheet->setCellValue('A1', 'S/N'); //row 1
            $active_sheet->setCellValue('C1', 'REG NUMBER'); //row 1
            $active_sheet->setCellValue('D1', 'NAMES'); //row 1
            for ($j = 'E', $i = 0; $j < $l; $i++, $j++) {
                $active_sheet->setCellValue($j . 1, $title[$i]->title . ' [' . $title[$i]->score . ']'); //row 1
                $active_sheet->setCellValue($j . 2, $title[$i]->assessment_title_pid); //row 1
            }
            $k = 3;
            $n = 0;
            foreach ($data as $row) {
                $active_sheet->setCellValue('A' . $k, ++$n);
                $active_sheet->setCellValue('B' . $k, $row->pid);
                $active_sheet->setCellValue('C' . $k, $row->reg_number);
                $active_sheet->setCellValue('D' . $k, $row->fullname);
                $k++;
            }
            $path =  $name . ' ' .  activeTermName() .  ' ' . activeSessionName() . ".xlsx";
            $fileName = str_replace('/', '-', $path);
            // Headers for download 
            $writer = new Xlsx($file);
            $writer->save($fileName);
            ob_end_clean();
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");
            readFile($fileName);
            // unlink($zipName);
            unlink($fileName);

        } catch (\Throwable $e) {
            logError($e->getMessage());
            return redirect()->back()->with('error','Something Went Wrong');
        }
    }
    // import students score after entering 
    public function importStudentScore(Request $request){

        $validator = Validator::make($request->all(),['file' => 'required|file|mimes:xlsx|max:30|min:7']);

        if(!$validator->fails()){
            try {
                $errors = [];
                $path = $request->file('file')->getRealPath();
                // $resource = maatWay(model:new SchoolStaff,path:$path);
                $resource = phpWay($path);
                $header = $resource['header'];
                $data = $resource['data'];
                $params = $data[1];
                $len = (count($params));
                unset($data[1]);
                $n = 1;
                foreach($data as $row){
                    for ($i=4; $i < $len; $i++) {
                        $data = [
                            'score_param_pid' => getActionablePid(),
                            'student_pid' => $row[1],
                            'ca_type_pid' => $params[$i],
                            'school_pid' => getSchoolPid(),
                            'score' => $row[$i]
                        ];
                        $result = $this->processStudentScore($data);
                        if(!$result){
                            $errors[] = $header[$i] . ' Not recorded for student ' . $row[2] . ' on S/N ' . $n;
                        }
                    }
                   $n++;
                }
                return response()->json(['status' => 1, 'message' => 'Score Upload Success','errors'=>$errors]);
            } catch (\Throwable $e) {
                return response()->json(['status' =>'error', 'message' => 'Failed to upload']);
                $error = $e->getMessage();
                logError($error);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }
}

