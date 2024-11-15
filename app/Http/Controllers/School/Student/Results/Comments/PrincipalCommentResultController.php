<?php

namespace App\Http\Controllers\School\Student\Results\Comments;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Student\Result\StudentClassResult;
use App\Models\School\Framework\Comment\PrincipalComment;
use App\Http\Controllers\School\Student\Results\Termly\StudentTermlyResultController;
use App\Models\School\Framework\Class\Category;

class PrincipalCommentResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadStudentResult(Request $request)
    {
        $data = [
            'school_pid' => getSchoolPid(),
            'session_pid' => $request->session,
            'term_pid' => $request->term,
            'arm_pid' => $request->arm,
        ];
        $result = StudentTermlyResultController::studentResultParams($data);
        $data = $result['data'];
        $class = $result['class'];
        $subjects = $result['subjects'];
        return view('school.student.result.comments.principal.principal-comment', compact('data', 'class', 'subjects'));

    }

    public function loadPrincipalAutomatedComment(){
        try {
            $category = Category::where('school_pid',getSchoolPid())->get(['pid','category']);
            $data = DB::table('principal_comments as p')
            ->join('categories as c', 'c.pid', 'p.category_pid')
            ->join('school_staff as s', 's.pid', 'p.principal_pid')
            ->join('user_details as d', 'd.user_pid', 's.user_pid')
                ->where(['p.principal_pid' => getSchoolUserPid(), 'p.school_pid' => getSchoolPid()])
                ->select('p.min', 'p.max', 'p.comment', 'c.category', 'd.fullname', 'p.title','p.id', 'p.category_pid')
                ->orderBy('min')
                ->get();
            return datatables($data)
                ->editColumn('action', function ($data) use($category) {
                    return view('school.student.result.comments.principal.principal-action-btn',['data' => $data , 'category' => $category]);
                })
                ->addIndexColumn()
                ->make(true);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            
        }
    }

    public function principalCommentStudentTermlyResult(Request $request){
       $result = StudentClassResult::where([
                    'school_pid'=>getSchoolPid(),
                    'student_pid'=>$request->std,
                    'class_param_pid'=>$request->param,
                ])->update(['principal_comment'=> $request->comment]);
        if($result){
            return 'Comment Updated';
        }
        return 'Comment Not Updated!!!';
    }

    public function principalAutomatedComment(Request $request){
        $validator = Validator::make($request->all(),[
                    'category'=>'required',
                    'title' => ['required', Rule::unique('principal_comments')->where(function ($query) use ($request) {
                        $query->where('category_pid', $request->category)->where('id', '<>', $request->id);
                    })],
                    'min'=> ['required', 'numeric', 'max:' . (float)$request->max, ' between:0,100'],
                    'max'=> ['required','numeric','min:'.(float)$request->min,' between:1,100'],
                    'comment'=> 'required'
                ]);
        
        if(!$validator->fails()){
            $data = [
                'school_pid'=>getSchoolPid(),
                'title'=>$request->title,
                'min'=>$request->min,
                'max'=>$request->max,
                'comment'=>$request->comment,
                'principal_pid'=>getSchoolUserPid(),
                'category_pid'=>$request->category,
            ];
            if($request->id){
                $data['id'] = $request->id;
            }
            $result = $this->updateOrCreatePrincipalComment($data);
            if($result){
                if ($request->id) {
                    return response()->json(['status' => 1, 'message' => 'Comment Updated Successfully']);
                }
                return response()->json(['status' => 1, 'message' => 'Comment Added Successfully']);
            }
            return response()->json(['status' =>'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }
   
    private function updateOrCreatePrincipalComment(array|null $data)
    {
        try {
            $result = PrincipalComment::updateOrCreate(['id'=>$data['id'] ?? null],$data);
            return $result;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
}
