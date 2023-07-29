<?php

namespace App\Http\Controllers\School\Class;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Assessment\Question;
use App\Models\School\Assessment\QuestionBank;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Framework\ClassController;

class AssignmentController extends Controller
{

    // manual assignment goes here 
    // StudentClassScoreParam
    public function loadAssignment(){
        $data = DB::table('question_banks as b')->join('questions as q','q.bank_pid','b.pid')
                                                ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                                                ->join('subjects as s','s.pid','cas.subject_pid')
                                                ->join('student_class_score_params as p','p.pid', 'b.class_param_pid')
                                                ->join('class_arms as a','a.pid','p.arm_pid')
                                                ->where(['b.school_pid'=>getSchoolPid()])
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
            return view('school.assessments.class-assignment-action-button', ['data' => $data]);
        })
        ->make(true);
    }
    public function loadAssignmentForStudent($pid){
        $data = DB::table('question_banks as b')->join('questions as q','q.bank_pid','b.pid')
                                                ->join('class_arm_subjects as cas','cas.pid','b.subject_pid')
                                                ->join('subjects as s','s.pid','cas.subject_pid')
                                                ->join('student_class_score_params as p','p.pid', 'b.class_param_pid')
                                                ->join('class_arms as a','a.pid','p.arm_pid')
                                                ->join('students as std', 'std.current_class_pid','a.pid')
                                                ->where(['b.school_pid'=>getSchoolPid(),'std.pid'=>base64Decode($pid)])
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
            return view('school.assessments.class-assignment-action-button', ['data' => $data]);
        })
        ->make(true);
    }

    public function loadQuestions($pid){
        dd($pid);
    }
    // create manual assignment 
    public function submitManualAssignment(Request $request){
       
        $validator = Validator::make($request->all(),['subject'=>'required','arm'=>'required', 'end_date' => 'required','title'=>'required']);

        if(!$validator->fails()){
            try {
                
               $bank = $this->createQuestionBank($request);
                if ($bank) {
                    $question = [
                        'school_pid' => getSchoolPid(),
                        'pid' => public_id(),
                        'bank_pid'=>$bank->pid,
                        'question' => $request->question,
                        'path' => $request->file ?? null,
                        'mark' => $request->mark ?? null,
                        // 'type', 
                        // 'options'
                    ];
                   $result =  $this->updateOrCreateQuestion($question);
                   if($result){
                       return response()->json(['status' => 1, 'message' => 'Assignment created Successfully']);
                   }
                }
            } catch (\Throwable $e) {
                logError(['error' => $e->getMessage(), 'line' => __LINE__]);
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
            // 'access'=>0
        ];
        return (new self)->updateOrCreateQuestionBank($bank);
    }

 
    // create automated assignment 
    public function submitAutomatedAssignment(Request $request){
        // logError(json_decode($request->questions));
        // return;
        $validator = Validator::make($request->all(),
                                ['subject'=>'required','arm'=>'required', 'title'=>'required', 'end_date'=>'required']
                            );
        if(!$validator->fails()){
            try {

                $bank = $this->createQuestionBank($request);
                if ($bank) {
                    $result = false;
                    $questions = json_decode($request->questions);
                    foreach($questions as $row){
                        if(empty($row->question) || count($row->options)<2){
                            continue;
                        }
                        $question = [
                            'school_pid' => getSchoolPid(),
                            'pid' => $row->pid ?? public_id(),
                            'bank_pid' => $bank->pid,
                            'question' => $row->question,
                            'path' => $request->file ?? null,
                            'mark' =>  is_array($row->mark) ? array_sum($row->mark) : 0,
                            'type' => $row->type,
                            'options' => ($row->options), 
    
                        ];
                        $result =  $this->updateOrCreateQuestion($question);
                    }
                    
                    if ($result) {
                        return response()->json(['status' => 1, 'message' => 'Assignment created Successfully']);
                    }
                    return response()->json(['status' => 'error', 'message' => 'Enter all Questions and at least two options for each.']);
                }
            } catch (\Throwable $e) {
                logError(['error' => $e->getMessage(), 'line' => __LINE__]);
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


    // manual assignment ends here 
}
