<?php

namespace App\Http\Controllers\School\Framework\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Grade\GradeKey;
use App\Models\School\Framework\Grade\SchoolGrade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GradeKeyController extends Controller
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
       
        $data = GradeKey::where('school_pid', getSchoolPid())->get(['title','grade','grade_point','remark','min_score','max_score','created_at','pid']);
        return datatables($data)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->make(true);
      
    }
    public function createGradeKey(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'title'=>[
                    'required', 'string', 'max:15',
                    Rule::unique('grade_keys')->where(function($param) use ($request){
                            $param->where([
                                'term_pid'=>$request->term_pid,
                                'class_pid'=>$request->class_pid,
                                'school_pid'=>getSchoolPid()
                            ])->where('pid','!=',$request->pid);
            })],
            'min_score'=>'required|numeric|min:0|max:99',
            'max_score'=>'required|numeric|min:1|max:100',
            'grade'=>['required','max:3', 'string',Rule::unique('grade_keys')->where(function($param) use ($request){
                            $param->where([
                                'term_pid'=>$request->term_pid,
                                'class_pid'=>$request->class_pid,
                                'school_pid'=>getSchoolPid()
                            ])->where('pid','!=',$request->pid);
                        })],
            'grade_point'=>'nullable|numeric',
            'session_pid'=>'required|string',
            'class_pid'=>'required|string',
            'term_pid'=>'required|string',
        ],[
            'title.required'=>'Enter Grade Title',
            'grade.required'=>'Enter Grade key e.g A',
            'grade.max'=>'3 letters at most',
            'min_score.required'=>'Enter Grade Minimum Score',
            'min_score.numeric'=>'Minimum Score must be a number',
            'max_score.required'=>'Enter Grade Maximum Score',
            'max_score.numeric'=>'Maximum Score must be a number',
            'session_pid.required'=>'Select Academic Session',
            'class_pid.required'=>'Select Class',
            'term_pid.required'=>'Select Term',
        ]);
        if(!$validator->fails()){
            $data = [
                'title'=>$request->title,
                'min_score'=>$request->min_score,
                'max_score'=>$request->max_score,
                'grade'=>$request->grade,
                'grade_point'=>$request->grade_point,
                'category_pid'=>$request->category_pid,
                'session_pid'=>$request->session_pid,
                'class_pid'=>$request->class_pid,
                'term_pid'=>$request->term_pid,
                'color'=>$request->color,
                'remark'=>$request->remark,
                'school_pid'=>getSchoolPid(),
                'staff_pid'=>getSchoolUserPid(),
            ];
            $pid = $this->createSchoolGrade($data);
            $data['grade_pid'] = $pid;
            $data['pid'] = public_id();
            try {
                $result = GradeKey::create($data);
                if($result){
                    
                    return response()->json(['status'=>1, 'message'=>'grade created']);
                }
                return response()->json(['status'=>2, 'message'=>'Something Went Wrong']);
            } catch (\Throwable $e) {
                $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
                logError($error);
                return response()->json(['status'=>'error', 'message'=>'Something Went Wrong']);
            }
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function createSchoolGrade($data){
        try {
            $data['pid'] = public_id();
            $data = SchoolGrade::create($data);
            return $data->pid;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }
}
