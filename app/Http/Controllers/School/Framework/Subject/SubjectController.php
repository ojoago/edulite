<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Subject\Subject;
use App\Models\School\Framework\Subject\SubjectType;

class SubjectController extends Controller
{
 
    public function index(Request $request)
    {
        try {
            if (isset($request->param)) {
                $where = ['subjects.school_pid' => getSchoolPid(), 'subjects.category_pid' => $request->param];
            } else {
                $where = ['subjects.school_pid' => getSchoolPid()];
            }
            $data = Subject::join('subject_types', 'subject_types.pid', 'subjects.subject_type_pid')->join('categories as c','c.pid', 'category_pid')
                ->where($where)
                ->get(['subjects.pid', 'subject', 'subjects.status', 'subject_type', 'c.category', 'category_pid']);
                $categories = DB::table('categories')->where('school_pid',getSchoolPid())->select('pid', 'category')->get();
                $sub = DB::table('subject_types')->where('school_pid',getSchoolPid())->select('pid', 'subject_type')->get();
            return datatables($data)
            ->addColumn('action', function ($data) use ($categories,$sub) {
                return view('school.framework.subject.subject-action-buttons', ['data' => $data, 'categories' => $categories , 'subs' => $sub]);

            })
            // ->editColumn('created_at', function ($data) {
            //     return $data->created_at->diffForHumans();
            // })
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? '<span class = "text-succses"> Enabled</span>' : '<span class = "text-danger">Disabled</span>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return null;
        }
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
            'subject.*' => ['required', 'string',Rule::unique('subjects', 'subject')->where(function($param) use($request){
                $param->where([
                    'school_pid'=>getSchoolPid(),
                    'category_pid'=>$request->category_pid,
                    // 'subject_type_pid'=>$request->subject_type_pid,
                ])->where('pid','<>',$request->pid);
            })],
            // 'subject_type_pid' => 'required|string',
            'category_pid.*' => 'required|string'
        ],[
            'subject.required'=>'Enter Subject Name', 
            'subject_type_pid.required'=>'Select Subject Type',
            'category_pid.required'=>'Select School Category',
        ]);
        if(!$validator->fails()){
            // $request['school_pid'] = getSchoolPid();
            // $request['pid'] = public_id();
            // $request['staff_pid'] = getUserPid();

            
            if (isset($request->pid)) {
                $data['pid'] = $this->loadSubject($request->pid);
            }

            foreach($request->subject as $subject):
                $data = [
                    'school_pid' => getSchoolPid(),
                    'pid' => public_id(),
                    'staff_pid' => getSchoolUserPid(),
                    'subject_type' => $subject,
                    'description' => $request->description
                ];
                $type = SubjectType::where(['subject_type' => trim($subject) , 'school_pid' => getSchoolPid()])->first(['pid']);
                logError($type);
                if(!$type){
                    $type = SubjectTypeController::createOrUpdateSubjectType($data);
                }
                foreach($request->category_pid as $category_pid):
                    $data = [
                        'school_pid' => getSchoolPid(),
                        'pid' => $request->pid ?? public_id(),
                        'staff_pid' => getSchoolUserPid(),
                        'subject' => $subject,
                        'subject_type_pid' => $type->pid,
                        'category_pid' => $category_pid,
                        'description' => $request->description,
                    ];
                    $result = $this->createOrUpdateSubject($data);
                endforeach;
            endforeach;
            
            if ($result) {
                return response()->json(['status'=>1,'message'=> $request->pid ? 'Subject Updated Successfully': 'Subject Created Successfully']);
            }
            return response()->json(['status'=>'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        
    }

    

    public function updateSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', Rule::unique('subjects')->where(function ($param) use ($request) {
                $param->where([
                    'school_pid' => getSchoolPid(),
                    'category_pid' => $request->category_pid,
                ])->where('pid', '<>', $request->pid);
            })],
            'category_pid' => 'required|string',
            'subject_type' => 'required|string'
        ], [
            'subject.required' => 'Enter Subject Name',
            'category_pid.required' => 'Select School Category',
        ]);
        if (!$validator->fails()) {

           try {
                $subject = Subject::where('pid', $request->pid)->first();
                $subject->subject = $request->subject;
                $subject->category_pid = $request->category_pid;
                $subject->subject_type_pid = $request->subject_type;

                $result = $subject->save();

                if ($result) {
                    return response()->json(['status' => 1, 'message' => 'Subject Updated Successfully']);
                }
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong...']);
           } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Something went Wrong... error logged']);
           }
           
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        
    }



    public function dupSubjectTypeAsSubject(Request $request){
        $validator = Validator::make($request->all(), [
            'subject_type_pid' => 'required|array',
            'category_pid' => 'required|string'
        ],['subject_type_pid.required'=>'Select one Subject type at least','category_pid.required'=>'Select Category']);
        if (!$validator->fails()) {
            try {
                $result = false;$k=0;
                $sbj = SubjectType::whereIn('pid',$request->subject_type_pid)->where('school_pid',getSchoolPid())->get(['pid', 'school_pid', 'subject_type', 'description']);
                foreach ($sbj as  $sb){
                    $data = [
                        'school_pid' => $sb->school_pid,
                        'pid' => public_id(),
                        'staff_pid' => getSchoolUserPid(),
                        'subject' => $sb->subject_type,
                        'subject_type_pid' => $sb->pid,
                        'category_pid' => $request->category_pid,
                        'description' => $sb->description,
                    ];
                    $dp = Subject::where(['school_pid'=>getSchoolPid(),'category_pid'=>$request->category_pid,'subject'=>$sb->subject_type])->get('id');
                    if($dp->isNotEmpty()){
                        
                        continue;
                    }
                    $result = $this->createOrUpdateSubject($data);
                    $k++;
                }
                if ($result) {
                    return response()->json(['status' => 1, 'message' =>  $k.' Subject(s) duplicated']);
                }
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);
                
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong... error logged']);

            }
            
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
       
    }
    private function createOrUpdateSubject($data)
    {
        try {
            return  Subject::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    private function loadSubject($pid){
        try {
            return Subject::where('pid',$pid)->pluck('subject_type_pid')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    
}
