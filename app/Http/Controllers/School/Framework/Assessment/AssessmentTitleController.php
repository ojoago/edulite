<?php

namespace App\Http\Controllers\School\Framework\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Assessment\AssessmentTitle;
use Illuminate\Validation\Rule;

class AssessmentTitleController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $session = Session::where('school_pid',getSchoolPid())->get(['pid','session']);//
        $data = AssessmentTitle::where('school_pid',getSchoolPid())
                    ->get(['pid','title','description','category','created_at']); //
        // $term = Term::where('school_pid',getSchoolPid())->get(['pid','term']);//
        // $classes = Classes::where('school_pid',getSchoolPid())->get(['pid','class']);//
        // $arm = ClassArm::where('school_pid',getSchoolPid())->get(['pid','arm']);//class arm
        // $score = ScoreSetting::where('school_pid',getSchoolPid())->get(['pid','score'])->dd();//class arm
        return datatables($data)
        // ->editColumn('date', function ($data) {
        //     return $data->created_at->diffForHumans();
        // })->editColumn('category', function ($data) {
        //     return $data->category == 2 ? 'Mid-Term' : 'General';
        // })
        ->addColumn('action',function($data){
            return view('school.framework.assessment.title-action-button',['data'=>$data]);

        })
        ->make(true);
        // return view('school.framework.assessment.index',compact('data','session','term','classes','arm'));
    }
    
    
    public function createAssessmentTitle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title.*' =>['required','regex:/^[a-zA-Z0-9_\s]+$/',
                //         Rule::unique('assessment_titles')->where(function($param){
                //         $param->where('school_pid',getSchoolPid());
                // })
        ],
            'category' => 'required|int',
        ],['title.regex'=>'only letters and numbers is allowed', 'title.unique'=> 'title already exists']);
        
        if(!$validator->fails()){
            // $request['school_pid'] = getSchoolPid();
            // $request['staff_pid'] = getUserPid();
            // $request['pid'] = public_id();
            $data = [
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid(),
                'pid' => public_id(),
                'category'=>$request->category,
            ];
            $count = count($request->title);
            for ($i=0; $i < $count; $i++) {
                $data['title'] = $request->title[$i];
                $data['description'] = $request->description[$i];
                $data['pid'] = public_id();
                $result = $this->createOrUpdateAssesmentTitle($data);
            }
            
            if ($result) {
                return response()->json(['status'=>1,'message'=> 'Title Created']);
            }
        
            return response()->json(['status'=>2,'message'=> 'failed to create title']);
        
        }

        return response()->json(['status'=>0,'error'=> $validator->errors()->toArray()]);
        
    }
    
    public function updateAssessmentTitle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' =>['required','regex:/^[a-zA-Z0-9_\s]+$/',
                        Rule::unique('assessment_titles')->where(function($param) use($request) {
                        $param->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid);
                })
        ],
        ],['title.regex'=>'only letters and numbers is allowed', 'title.unique'=> 'title already exists']);
        
        if(!$validator->fails()){
            try {
                $asmt = AssessmentTitle::where(['pid' => $request->pid, 'school_pid' => getSchoolPid()])->first();
                $asmt->title = $request->title;
                $asmt->description = $request->description;
                $result = $asmt->save();
                if ($result) {
                    return response()->json(['status' => 1, 'message' => 'Title Updated!']);
                }
                return response()->json(['status' => 2, 'message' => 'failed to update title']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Something went Wrong... error logged']);
            }
        }

        return response()->json(['status'=>0,'error'=> $validator->errors()->toArray()]);
    }


    public function deleteAssessmentTitle(Request $request)
    {
       
        try {
            $asmt = AssessmentTitle::where(['pid' => $request->pid, 'school_pid' => getSchoolPid()])->first();
            $asmt->title = $request->title;
            $asmt->description = $request->description;
            $result = $asmt->save();
            if ($result) {
                return response()->json(['status' => 1, 'message' => 'Title Updated!']);
            }
            return response()->json(['status' => 2, 'message' => 'failed to update title']);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went Wrong... error logged']);
        }

    }

    private function createOrUpdateAssesmentTitle($data)
    {
        try {
            return  AssessmentTitle::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    
}
