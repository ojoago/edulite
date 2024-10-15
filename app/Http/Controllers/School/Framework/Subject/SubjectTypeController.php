<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Subject\Subject;
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
    
    public function index()
    {
       try {
            $data = SubjectType::where(['subject_types.school_pid' => getSchoolPid()])->get();
            // logError([$data,getSchoolPid()]);
            return datatables($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('school.framework.subject.subject-type-action-buttons', ['data' => $data]);
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->rawColumns(['data', 'action'])
                ->make(true);
       } catch (\Throwable $e) {
            logError($e->getMessage());
            return null;
       }
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

            $result = self::createOrUpdateSubjectType($data);
            
            if ($result) {
                return response()->json(['status'=>1,'message'=> $request->pid ? 'Subject Type Updated' : 'Subject Type Created']);
            }
            return response()->json(['status'=>2,'message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        //uniqueNess('subject_types','subject',$request->subject);
        
    }

    public function createGroupSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject.*' => ['required', 'string',Rule::unique('subjects', 'subject')->where(function($param) use($request){
                $param->where([
                    'school_pid'=>getSchoolPid(),
                    'category_pid'=>$request->category_pid,
                    'subject_type_pid'=>$request->subject_type_pid,
                ])->where('pid','<>',$request->pid);
            })],
            // 'subject_type_pid' => 'required|string',
            'category_pid.*' => 'required|string'
        ], [
            'subject.required' => 'Enter Subject Name',
            'subject_type_pid.required' => 'Select Subject Type',
            'category_pid.required' => 'Select School Category',
        ]);
        if (!$validator->fails()) {

            foreach ($request->subject as $subject):
                $data = [
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid(),
                    'subject' => $subject,
                    'subject_type_pid' => $request->subject_type_pid
                ];
                
                foreach ($request->category_pid as $category_pid):
                    $data['category_pid'] = $category_pid;
                    $data['pid'] = public_id();
                    $result = $this->createOrUpdateSubject($data);
                endforeach;

            endforeach;

            if ($result) {
                return response()->json(['status' => 1, 'message' => $request->pid ? 'Subject Updated Successfully' : 'Subject Created Successfully']);
            }
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }



    public static function createOrUpdateSubjectType($data)
    {
        try {
            return  SubjectType::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
           
        }
    }

    public static function createOrUpdateSubject($data)
    {
        try {
            return  Subject::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
           
        }
    }


    
}
