<?php

namespace App\Http\Controllers\School\Student\Results\Comments;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Student\Result\StudentClassResult;
use App\Models\School\Framework\Comment\FormMasterComment;
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
        $subjects = $result['subjects'];
        return view('school.student.result.comments.teacher.teacher-comment', compact('data', 'class','subjects'));
    }

    public function loadTeacherAutomatedComment()
    {
        $data = DB::table('form_master_comments as f')
        ->join('categories as c', 'c.pid', 'f.category_pid')
        ->join('school_staff as s', 's.pid', 'f.teacher_pid')
        ->join('user_details as d', 'd.user_pid', 's.user_pid')
        ->where(['f.school_pid'=>getSchoolPid(),'f.teacher_pid'=>getSchoolUserPid()])
        ->select('f.min', 'f.max', 'f.comment', 'c.category', 'f.created_at', 'd.fullname')
        ->orderBy('min')
            ->get();
        return datatables($data)
            ->editColumn('date', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->addIndexColumn()
            ->make(true);
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

    public function teacherAutomatedComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'title' => ['required', Rule::unique('form_master_comments')->where(function ($query) use ($request) {
                $query->where('category_pid', $request->category)->where('id', '<>', $request->id);
            })],
            'min' => ['required', 'numeric', 'max:' . (float)$request->max, ' between:0,100'],
            'max' => ['required', 'numeric', 'min:' . (float)$request->min, ' between:1,100'],
            'comment' => 'required'
        ]);

        if (!$validator->fails()) {
           try {
                $data = [
                    'school_pid' => getSchoolPid(),
                    'min' => $request->min,
                    'max' => $request->max,
                    'comment' => $request->comment,
                    'title' => $request->title,
                    'teacher_pid' => getSchoolUserPid(),
                    'category_pid' => $request->category,
                ];
                if ($request->id) {
                    $data['id'] = $request->id;
                }
                $result = $this->updateOrCreateTeacherComment($data);
                if ($result) {
                    return response()->json(['status' => 1, 'message' => $request->id ? 'Comment Updated Successfully' : 'Comment Added Successfully']);
                }
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);
           } catch (\Throwable $e) {
                logError($e->getMessage());

           }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function updateOrCreateTeacherComment(array|null $data)
    {
        try {
            $result = FormMasterComment::updateOrCreate(['id' => $data['id'] ?? null], $data);
            return $result;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
}
