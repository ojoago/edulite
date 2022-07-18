<?php

namespace App\Http\Controllers\School\Framework\Assessment;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Assessment\AssesmentTitle;
use App\Models\School\Framework\Assessment\ScoreSetting;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Term\Term;
use Illuminate\Http\Request;

class AssessmentTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session = Session::where('school_pid',getSchoolPid())->get(['pid','session']);//
        $data = AssesmentTitle::where('school_pid',getSchoolPid())->get(['pid','title']);//
        $term = Term::where('school_pid',getSchoolPid())->get(['pid','term']);//
        $classes = Classes::where('school_pid',getSchoolPid())->get(['pid','class']);//
        $arm = ClassArm::where('school_pid',getSchoolPid())->get(['pid','arm']);//class arm
        $score = ScoreSetting::where('school_pid',getSchoolPid())->get(['pid','score']);//class arm
        return view('school.framework.assessment.index',compact('data','session','term','classes','arm'));
    }
    public function createAssessmentTitle(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
            'category'=>'required|string',
        ]);
        $request['school_pid'] = getSchoolPid();
        $request['staff_pid'] = getUserPid();
        $request['pid'] = public_id();
        $result = $this->createOrUpdateAssesmentTitle($request->all());
        if($result){
            return redirect()->back()->with('success','Title created');
        }
        return redirect()->back()->with('error','failed to create title');
    }

    private function createOrUpdateAssesmentTitle($data)
    {
        try {
            return  AssesmentTitle::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
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
