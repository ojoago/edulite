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
            return 'edit';// return view('school.assessments.class-assignment', ['data' => $data]);
        })
        ->make(true);
    }

    // create manual assignment 
    public function submitManualAssignment(Request $request){
       
        $validator = Validator::make($request->all(),['subject'=>'required','arm'=>'required']);

        if(!$validator->fails()){
            try {
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
                        'pid' => public_id(),
                        'note' => $request->note,
                        'mark' => $request->mark,
                        'type' => 1, //$request->type,
                        'category' => 1,
                        'start_date' => justDate(),
                        'title' => $request->title,
                        // 'end_date', 
                        // 'start_time',
                        // 'end_time', 
                        'teacher_pid' => $teacher,
                        'subject_pid' => $request->subject,
                        // 'access'=>0
                    ];
               $bank = $this->updateOrCreateQuestionBank($bank);
                if ($bank) {
                    $question = [
                        'school_pid' => getSchoolPid(),
                        'pid' => public_id(),
                        'bank_pid'=>$bank->pid,
                        'question' => $request->question,
                        'path' => $request->file,
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

    // create manual assignment 
    public function submitAutomatedAssignment(Request $request){
        logError($request->all());
        return;
        $validator = Validator::make($request->all(),['subject'=>'required','arm'=>'required']);
        if(!$validator->fails()){
            try {
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
                        'pid' => public_id(),
                        'note' => $request->note,
                        'mark' => $request->mark,
                        'type' => 1, //$request->type,
                        'category' => 1,
                        'start_date' => justDate(),
                        'title' => $request->title,
                        // 'end_date', 
                        // 'start_time',
                        // 'end_time', 
                        'teacher_pid' => $teacher,
                        'subject_pid' => $request->subject,
                        // 'access'=>0
                    ];
               $bank = $this->updateOrCreateQuestionBank($bank);
                if ($bank) {
                    $question = [
                        'school_pid' => getSchoolPid(),
                        'pid' => public_id(),
                        'bank_pid'=>$bank->pid,
                        'question' => $request->question,
                        'path' => $request->file,
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

    private function updateOrCreateQuestionBank(array $data){
        try {
            return QuestionBank::updateOrCreate(['pid' => $data['pid']],$data);
        } catch (\Throwable $e) {
            logError(['error'=>$e->getMessage(),'line'=>__LINE__]);
        }
    }
    private function updateOrCreateQuestion(array $data){
        try {
            return Question::updateOrCreate(['pid'=>$data['pid'],'bank_pid'=>$data['bank_pid']],$data);
        } catch (\Throwable $e) {
            logError(['error'=>$e->getMessage(),'line'=>__LINE__]);
        }
    }


    // manual assignment ends here 
}
