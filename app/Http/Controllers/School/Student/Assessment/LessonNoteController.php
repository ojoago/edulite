<?php

namespace App\Http\Controllers\School\Student\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Student\Assessment\LessonNote;

class LessonNoteController extends Controller
{
    //
    //
    public function loadLessonNotes()
    {
      
        try {
            $data = LessonNote::from('lesson_notes as n')
                ->join('class_arm_subjects as cas', 'cas.pid', 'n.subject_pid')
                ->join('subjects as s', 's.pid', 'cas.subject_pid')
                ->join('class_arms as a', 'a.pid', 'n.arm_pid')
                ->where(['n.school_pid' => getSchoolPid()])
                ->select('arm', 'subject', 'n.*')->orderBy('arm')->orderBy('subject')->get();
            return datatables($data)->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('school.assessments.plan-action-btn', ['data' => $data]);
                })
                ->make(true);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    //
    public function addLessonNote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_pid' => 'required|string',
            'subject_pid' => 'required|string',
            'class_pid' => 'required|string',
            'arm_pid' => 'required|string',
            'subject_pid' => 'required|string',
            'week' => 'required|numeric',
            'period' => 'required|numeric',
            'date' => 'date|nullable',
            'type' => 'required',
            'plan' => 'required_if:type,2|nullable',
            'file' => 'required_if:type,1|nullable|mimes:pdf,docs,doc|max:2024',
        ], [
            'category_pid.required' => 'Category is required',
            'subject_pid.required' => 'Subject is required',
            'class_pid.required' => 'Class is required',
            'arm_pid.required' => 'Class Arm is required',
            'week.required' => 'Week is required',
            'period.required' => 'Period is required',
            'type.required' => 'Type is required',
            'plan.required_if' => 'This is required',
            'file.required_if' => 'This is required',
        ]);

        if (!$validator->fails()) {
            try {
                $data = [
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid(),
                    'session_pid' => activeSession(),
                    'term_pid' => activeTerm(),
                    'category_pid' => $request->category_pid,
                    'pid' => $request->pid ?? public_id(),
                    'class_pid' => $request->class_pid,
                    'arm_pid' => $request->arm_pid,
                    'subject_pid' => $request->subject_pid,
                    'week' => $request->week,
                    'period' => $request->period,
                    'date' => $request->date ?? justDate(),
                    'type' => $request->type,
                    'plan' => $request->plan,
                ];

                if ($request->type == 1) {
                    $fileName = invoiceNumber() . '- week ' . $request->week . '.' . $request->file->extension();
                    $request->file->move(public_path('files/assessments/lesson-notes'), $fileName);
                    $data['path'] = 'files/assessments/lesson-notes/' . $fileName;
                    $data['plan'] = null;
                }
                $result = $this->updateOrCreatePlan($data);
                if ($result) {
                    return response()->json(['status' => 1, 'message' => 'Note Added']);
                }
                return response()->json(['status' => 2, 'message' => 'Failed to Add Note']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => ER_500]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }


    private function updateOrCreatePlan($data)
    {
        try {
            return LessonNote::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

}
