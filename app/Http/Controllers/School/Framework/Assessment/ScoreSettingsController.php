<?php

namespace App\Http\Controllers\School\Framework\Assessment;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Assessment\ScoreSetting;
use Illuminate\Http\Request;

class ScoreSettingsController extends Controller
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
    public function createScoreSettings(Request $request)
    {
        $request->validate([
            'assessment_type_pid'=>'required|string',
            'session_pid'=>'required|string',
            'class_arm_pid'=>'required|string',
            'term_pid'=>'required|string',
            'score'=>'required|numeric',
            'type'=>'required',
            'order'=>'required',
        ]);
        $request['school_pid'] = getSchoolPid();
        $request['staff_pid'] = getUserPid();
        $request['pid'] = public_id();
        $result = $this->createOrUpdateScoreSetting($request->all());
        if($result){
            return redirect()->route('school.assessment.title')->with('success','score setting created');
        }
        return redirect()->route('school.assessment.title')->with('error','failed error');
    }

    private function createOrUpdateScoreSetting($data)
    {
        try {
            return  ScoreSetting::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
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
