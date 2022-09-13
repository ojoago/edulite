<?php

namespace App\Http\Controllers\School\Student\Results\Comments;

use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Student\Results\Termly\StudentTermlyResultController;
use App\Models\School\Student\Result\StudentClassResult;
use Illuminate\Http\Request;

class CommentResultController extends Controller
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
        // $param = $result['param'];
        return view('school.student.result.comments.principal.principal-comment', compact('data', 'class'));

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
