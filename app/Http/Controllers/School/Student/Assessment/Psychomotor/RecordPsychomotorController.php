<?php

namespace App\Http\Controllers\School\Student\Assessment\Psychomotor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\Framework\Psycho\Psychomotor;
use App\Http\Controllers\School\Framework\ClassController;
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
            'session_pid'=>$request->session,
            'term_pid'=>$request->term,
            'arm_pid'=>$request->arm,
            'school_pid'=>getSchoolPid()
        ];
        $class_pid = ClassController::createCLassParam($data);
        $arm = ClassController::getClassArmNameByPid($request->arm);
        $params = ['param'=>$class_pid,'arm'=>$arm,'term'=>$request->term,'session'=>$request->session];
        $psycho = Psychomotor::where(['school_pid'=>getSchoolPid(),'status'=>1])
                                ->get(['title', 'pid', 'max_score']);
        $data = Student::where([
            'current_class' => $request->arm,
            'school_pid' => getSchoolPid(),
            'current_session_pid' => $request->session
        ])->get([
            'fullname', 'reg_number', 'pid',
            // 'student_score_sheets.ca_type_pid', 'student_score_sheets.score'
        ]);
        return view('school.student.psychomotor.record-psychomotor',compact('data','psycho','params'));
    }
    public function recordPsychomotor(Request $request){
        $data = [
            'session_pid'=>$request->session,
            'term_pid'=>$request->term,
            'arm_pid'=>$request->arm,
            'school_pid'=>getSchoolPid()
        ];
        $class_pid = ClassController::createCLassParam($data);
        $arm = ClassController::getClassArmNameByPid($request->arm);
        $psycho = Psychomotor::where(['school_pid'=>getSchoolPid(),'status'=>1])
                                ->get(['title', 'pid', 'max_score']);
        return view('student.assessment.psychomotor.record-psychomotor',compact('data'));
    }

    public function recordPsychomotorScore(Request $request){
        $data = [
            'student_pid'=>$request->student_pid,
            'key_pid'=>$request->key_pid,
            'score'=>$request->score,
            'school_pid'=>getSchoolPid(),
            'class_param_pid'=>$request->param
        ];

        $dupParams = $data;
        unset($dupParams['score']);
        $result = PsychomotorRecord::updateOrCreate($dupParams,$data);
        if($result){
            return 'Score recorded';
        }
        return 'Score not recorded';
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
