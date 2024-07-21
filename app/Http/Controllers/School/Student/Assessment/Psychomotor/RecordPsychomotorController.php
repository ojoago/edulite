<?php

namespace App\Http\Controllers\School\Student\Assessment\Psychomotor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\Student\Result\StudentClassResult;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentScoreController;
use App\Models\School\Framework\Psychomotor\PsychomotorKey;
use App\Models\School\Framework\Psychomotor\PsychomotorBase;
use App\Models\School\Student\Assessment\Psychomotor\PsychomotorRecord;

class RecordPsychomotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function loadPsychomotoKeys(Request $request){
        $data = [
            'session_pid'=>activeSession(),
            'term_pid'=>activeTerm(),
            'arm_pid'=>$request->arm,
            'school_pid'=>getSchoolPid()
        ];
        $class_pid = ClassController::createClassParam($data);
        $arm = ClassController::getClassArmNameByPid($request->arm);
        $base = PsychomotorBase::where(['school_pid' => getSchoolPid(), 'pid' => $request->psychomotor_pid])->first(['obtainable_score as score', 'psychomotor', 'pid']);
        // dd($base);
        $params = ['param'=>$class_pid,'arm'=>$arm,'term'=>$request->term,'session'=>$request->session];
        $psycho = PsychomotorKey::where(['school_pid'=>getSchoolPid(),'status'=>1, 'psychomotor_pid'=>$request->psychomotor_pid])
                                ->get(['title', 'pid', 'max_score']);//->dd();
        $data = Student::where([
            'current_class_pid' => $request->arm,
            'school_pid' => getSchoolPid(),
            'current_session_pid' => activeSession(),
           'status' => 1
        ])->get([
            'fullname', 'reg_number', 'pid',
        ]);
        
        if($psycho->isNotEmpty() && $data->isNotEmpty()){            
            return view('school.student.psychomotor.record-psychomotor',compact('data','psycho','params', 'base'));
        }
        
        if($psycho->isEmpty()){
            return redirect()->back()->with('warning','Contact Admin to add key to '. $base->psychomotor);
        }

        if($data->isEmpty()){
            return redirect()->back()->with('info', 'No Student in the selected class');
        }

    }


    public function loadPsychomotoScore(Request $request){
        $data = [
            'session_pid' => activeSession(),
            'term_pid' => activeTerm(),
            'arm_pid' => $request->arm,
            'school_pid' => getSchoolPid()
        ];
        $param = ClassController::createClassParam($data);
        $arm = ClassController::getClassArmNameByPid($request->arm);
        $title = PsychomotorBase::where(['school_pid' => getSchoolPid(), 'status' => 1, 'pid' => $request->psychomotor_pid])->pluck('psychomotor')->first();

        $psycho = PsychomotorKey::where(['school_pid' => getSchoolPid(), 'status' => 1, 'psychomotor_pid' => $request->psychomotor_pid])
            ->get(['title', 'pid', 'max_score']);
        $data = Student::where([
            'current_class_pid' => $request->arm,
            'school_pid' => getSchoolPid(),
            'current_session_pid' => $request->session
        ])->get([
            'fullname', 'reg_number', 'pid',
        ]);
        return view('school.student.psychomotor.view-extra-curricular-score', compact('data', 'psycho', 'param', 'title','arm'));
    }

    public function recordPsychomotorScore(Request $request){
        $data = [
            'student_pid' => $request->student_pid,
            'key_pid' => $request->key_pid,
            'score' => $request->score,
            'school_pid' => getSchoolPid(),
            'class_param_pid' => $request->param
        ];
        try {

            $dupParams = $data;
            unset($dupParams['score']);
            $result = PsychomotorRecord::updateOrCreate($dupParams, $data);
            if ($result) {
                $param = [
                    'class_param_pid' => $data['class_param_pid'],
                    'student_pid' => $data['student_pid'],
                    // 'total' => 0,
                    'school_pid' => $data['school_pid']
                ];
                $exists = StudentClassResult::where($param)->exists();
                // logError($exists);
                if (!$exists) {
                    $param['total'] = 0;
                    StudentScoreController::computeClassResultForNonExaminableClass($param);
                }

                return 'Score recorded';
            }
            return 'Score not recorded';
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return 'Something Went Wrong... error logged';
        }
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
