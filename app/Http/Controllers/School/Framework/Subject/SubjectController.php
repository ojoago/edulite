<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Subject\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->param)) {
            $where = ['subjects.school_pid' => getSchoolPid(), 'subjects.category_pid' => $request->param];
        } else {
            $where = ['subjects.school_pid' => getSchoolPid()];
        }
        $data = Subject::join('school_staff', 'school_staff.pid', 'subjects.staff_pid')
        ->join('subject_types', 'subject_types.pid', 'subjects.subject_type_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->where($where)
            ->get(['subjects.pid','subject', 'subjects.status','subject_type', 'subjects.created_at', 'subjects.description', 'username']);
        return datatables($data)
            ->addColumn('action', function ($data) {
            return '
                    <button type="button" class="btn btn-primary btn-sm edit-subject" pid="'.$data->pid.'">
                        <i class="bi bi-tools"></i>
                    </button>
            ';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? '<span class = "text-succses"> Enabled</span>' : '<span class = "text-danger">Disabled</span>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    
    public function loadSubjectById(Request $request)
    {
        $data = Subject::where(['pid'=>$request->pid,'school_pid'=>getSchoolPid()])->first();
        if($data){
            return response(['data'=>$data,'status'=>1]);        
        }
        return response(['data'=>null,'status'=>0]);        
    }

    


    public function createSchoolSubject(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => ['required', 'string',Rule::unique('subjects')->where(function($param) use($request){
                $param->where([
                    'school_pid'=>getSchoolPid(),
                    'category_pid'=>$request->category_pid,
                    'subject_type_pid'=>$request->subject_type_pid,
                ])->where('pid','!=',$request->pid);
            })],
            'subject_type_pid' => 'required|string',
            'category_pid' => 'required|string'
        ],[
            'subject.required'=>'Enter Subject Name', 
            'subject_type_pid.required'=>'Select Subject Type',
            'category_pid.required'=>'Select School Category',
        ]);
        if(!$validator->fails()){
            // $request['school_pid'] = getSchoolPid();
            // $request['pid'] = public_id();
            // $request['staff_pid'] = getUserPid();
            $data = [
                'school_pid'=>getSchoolPid(),
                'pid'=> $request->pid ?? public_id(),
                'staff_pid'=>getSchoolUserPid(),
                'subject'=>$request->subject,
                'subject_type_pid'=>$request->subject_type_pid,
                'category_pid'=>$request->category_pid,
                'description'=>$request->description,
            ];
            $result = $this->createOrUpdateSubject($data);
            if ($result) {
                return response()->json(['status'=>1,'message'=> $request->pid ? 'Subject Updated Successfully': 'Subject Created Successfully']);
            }
            return response()->json(['status'=>'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        
    }

    private function createOrUpdateSubject($data)
    {
        try {
            return  Subject::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    
}
