<?php

namespace App\Http\Controllers\School\Student\Assessment\AffectiveDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\Framework\Psycho\AffectiveDomain;
use App\Http\Controllers\School\Framework\ClassController;
use App\Models\School\Student\Assessment\AffectiveDomain\AffectiveDomainRecord;

class AffectiveDomainController extends Controller
{

    public function loadAffecitveKeys(Request $request){
        $data = [
            'session_pid' => $request->session,
            'term_pid' => $request->term,
            'arm_pid' => $request->arm,
            'school_pid' => getSchoolPid()
        ];
        $class_pid = ClassController::createCLassParam($data);
        $arm = ClassController::getClassArmNameByPid($request->arm);
        $params = ['param' => $class_pid, 'arm' => $arm, 'term' => $request->term, 'session' => $request->session];
        $domain = AffectiveDomain::where(['school_pid' => getSchoolPid(), 'status' => 1])
        ->get(['title', 'pid', 'max_score']);
        $data = Student::where([
            'current_class' => $request->arm,
            'school_pid' => getSchoolPid(),
            'current_session_pid' => $request->session
        ])->get([
            'fullname', 'reg_number', 'pid',
            // 'student_score_sheets.ca_type_pid', 'student_score_sheets.score'
        ]);
        return view('school.student.affective.record-affective', compact('data', 'domain', 'params'));
    }

    // 
    public function recordAffectiveDomainScore(Request $request)
    {
        $data = [
            'student_pid' => $request->student_pid,
            'key_pid' => $request->key_pid,
            'score' => $request->score,
            'school_pid' => getSchoolPid(),
            'class_param_pid' => $request->param
        ];

        $dupParams = $data;
        unset($dupParams['score']);
        $result = AffectiveDomainRecord::updateOrCreate($dupParams, $data);
        if ($result) {
            return 'Score recorded';
        }
        return 'Score not recorded';
    }
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
