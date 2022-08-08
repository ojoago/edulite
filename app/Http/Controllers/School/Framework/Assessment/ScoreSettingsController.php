<?php

namespace App\Http\Controllers\School\Framework\Assessment;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Assessment\ScoreSetting;
use App\Models\School\Framework\Assessment\ScoreSettingData;
use App\Models\School\Framework\Assessment\ScoreSettingParam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return response()->json(['status' => 2, 'message' => $request->all()]);
        $validator = Validator::make($request->all(),[
            'session_pid'=>'required|string',
            'class_pid' => 'required|string',
            'term_pid' => 'required|string',
            'title_pid' => 'required|array|min:1',
            'title_pid.*' => 'required',
            'score' => 'required|min:1',
            'score.*' => ['required|array|numeric|min:1'],
        ],[
            'session_pid.required'=>'Select Session',
            'class_pid.required'=>'Select class',
            'term_pid.required'=>'Select term',
            'title_pid.required'=>'Select all title or remove unselected',
             'score.required'=>'Enter all score or remove empty rows',
             'score.numeric'=>'Scores must be a number',
            ]);
       if(!$validator->fails()){
            $data = [
                'school_pid'=>getSchoolPid(),
                'staff_pid'=>getSchoolUserPid(),
                'pid'=>public_id(),
                'class_pid'=>'',
                'session_pid'=> 'session_pid',
                'title_pid'=> 'title_pid',
                'score'=> 'score',
                'mid'=> 'mid',
            ];
            // $count = count($data['title_pid']);
            // return response()->json(['status' => 2, 'message' => $data['title_pid']]);
            $duplicate = ScoreSettingParam::where([
                'session_pid'=>$data['session_pid'], 
                'class_pid' => $data['class_pid'], 
                'title_pid' => $data['title_pid']
                ])->first('id');
            if(!$duplicate){
                $result = $this->createOrUpdateScoreSetting($request->all());
                if ($result) {
                    return redirect()->route('school.assessment.title')->with('success', 'score setting created');
                }
            }
            return response()->json(['status'=>2,'message'=>'Score Setting Already Exists']);
           
       }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function createOrUpdateScoreSettingParam($data)
    {
        try {
            return  ScoreSettingParam::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    private function createOrUpdateScoreSetting($data)
    {
        try {
            // for ($i=0; $i <; $i++) { 
            //     # code...
            // }
            return  ScoreSettingParam::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
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
