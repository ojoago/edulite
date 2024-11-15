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
use App\Models\School\Framework\Assessment\ScoreSetting;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Http\Controllers\School\Student\StudentScoreController;

class AssessmentController extends Controller
{

    // manual Assessment goes here 
    // StudentClassScoreParam
    public function loadAssessment(){
        $data = DB::table('question_banks as b')
                                                // ->join('questions as q','q.bank_pid','b.pid')
                    ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                    ->join('subjects as s','s.pid','cas.subject_pid')
                    ->join('student_class_result_params as p','p.pid', 'b.class_param_pid')
                    // ->join('class_arms as a','a.pid','p.arm_pid')
                    ->where(['b.school_pid'=>getSchoolPid()])->where('b.status','<>',0)
                    ->select('s.subject','b.title','p.arm','b.pid','b.end_date','b.created_at')->get();
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
        
        $data = DB::table('question_banks as b')
                                                ->join('questions as q','q.bank_pid','b.pid')
                                                ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                                                ->join('subjects as s','s.pid','cas.subject_pid')
                                                ->join('student_class_result_params as p','p.pid', 'b.class_param_pid')
                                                // ->join('class_arms as a','a.pid','p.arm_pid')
                                                ->join('students as std', 'std.current_class_pid', 'p.arm_pid')
                                                ->where(['b.school_pid'=>getSchoolPid(),'std.pid'=>$pid])->where('b.status', '<>', 0)
                                                ->whereNotIn('q.pid', function ($query) use($pid) {
                                                    $query->select('question_pid')
                                                        ->from('question_answers')->where('student_pid',$pid);
                                                })
                                                ->distinct('title')
                                                ->select('s.subject','b.title','p.arm','b.pid','b.end_date','b.created_at','std.pid as std','b.type','q.path')->get();   
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


    public function loadStudentSubmittedAssessment($pid){
        $data = DB::table('question_banks as b')
        ->join('questions as q', 'q.bank_pid', 'b.pid')
        ->join('class_arm_subjects as cas', 'cas.pid', 'b.subject_pid')
        ->join('subjects as s', 's.pid', 'cas.subject_pid')
        ->join('student_class_result_params as p', 'p.pid', 'b.class_param_pid')
        // ->join('class_arms as a', 'a.pid', 'p.arm_pid')
        ->join('students as std', 'std.current_class_pid', 'p.arm_pid')
        ->where(['b.school_pid' => getSchoolPid(), 'std.pid' => $pid])->where('b.status', '<>', 0)
            ->whereIn('q.pid', function ($query) use ($pid) {
                $query->select('question_pid')
                ->from('question_answers')->where('student_pid', $pid);
            })
            ->distinct('title')
            ->select('s.subject', 'b.title', 'p.arm', 'b.pid', 'b.end_date', 'b.created_at', 'std.pid as std', 'b.type', 'q.path',
            DB::raw("(SELECT SUM(a.mark) FROM question_answers AS a WHERE a.student_pid = '" . $pid . "' AND a.question_pid = q.pid GROUP BY q.bank_pid) AS mark"))->get();
        return datatables($data)
        ->addIndexColumn()
        ->editColumn('subject', function ($data) {
            return $data->arm .' - '.$data->subject;
        })
        ->editColumn('created_at', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })
        ->addColumn('action', function ($data) {
            return view('school.assessments.student-assessment-action-button', ['data' => $data]);
        })
        ->make(true);
    }



    public function loadClassSubmittedAssessments(){
      $data = DB::table('question_banks as b')
                                                ->join('questions as q','q.bank_pid','b.pid')
                                                ->join('question_answers as an', 'an.question_pid','q.pid')
                                                ->join('students as std', 'std.pid','an.student_pid')
                                                ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                                                ->join('subjects as s','s.pid','cas.subject_pid')
                                                ->join('student_class_result_params as p','p.pid', 'b.class_param_pid')
                                                // ->join('class_arms as a','a.pid','p.arm_pid')
                                                ->where(['b.school_pid'=>getSchoolPid()])->where('b.status', '<>', 0)->orderBy('an.status')->orderBy('b.title')
                                               ->distinct('title')
                                                ->select('s.subject','b.title','p.arm','b.pid','b.end_date','an.created_at','std.pid as std','b.type','std.fullname','std.reg_number','an.status','an.mark')->get();
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
        ->join('student_class_result_params as p', 'p.pid', 'b.class_param_pid')
        // ->join('class_arms as a', 'a.pid', 'p.arm_pid')
        // ->join('terms as t', 't.pid', 'p.term_pid')
        // ->join('sessions as e', 'e.pid', 'p.session_pid')
        // ->join('students as std', 'std.current_class_pid', 'a.pid')
        ->where(['b.school_pid' => getSchoolPid(), 'b.pid' => $request->key])
            ->select('s.subject', 'b.title', 'p.arm', 'b.end_date', 'b.created_at','p.term','p.session', 'b.type','b.pid')->first();

        $questions = DB::table('questions')
        ->where(['school_pid' => getSchoolPid(), 'bank_pid' => $request->key])
            ->select('question', 'bank_pid','pid','path','mark','options','type')->inRandomOrder()->get();
        $std = $request->std;
        return view('school.assessments.attempt-assessment', compact('questions','data','std'));

    }


    // create manual Assessment 
    public function createManualAssessment(Request $request){
    //    logError($request->type);
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
                    $bank = self::createQuestionBank($request);
                if ($bank) {
                    $question = [
                        'school_pid' => getSchoolPid(),
                        'pid' => public_id(),
                        'bank_pid'=>$bank->pid,
                        'question' => $request->question,
                        'path' => null,
                        'mark' => $request->total_mark ?? null,
                        'type' => $request->type, 
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
                        return response()->json(['status' => '2', 'message' => 'Something Went Wrong...']);
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
            'assessment_type' => $request->assessment_type ,
            'recordable' => $request->recordable ? 1 : 0 ,
            'same_mark' => $request->same_mark ? 1 : 0 ,
            'category' => 1,
            'start_date' => justDate(),
            'title' => $request->title,
            'end_date'=>$request->end_date ?? null,
            'start_time' => $request->start_time ?? null,
            'end_time' => $request->end_time ?? null, 
            'teacher_pid' => $teacher->teacher_pid,
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
        // logError(($request->all()));
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
                $bank = self::createQuestionBank($request);
                if ($bank) {
                    $result = false;
                    $questions = json_decode($request->questions);
                    $question_count = count($questions);
                    // if($request->same_mark){
                    // }
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
                            'mark' => !empty($row->mark) ? $row->mark : round($request->total_mark / $question_count,2),
                            // 'mark' =>  is_array($row->mark) ? array_sum($row->mark) : 0,
                            'type' => $row->type,
                            'correct_count' => $row->count,
                            'options' => json_encode($row->options), 
    
                        ];
                        
                        $result =  $this->updateOrCreateQuestion($question);

                    }
                    
                    if ($result) {
                        DB::commit();
                        return response()->json(['status' => 1, 'message' => 'Assessment created Successfully']);
                    }
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Failed to create Assessment... ']);
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


    // load score setting 
    public function loadAssessmentTypes(Request $request){
        // load score setting 
        try {
            $data = [
                'school_pid' => getSchoolPid(),
                'session_pid' => activeSession(),
                'term_pid' => activeTerm(),
                'arm_pid' => $request->pid,
            ];
            $class = loadClassByArm($request->pid);
            $class_param_pid = ClassController::createClassParam($data); // create class param key and return the pid

            ScoreSettingsController::createClassSoreSetting(param_pid: $class_param_pid, class_pid: $class); //copy score setting from base score setting
            $scoreParams = ScoreSettingsController::loadClassScoreSettings($class_param_pid); // load class score seetting 
            $data = [];
            foreach ($scoreParams as $row) {
                $data[] = [
                    'id' => $row->assessment_title_pid,
                    'text' => $row->title .' | ' .$row->score ,
                ];
            }
            return response()->json($data);

        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
       
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
        // logError($request->all());
        // return;
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
                else if($request->type==2){
                    foreach ($request->answer as $key => $row) {
                        $data['question_pid'] = $key;
                        $data['answer'] = json_encode($row);
                        $result = $this->updateOrCreateAnswer($data);
                    }
                    if ($result)
                        return response()->json(['status' => 1, 'message' => 'Assessment Submitted Successfully']);
                    else
                        return response()->json(['status' => 'error', 'message' => ER_500]);
                }else{
                    if (isset($request->answer)) {
                        $result = false;
                        // load all questions and compare correct answer in the loop 
                        $questions = $this->loadAllQuestions($request->key);
                        foreach ($request->answer as $key => $row) {
                            $index = array_search($key, array_column($questions, 'pid')); //extract a particular question
                            $options = json_decode($questions[$index]['options']);
                            $count = $questions[$index]['correct_count'];
                            $mark = $questions[$index]['mark'];
                            $correct = 0;
                            foreach ($row as $an) {
                                foreach ($options as $opn) {
                                    if ($opn->id == $an) {
                                        if ($opn->correct) {
                                            $correct++;
                                        }
                                    }
                                }
                            }
                            if ($correct == $count) {
                                $data['mark'] = $mark;
                                $right = true;
                            } else {
                                $data['mark'] = 0;
                                $right = false;
                            }
                            $data['question_pid'] = $key;
                            $data['answer'] = json_encode(['choice' => $row, 'correct' => $right]);
                            $result = $this->updateOrCreateAnswer($data);
                        }
                        if ($result)
                            return response()->json(['status' => 1, 'message' => 'Assessment submitted Successfully']);
                        else
                            return response()->json(['status' => 'error', 'message' => ER_500]);
                    }
                }
                
                return response()->json(['status' => 'error', 'message' => 'answer question first']);

            } catch (\Throwable $e) {
                logError(['error' => $e->getMessage(), 'line' => __LINE__ , 'file' => __FILE__ ]);
                return response()->json(['status' => 'error', 'message' => ER_500]);
            }
       }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function loadAllQuestions($bankPid){
        try {
            return Question::where([ 'bank_pid' => $bankPid , 'school_pid' => getSchoolPid() ])->get(['pid','options','correct_count', 'mark'])->toArray();
        } catch (\Throwable $e) {
            logError(['error' => $e->getMessage(), 'line' => __LINE__, 'file' => __FILE__]);
            return [];
        }
    }

    private function updateOrCreateAnswer(array $data){
        try {
            return QuestionAnswer::updateOrCreate(['question_pid'=> $data['question_pid'],'student_pid' => $data['student_pid']],$data);
        } catch (\Throwable $e) {
            logError(['error' => $e->getMessage(), 'line' => __LINE__,'file'=>__FILE__]);
            return false;
        }
    }


    // load asseement for marking for a particular student
    public function loadSubmittedAssessmentsByStudent(Request $request){
        try {
            $data = DB::table('question_banks as b')
                ->join('class_arm_subjects as cas', 'cas.pid', 'b.subject_pid')
                ->join('subjects as s', 's.pid', 'cas.subject_pid')
                ->join('student_class_result_params as p', 'p.pid', 'b.class_param_pid')
                // ->join('class_arms as a', 'a.pid', 'p.arm_pid')
                // ->join('terms as t', 't.pid', 'p.term_pid')
                // ->join('sessions as e', 'e.pid', 'p.session_pid')
                ->where(['b.school_pid' => getSchoolPid(), 'b.pid' => $request->key])
                ->select('b.pid as key', 'mark',  'type', 's.subject', 'b.title', 'p.arm', 'p.term', 'p.session', 'b.end_date')->first();
            
            $questions = DB::table('questions as q')
                ->join('question_answers as an', 'an.question_pid', 'q.pid')
                ->join('students as std', 'an.student_pid', 'std.pid')
                ->where(['q.school_pid' => getSchoolPid(), 'an.student_pid' => $request->std, 'bank_pid' => $request->key])
                ->select('an.student_pid', 'an.created_at as submitted_date', 'std.fullname', 'std.reg_number', 'an.path', 'q.path as link',
                         'q.options','q.mark', 'question_pid', 'q.question','an.answer','q.type','q.pid')->get();
            
            return view('school.assessments.mark-assessment', ['questions' => $questions, 'data' => $data]);

        } catch (\Throwable $e) {
            logError(['line'=>__LINE__,'file'=>__FILE__,'error'=>$e->getMessage()]);
            return redirect()->back()->with('error','failed to load student answer');
        }        
    }
    
    // load asseement for marking 
    public function viewSubmittedAssessment(Request $request){
        try {
            $data = DB::table('question_banks as b')
                ->join('class_arm_subjects as cas', 'cas.pid', 'b.subject_pid')
                ->join('subjects as s', 's.pid', 'cas.subject_pid')
                ->join('student_class_result_params as p', 'p.pid', 'b.class_param_pid')
                // ->join('class_arms as a', 'a.pid', 'p.arm_pid')
                // ->join('terms as t', 't.pid', 'p.term_pid')
                // ->join('sessions as e', 'e.pid', 'p.session_pid')
                ->where(['b.school_pid' => getSchoolPid(), 'b.pid' => $request->key])
                ->select('b.pid as key', 'mark',  'type', 's.subject', 'b.title', 'p.arm', 'p.term', 'p.session', 'b.end_date')->first();
            
            $questions = DB::table('questions as q')
                ->join('question_answers as an', 'an.question_pid', 'q.pid')
                ->join('students as std', 'an.student_pid', 'std.pid')
                ->where(['q.school_pid' => getSchoolPid(), 'an.student_pid' => $request->std, 'bank_pid' => $request->key])
                ->select('an.student_pid', 'an.created_at as submitted_date', 'std.fullname', 'std.reg_number', 'an.path', 'q.path as link',
                         'q.options','q.mark', 'q.question','an.answer','q.type','an.mark as score')->get();
            
            return view('school.assessments.view-assessment', ['questions' => $questions, 'data' => $data]);

        } catch (\Throwable $e) {
            logError(['line'=>__LINE__,'file'=>__FILE__,'error'=>$e->getMessage()]);
            return redirect()->back()->with('error','failed to load student answer');
        }        
    }

    public function markStudentAssessment(Request $request){
        try {
            $query = DB::table('question_banks as b')
            ->join('questions as q', 'q.bank_pid', 'b.pid')->where('q.pid', $request->question_pid[0])->first(['b.mark', 'assessment_type', 'recordable', 'b.subject_pid', 'teacher_pid', 'class_param_pid']);
            if ($query->recordable == 1) {
                $param = ScoreSetting::join('assessment_titles', 'assessment_titles.pid', 'score_settings.assessment_title_pid')
                ->where([
                    'score_settings.assessment_title_pid' => $query->assessment_type
                ])->first(['title', 'score']);
                if ($query->mark != $param->score) {
                    return response()->json(['status' => 1, 'message' => 'Total Mark can not be greater than ' . $param->title.' '.$param->score]);
                }
                $data = [
                    'student_pid' => $request->std ,
                    'score' => array_sum($request->mark) ,
                    'titlePid' => $query->assessment_type ,
                    'subject' => $query->subject_pid ,
                    'class_param_pid' => $query->class_param_pid ,
                ]; 
                  
            }

            $count = count($request->question_pid);
            
            for ($i=0; $i < $count; $i++) { 
                QuestionAnswer::where(['student_pid' => $request->std, 'question_pid' => $request->question_pid[$i] ])
                ->update([ 'mark' => $request->mark[$i] , 'status' => 1 ]);
            }
            if ($query->recordable == 1) {
               
                $result = StudentScoreController::mapAssignmentToCA($data);
                if($result){
                    return response()->json(['status' => 1, 'message' => 'Score Updated and added Score to CA ']);
                }
                 return response()->json(['status' => 1, 'message' => 'Score Updated but Failed to Add to CA']);
            }
            //recordable
//             
            return response()->json(['status' => 1, 'message' => 'Score updated Successfully']);
            
        } catch (\Throwable $e) {
            logError(['line' => __LINE__ , 'file' => __FILE__ , 'error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => ER_500]);
        }
        
    }
   
}
