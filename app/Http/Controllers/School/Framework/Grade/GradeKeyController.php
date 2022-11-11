<?php

namespace App\Http\Controllers\School\Framework\Grade;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Grade\GradeKey;
use App\Models\School\Framework\Grade\SchoolGrade;
use App\Models\School\Framework\Grade\GradeKeyBase;

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
       
        $data = GradeKeyBase::where('school_pid', getSchoolPid())->get(['title','grade','grade_point','remark','min_score','max_score','created_at','pid']);
        return datatables($data)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->make(true);
      
    }
    public function loadGradeKeyByClass()
    {
       
        $data = DB::table("grade_keys as k")
                    ->join('student_class_score_params as p','p.pid','k.class_param_pid')
                    ->join('terms as t','t.pid','p.term_pid')
                    ->join('sessions as s','s.pid','p.session_pid')
                    ->join('class_arms as a','a.pid','p.arm_pid')
                ->where('k.school_pid', getSchoolPid())
                ->select('title', 'grade', 'grade_point', 'remark', 'min_score', 'max_score', 'k.created_at', 'a.arm','term','session')->get();
        // $data = GradeKey::where('school_pid', getSchoolPid())->get(['title','grade','grade_point','remark','min_score','max_score','created_at','pid']);
        return datatables($data)
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->make(true);
      
    }
    public function createGradeKey(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'title.*'=>'required|min:1|max:15',
            // 'title'=>'required|string|max:15',
            'min_score.*'=>'required|numeric|min:0',
            // 'min_score'=>'required|numeric|min:0|max:99',
            'max_score.*'=>'required|numeric|min:1|max:100',
            // 'max_score'=>'required|numeric|min:1|max:100',
            'grade.*'=>'required|string|min:1',
            // 'grade'=>'required|max:3|string',
            // 'grade_point'=>'nullable|numeric',
            'class_pid'=>'required|string',
        ],[
            'title.required'=>'Enter Grade Title',
            'title.*.required'=>'Enter this Grade Title',
            'grade.required'=>'Enter Grade key e.g A',
            'grade.*.required'=>'Enter this Grade key e.g A',
            'grade.max'=>'3 letters at most',
            'min_score.*.required'=>'Enter this Grade Minimum Score',
            'min_score.required'=>'Enter Grade Minimum Score',
            'min_score.numeric'=>'Minimum Score must be a number',
            'max_score.*.required'=>'Enter this Grade Maximum Score',
            'max_score.required'=>'Enter Grade Maximum Score',
            'max_score.numeric'=>'Maximum Score must be a number',
            'class_pid.required'=>'Select Class',
        ]);
        if(!$validator->fails()){
            $data = [
                'titles'=>$request->title,
                'min'=>$request->min_score,
                'max'=>$request->max_score,
                'grades'=>$request->grade,
                // 'grade_point'=>$request->grade_point,
                // 'category_pid'=>$request->category_pid,
                // 'session_pid'=>$request->session_pid,
                'class_pid'=>$request->class_pid,
                // 'term_pid'=>$request->term_pid,
                // 'color'=>$request->color,
                // 'remark'=>$request->remark,
                // 'school_pid'=>getSchoolPid(),
                // 'staff_pid'=>getSchoolUserPid(),
            ];
            // $pid = $this->createSchoolGrade($data);
            // $data['grade_pid'] = $pid;
            $data['pid'] = public_id();
            try {
                $result =    $this->updateOrCreateGradeBase($data);
                if($result){
                    return response()->json(['status'=>1, 'message'=>'grade created']);
                }
                return response()->json(['status'=>2, 'message'=>'Something Went Wrong']);
            } catch (\Throwable $e) {
                $error =  $e->getMessage();
                logError($error);
                return response()->json(['status'=>'error', 'message'=>'Something Went Wrong']);
            }
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function updateOrCreateGradeBase($data){
        try {
            $dupParam = $row = [
                'class_pid'=>$data['class_pid'],
                'school_pid'=>getSchoolPid(),
                'staff_pid'=>getSchoolUserPid()
            ];
            unset($dupParam['staff_pid']);
            $count = count($data['titles']);
            for ($i=0; $i < $count; $i++) { 
                $row['min_score'] = $data['min'][$i];
                $row['max_score'] = $data['max'][$i];
                $dupParam['grade'] = $row['grade'] = $data['grades'][$i];
                $row['title'] = $data['titles'][$i];
                $row['pid'] = public_id();
                $grd = GradeKeyBase::updateOrCreate($dupParam,$row);
            }
            return $grd;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }


    public static function createClassGradeKey($param_pid, $class_pid, $arm_pid = null)
    {
        $prm = GradeKey::where(['class_param_pid' => $param_pid, 'school_pid' => getSchoolPid()])->first('class_param_pid');
        if ($prm) {
            return;
        }
        $stn = self::loadClassGrade($class_pid, $arm_pid);
        $data = [];
        foreach ($stn as $item) {
            $dtn = $item->toArray();
            $dtn['class_param_pid'] = $param_pid;
            $dtn['pid'] = public_id();
            $dtn['updated_at'] = $dtn['created_at'] = date('Y-m-d H:i:s');
            $data[] = $dtn;
        }
        GradeKey::insert($data);
        return;
    }

    private static function loadClassGrade($class_pid, $arm_pid)
    {
        $data = GradeKeyBase::where(['class_pid' => $class_pid, 'arm_pid' => $arm_pid, 'school_pid' => getSchoolPid()])
            ->get(['school_pid', 'title', 'grade', 'grade_point', 'remark','min_score','max_score','color']);
        return $data;
    }
}
