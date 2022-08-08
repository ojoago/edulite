<?php

namespace App\Http\Controllers\School\Framework\Psycho;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Psycho\PsychoGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PsychoGradeKeyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){ {
            $data = PsychoGrade::join('school_staff', 'school_staff.pid', 'psycho_grades.staff_pid')
                ->join('users', 'users.pid', 'school_staff.user_pid')
                ->where(['psycho_grades.school_pid' => getSchoolPid()])
                ->get(['psycho_grades.pid', 'grade', 'psycho_grades.created_at', 'psycho_grades.score', 'username']);
            return datatables($data)
                ->editColumn('created_at', function ($data) {
                    return date('d F Y', strtotime($data->created_at));
                })->addIndexColumn()
                // ->editColumn('status', function ($data) {
                //     return $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
                // })
                // ->rawColumns(['data', 'status'])
                ->make(true);
        }
    }
    public function createPsychoGrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade.*' => 'required|max:30|regex:/^[a-zA-Z0-9\s]+$/',
            'score.*' => 'required|int||max:5|min:1'
        ], [
            'grade.max' => 'Maximum of 30 character',
            'grade.regex' => 'only number and text is allowed',
            'score.required' => 'Enter Obtainable Score',
            'score.max' => 'Obtainable Score can not be greater than 5',
            'score.min' => 'Obtainable Score can not be less than 1',
        ]);

        if (!$validator->fails()) {
            $count = count($request->grade);
            $data = [
                'pid' => public_id(),
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid()
            ];
            for ($i = 0; $i < $count; $i++) {
                $data['score'] = $request->score[$i];
                $data['grade'] = $request->grade[$i];
                if(empty($data['score']) or empty($data['grade']))
                    continue;
                $result = $this->createOrUpdatePsychoGrade($data);
            }
            if ($result) {
                $msg = 'Psychomotor & Effective domain key created successfully';
                if ($request->pid) {
                    $msg = 'Psychomotor & Effective domain key updated successfully';
                }

                return response()->json(['status' => 1, 'message' =>$count.' '.$msg]);
            }
            return response()->json(['status' => 'error', 'message' => 'Something Weng Wrong']);
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function createOrUpdatePsychoGrade($data)
    {
        try {
            return  PsychoGrade::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid'],$data['grade']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }


}
