<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Subject\SubjectType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $data = SubjectType::join('school_staff', 'school_staff.pid','subject_types.staff_pid')
                            ->leftJoin('users','users.pid','school_staff.user_pid')
                            ->where(['subject_types.school_pid'=>getSchoolPid()])
                            ->get(['subject_types.pid','subject_type', 'subject_types.created_at', 'subject_types.description','username']);
        logError([$data,getSchoolPid()]);
        return datatables($data)
            ->addColumn('action', function ($data) {
                return view('school.framework.subject.subject-type-action-buttons', ['data' => $data]);
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans();
            })
            ->rawColumns(['data', 'action'])
            ->make(true);
    }



    public function createSubjectType(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
            'subject_type'=> [
                        'required', 
                        'string', 
                        'min:3', 
                        'max:22', 
                        'regex:/^[a-zA-Z0-9\s]+$/', 
                        Rule::unique('subject_types')->where(function($param) use ($request){
                            $param->where('school_pid', getSchoolPid())->where('pid','!=',$request->pid);
                     })],
            // Rule::unique()
            
        ],[
            'subject_type.required'=>'Enter Subject Type',
            'subject_type.unique'=> $request->subject_type.' already exists',
            'subject_type.max'=>'Subject Type should not be more than 22 character',
            'subject_type.max'=>'Maximum of 22 characters',
            'subject_type.min'=>'Minimum of 3 characters',
            'subject_type.regex'=>'Special Character not allowed e.g #$%^*. etc',
        ]);
        if(!$validator->fails()){

            $data = [
                'school_pid'=> getSchoolPid(),
                'pid'=> $request->pid ?? public_id(),
                'staff_pid'=> getSchoolUserPid(),
                'subject_type'=>$request->subject_type,
                'description'=>$request->description
            ];

            $result = $this->createOrUpdateSubjectType($data);
            
            if ($result) {
                return response()->json(['status'=>1,'message'=> $request->pid ? 'Subject Type Updated' : 'Subject Type Created']);
            }
            return response()->json(['status'=>2,'message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        //uniqueNess('subject_types','subject',$request->subject);
        
    }

    private function createOrUpdateSubjectType($data)
    {
        try {
            return  SubjectType::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
           
        }
    }


    
}
