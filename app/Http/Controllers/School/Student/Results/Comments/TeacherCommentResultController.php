<?php

namespace App\Http\Controllers\School\Student\Results\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Result\StudentClassResult;
use App\Http\Controllers\School\Student\Results\Termly\StudentTermlyResultController;

class TeacherCommentResultController extends Controller
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
        return view('school.student.result.comments.teacher.teacher-comment', compact('data', 'class'));
    }


    public function teacherCommentStudentTermlyResult(Request $request)
    {
        $result = StudentClassResult::where([
            'school_pid' => getSchoolPid(),
            'student_pid' => $request->std,
            'class_param_pid' => $request->param,
        ])->update(['class_teacher_comment' => $request->comment]);
        if ($result) {
            return 'Comment Updated';
        }
        return 'Comment Not Updated!!!';
    }

}
