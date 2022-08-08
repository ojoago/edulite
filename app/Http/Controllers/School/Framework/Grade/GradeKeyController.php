<?php

namespace App\Http\Controllers\School\Framework\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Grade\GradeKey;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Grade\SchoolGrade;
use Illuminate\Support\Facades\Validator;

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
            ->addColumn('action', function ($data) {
                $html = '<a href="/reminders/' . $data->pid . '/done"><button class="btn btn-primary" type="submit" data-toggle="tooltip" title="Edit Session"><i class="bi bi-box-arrow-up" aria-hidden="true"></i></button></a>';
                return $html;
            })
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->rawColumns(['data', 'action'])
            ->make(true);
      
    }
    public function createGradeKey(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'title'=>'required|string|max:15',
            'min_score'=>'required|numeric|min:0|max:99',
            'max_score'=>'required|numeric|min:1|max:100',
            'grade'=>'required|string',
            'grade_point'=>'required|int',
            'session_pid'=>'required|string',
            'class_pid'=>'required|string',
            'term_pid'=>'required|string',
        ],[
            'title.required'=>'Enter Grade Title',
            'grade.required'=>'Enter Grade key e.g A ',
            'min_score.required'=>'Enter Grade Minimum Score',
            'min_score.numeric'=>'Minimum Score must be a number',
            'max_score.required'=>'Enter Grade Maximum Score',
            'max_score.numeric'=>'Maximum Score must be a number',
            'session_pid.reqiured'=>'Select Academic Session',
            'class_pid.reqiured'=>'Select Class',
            'term_pid.reqiured'=>'Select Term',
        ]);
        if(!$validator->fails()){
            $data = [
                'title'=>strtoupper($request->title),
                'min_score'=>$request->min_score,
                'max_score'=>$request->max_score,
                'grade'=>strtoupper($request->grade),
                'grade_point'=>strtoupper($request->grade_point),
                'category_pid'=>$request->category_pid,
                'session_pid'=>$request->session_pid,
                'class_pid'=>$request->class_pid,
                'term_pid'=>$request->term_pid,
                'color'=>$request->color,
                'remark'=>strtoupper($request->remark),
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
                $error = $e->getMessage();
                logError($error);
                dd($error);
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
