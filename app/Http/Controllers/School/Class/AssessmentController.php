<?php

namespace App\Http\Controllers\School\Class;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Assessment\Question;
use App\Models\School\Assessment\QuestionBank;
use App\Models\School\Assessment\QuestionAnswer;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;

class AssessmentController extends Controller
{

    // manual Assessment goes here 
    // StudentClassScoreParam
    public function loadAssessment(){
        $data = DB::table('question_banks as b')->join('questions as q','q.bank_pid','b.pid')
                                                ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                                                ->join('subjects as s','s.pid','cas.subject_pid')
                                                ->join('student_class_score_params as p','p.pid', 'b.class_param_pid')
                                                ->join('class_arms as a','a.pid','p.arm_pid')
                                                ->where(['b.school_pid'=>getSchoolPid()])->where('b.status','<>',0)
                                                ->select('s.subject','b.title','a.arm','b.pid','b.end_date','b.created_at')->get();
        return datatables($data)
        ->addIndexColumn()
        ->editColumn('subject', function ($data) {
            return $data->arm .' - '.$data->subject;
        })
        ->editColumn('created_at', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })
        ->addColumn('action', function ($data) {
            return view('school.assessments.class-assessment-action-button', ['data' => $data]);
        })
        ->make(true);
    }
    public function loadAssessmentForStudent($pid){
        $data = DB::table('question_banks as b')->join('questions as q','q.bank_pid','b.pid')
                                                ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                                                ->join('subjects as s','s.pid','cas.subject_pid')
                                                ->join('student_class_score_params as p','p.pid', 'b.class_param_pid')
                                                ->join('class_arms as a','a.pid','p.arm_pid')
                                                ->join('students as std', 'std.current_class_pid','a.pid')
                                                ->where(['b.school_pid'=>getSchoolPid(),'std.pid'=>$pid])->where('b.status', '<>', 0)
                                                ->whereNotIn('q.pid', function ($query) {
                                                    $query->select('question_pid')
                                                        ->from('question_answers');
                                                })
                                                ->select('s.subject','b.title','a.arm','b.pid','b.end_date','b.created_at','std.pid as std','b.type','q.path')->get();
        return datatables($data)
        ->addIndexColumn()
        ->editColumn('subject', function ($data) {
            return $data->arm .' - '.$data->subject;
        })
        ->editColumn('created_at', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })
        ->addColumn('action', function ($data) {
            return view('school.assessments.class-assessment-action-button', ['data' => $data]);
        })
        ->make(true);
    }

    public function loadStudentSubmitedAssessments(){
      $data = DB::table('question_banks as b')->join('questions as q','q.bank_pid','b.pid')
                                                ->join('question_answers as an', 'an.question_pid','q.pid')
                                                ->join('students as std', 'std.pid','an.student_pid')
                                                ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                                                ->join('subjects as s','s.pid','cas.subject_pid')
                                                ->join('student_class_score_params as p','p.pid', 'b.class_param_pid')
                                                ->join('class_arms as a','a.pid','p.arm_pid')
                                                ->where(['b.school_pid'=>getSchoolPid()])->where('b.status', '<>', 0)->orderBy('an.status')->orderBy('b.title')
                                               
                                                ->select('s.subject','b.title','a.arm','b.pid','b.end_date','an.created_at','std.pid as std','b.type','std.fullname','std.reg_number')->get();
        return datatables($data)
        ->addIndexColumn()
        ->editColumn('subject', function ($data) {
            return $data->arm .' - '.$data->subject.' - '.$data->title;
        })
        ->editColumn('created_at', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })
        ->addColumn('action', function ($data) {
            return view('school.assessments.class-assessment-mark-action-button', ['data' => $data]);
        })
        ->make(true);
    }

    public function loadQuestions(Request $request){
        // dd($request->all());
        $data = DB::table('question_banks as b')
        // ->join('questions as q', 'q.bank_pid', 'b.pid')
        ->join('class_arm_subjects as cas', 'cas.pid', 'b.subject_pid')
        ->join('subjects as s', 's.pid', 'cas.subject_pid')
        ->join('student_class_score_params as p', 'p.pid', 'b.class_param_pid')
        ->join('class_arms as a', 'a.pid', 'p.arm_pid')
        ->join('terms as t', 't.pid', 'p.term_pid')
        ->join('sessions as e', 'e.pid', 'p.session_pid')
        // ->join('students as std', 'std.current_class_pid', 'a.pid')
        ->where(['b.school_pid' => getSchoolPid(), 'b.pid' => $request->key])
            ->select('s.subject', 'b.title', 'a.arm', 'b.end_date', 'b.created_at','term','session', 'b.type')->first();

        $questions = DB::table('questions')
        ->where(['school_pid' => getSchoolPid(), 'bank_pid' => $request->key])
            ->select('question', 'bank_pid','pid','path','mark','options','type')->inRandomOrder()->get();
        $std = $request->std;
        return view('school.assessments.attempt-assessment', compact('questions','data','std'));

    }
    // create manual Assessment 
    public function createManualAssessment(Request $request){
       
        $validator = Validator::make($request->all(),
                                [
                                    'subject'=>'required',
                                    'arm'=>'required', 
                                    'end_date' => 'nullable|after:' . daysFromNow('- 1'),
                                    'title'=> "required|regex:/^[a-zA-Z0-9,\s]+$/",
                                    'file'=> 'required_if:type,1|nullable|mimes:pdf,docs,doc|max:1024',
                                ],['file.required_if'=>'Select File','end_date.after'=>"deadline can't be previous date",'file.max'=>'File too large']);

        if(!$validator->fails()){
            try {
                
                DB::beginTransaction();
               $bank = $this->createQuestionBank($request);
                if ($bank) {
                    $question = [
                        'school_pid' => getSchoolPid(),
                        'pid' => public_id(),
                        'bank_pid'=>$bank->pid,
                        'question' => $request->question,
                        'path' => null,
                        'mark' => $request->total_mark ?? null,
                        // 'type', 
                        // 'options'
                    ];
                    if($request->type == 1){
                        $fileName = invoiceNumber() .'-'.$request->title.'.' . $request->file->extension();
                        $request->file->move(public_path('files/assessments/questions'), $fileName);
                        $question['path'] = 'files/assessments/questions/' . $fileName;
                    }
                   $result =  $this->updateOrCreateQuestion($question);
                   if($result){
                    DB::commit();
                       return response()->json(['status' => 1, 'message' => 'Assessment created Successfully']);
                   }
                   DB::rollBack();
                }
            } catch (\Throwable $e) {
                logError(['error' => $e->getMessage(), 'line' => __LINE__]);
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => ER_500]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);

    }

    // create question bank 
    public static function createQuestionBank($request){
        $data = [
            'school_pid' => getSchoolPid(),
            'session_pid' => activeSession(),
            'term_pid' => activeTerm(),
            'arm_pid' => $request->arm,
        ];
        $class_param_pid = ClassController::createClassParam($data);
        $teacher = StaffController::getSubjectTeacherPid(session: activeSession(), term: activeTerm(), subject: $request->subject);
        $bank = [
            'school_pid' => getSchoolPid(),
            'class_param_pid' => $class_param_pid,
            'pid' => $request->pid ?? public_id(),
            'note' => $request->note,
            'mark' => $request->total_mark,
            'type' => $request->type,
            'category' => 1,
            'start_date' => justDate(),
            'title' => $request->title,
            'end_date'=>$request->end_date ?? null,
            'start_time' => $request->start_time ?? null,
            'end_time' => $request->end_time ?? null, 
            'teacher_pid' => $teacher,
            'subject_pid' => $request->subject,
            'creator' => getSchoolUserPid(),
            // 'access'=>0
        ];
        return (new self)->updateOrCreateQuestionBank($bank);
    }

 
    public function deleteAssessment(Request $request){
        $result = QuestionBank::where('pid',$request->key)->limit(1)->first()->update(['status'=>0]);
        if($result)
            return response()->json(['status' => 1, 'message' => 'Assessment Deleted Successfully']);
        else
            return response()->json(['status' => 'error', 'message' => ER_500]);
    }
    // create automated Assessment 
    public function createAutomatedAssessment(Request $request){
        // logError(json_decode($request->questions));
        // return;
        $validator = Validator::make($request->all(),
                                [
                                    'subject'=>'required',
                                    'arm'=>'required',
                                    'end_date' => 'nullable|after:' . daysFromNow('- 1'),
                                    'title' => "required|regex:/^[a-zA-Z0-9,\s]+$/",
                                ],['end_date.after'=>"deadline can't be previous date"]);
        if(!$validator->fails()){
            try {
                // implement transaction 
                DB::beginTransaction();
                $bank = $this->createQuestionBank($request);
                if ($bank) {
                    $result = false;
                    $questions = json_decode($request->questions);
                    foreach($questions as $row){
                        // logError($row);
                        if(empty($row->question) || count($row->options)<2){
                            continue;
                        }
                        $question = [
                            'school_pid' => getSchoolPid(),
                            'pid' => $row->pid ?? public_id(),
                            'bank_pid' => $bank->pid,
                            'question' => $row->question,
                            'path' => null,
                            'mark' =>  is_array($row->mark) ? array_sum($row->mark) : 0,
                            'type' => $row->type,
                            'options' => json_encode($row->options), 
    
                        ];
                        $result =  $this->updateOrCreateQuestion($question);
                    }
                    
                    if ($result) {
                        DB::commit();
                        return response()->json(['status' => 1, 'message' => 'Assessment created Successfully']);
                    }
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Enter all Questions and at least two options for each.']);
                }
                return response()->json(['status' => 'error', 'message' => ER_500]);
            } catch (\Throwable $e) {
                logError(['error' => $e->getMessage(), 'line' => __LINE__]);
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => ER_500]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);

    }

    private function updateOrCreateQuestionBank(array $data){
        try {
            return QuestionBank::updateOrCreate(['pid' => $data['pid']],$data);
        } catch (\Throwable $e) {
            logError(['error'=>$e->getMessage(),'line'=>__LINE__]);
            return false;
        }
    }
    private function updateOrCreateQuestion(array $data){
        try {
            return Question::updateOrCreate(['pid'=>$data['pid'],'bank_pid'=>$data['bank_pid']],$data);
        } catch (\Throwable $e) {
            logError(['error'=>$e->getMessage(),'line'=>__LINE__]);
            return false;
        }
    }


    // manual Assessment ends here 

    public function submitAssessment(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required_if:type,1|nullable|mimes:pdf,docs,doc|max:1024',
                'std' => 'required',
            ],
            ['file.required_if' => 'Select File','std.required'=>'your session has expired, logout and login again','file.max'=>'File too large']
        );
       if(!$validator->fails()){
            try {
                $data = ['student_pid' => $request->std, 'school_pid' => getSchoolPid()];
                if($request->type==1){
                    $std = StudentController::getStudentDetailBypId($request->std);// get student fullname as use as file name
                    $fileName = invoiceNumber() . '-'.@$std->fullname.'-'.time().'.' . $request->file->extension();
                    $request->file->move(public_path('files/assessments/answers'), $fileName);
                    $data['path'] = 'files/assessments/answers/'.$fileName;
                    $data['question_pid'] = $request->pid[0];
                    $result = $this->updateOrCreateAnswer($data);
                    if ($result)
                        return response()->json(['status' => 1, 'message' => 'Assessment submitted Successfully']);
                    else
                        return response()->json(['status' => 'error', 'message' => ER_500]);
                }
                if (isset($request->answer)) {
                    $result = false;
                   
                    foreach ($request->answer as $key => $row) {
                        $data['question_pid'] = $key;
                        $data['answer'] =  is_array($row) ? json_encode($row) : $row;
                        $result = $this->updateOrCreateAnswer($data);
                    }
                    if ($result)
                        return response()->json(['status' => 1, 'message' => 'Assessment submitted Successfully']);
                    else
                        return response()->json(['status' => 'error', 'message' => ER_500]);
                }
                return response()->json(['status' => 'error', 'message' => 'answer question first']);
            } catch (\Throwable $e) {
                logError(['error' => $e->getMessage(), 'line' => __LINE__, 'file' => __FILE__]);
                return response()->json(['status' => 'error', 'message' => ER_500]);
            }
       }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function updateOrCreateAnswer(array $data){
        try {
            return QuestionAnswer::updateOrCreate(['question_pid'=> $data['question_pid'],'student_pid' => $data['student_pid']],$data);
        } catch (\Throwable $e) {
            logError(['error' => $e->getMessage(), 'line' => __LINE__,'file'=>__FILE__]);
            return false;
        }
    }


    // load asseement for marking 
    public function loadSubmittedAssessmentsByStudent(Request $request){
        dd($request->all());
    }
}
