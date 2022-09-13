<?php

namespace App\Http\Controllers\School\Framework\Assessment;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Assessment\ScoreSetting;
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
        $data = ScoreSetting::join('score_setting_params', 'score_setting_params.pid', 'score_data_pid')
                            ->join('terms','terms.pid', 'score_setting_params.term_pid')
                            ->join('classes','classes.pid', 'score_setting_params.class_pid')
                            ->join('sessions','sessions.pid', 'score_setting_params.session_pid')
                            ->join('assessment_titles', 'assessment_titles.pid', 'assessment_title_pid')
                            ->where(['score_setting_params.school_pid'=>getSchoolPid()])
                            ->orderBy('score_setting_params.id','DESC')
                            ->get(['session','term','title','order','type','class','score', 'score_setting_params.updated_at']);
        return datatables($data)
        ->editColumn('date',function($data){
            return $data->updated_at->diffForHumans();
        })->editColumn('type',function($data){
            return $data->type == 1 ? 'General' : 'Mid-term';
        })
        
        ->make(true);
    }
    public function createScoreSettings(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'session_pid'=>'required|string',
            'class_pid' => 'required|string',
            'term_pid' => 'required|string',
            'title_pid' => 'required|array|min:1',
            // 'title_pid.*' => 'required',
            // 'score.*' => 'required|min:1|numeric',
            'score' => 'required|array|min:1',
        ],[
            'session_pid.required'=>'Select Session',
            'class_pid.required'=>'Select class',
            'term_pid.required'=>'Select term',
            'title_pid.required'=>'Select all title or remove unselected',
             'score.required'=>'Enter all score or remove empty rows',
             'score.numeric'=>'all Scores must be a number',
            ]);
        
       if(!$validator->fails()){
        if ($this->getTotalScore($request->score) != 100) {

            return response()->json(['status' => 'error', 'message' => 'Sum of scores should must be equal to 100']);
        }
        $schoolPid = getSchoolPid();
            $data = [
                'school_pid' => $schoolPid,
                'pid' => public_id(),
                'session_pid' => $request->session_pid,
                'class_pid' => $request->class_pid,
                'term_pid' => $request->term_pid,
                'staff_pid' => getSchoolUserPid()
            ];
            // $count = count($data['title_pid']);
            $duplicate = ScoreSettingParam::where([
                'session_pid'=>$data['session_pid'], 
                'class_pid' => $data['class_pid'], 
                'term_pid' => $data['term_pid'], 
                ])->pluck('pid')->first();
                
                // return response()->json($duplicate);
                $result = $this->createOrUpdateScoreSettingParam($data);
            
                if ($result) {
                    $value = [
                        'title_pid'=>$request->title_pid,
                        'score'=>$request->score,
                        'mid'=>$request->mid,
                        'school_pid'=>$schoolPid,
                        'score_data_pid'=>$result->pid
                    ];
                    $msg = 'Score Settings Created Successfully';
                    if ($duplicate) {
                        $msg = 'Score Settings Updated Successfully';
                        $value['score_data_pid'] = $duplicate;
                    }
                    $result = $this->createOrUpdateScoreSetting($value);
                    return response()->json(['status'=>1, 'message'=>$msg]);
                }
            // return response()->json(['status'=>'error','message'=>'Score Setting Already Exists']);
           
       }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function createOrUpdateScoreSettingParam($data)
    {
        try {
            return  ScoreSettingParam::updateOrCreate([
                'session_pid' => $data['session_pid'],
                'class_pid' => $data['class_pid'],
                'term_pid' => $data['term_pid'],
                'school_pid' => $data['school_pid']
            ], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }
    private function createOrUpdateScoreSetting($data)
    {
        $row = [
            'score_data_pid'    =>  $data['score_data_pid'],
            'school_pid'        =>  getSchoolPid(),
        ];
        try {
            $count = count($data['title_pid']);
            for ($i=0; $i <$count; $i++) { 
                if(!(empty($data['title_pid'][$i]) and empty($data['score'][$i]))){
                    $row['score'] = $data['score'][$i];
                    $row['assessment_title_pid'] = $data['title_pid'][$i];
                    $row['type'] = $data['mid'][$i] ?? 1;
                    $row['order'] = $i+1;
                    $row['pid'] = public_id();
                    $result = ScoreSetting::updateOrCreate([
                        'score_data_pid' => $row['score_data_pid'],
                        'assessment_title_pid' => $row['assessment_title_pid'],
                         'school_pid' => $data['school_pid']
                        ], $row);
                }
            }
            return $result;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
           
        }
    }

    public function getTotalScore($score){
        $sum = 0;
        for ($i=0; $i < count($score); $i++) { 
            $sum+=$score[$i];
        }
        return $sum;
    }

    public static function loadClassScoreSettings($term,$session,$arm){
        $scoreParams = ScoreSettingParam::join('class_arms', 'class_arms.class_pid', 'score_setting_params.class_pid')
        ->join('score_settings', 'score_data_pid', 'score_setting_params.pid')
        ->join('assessment_titles', 'assessment_titles.pid', 'score_settings.assessment_title_pid')
        ->orderBy('order')
            ->where([
                'term_pid' => $term,
                'session_pid' => $session,
                'class_arms.pid' => $arm
            ])->get(['title', 'score', 'assessment_title_pid']);
        return $scoreParams;
    }
}
