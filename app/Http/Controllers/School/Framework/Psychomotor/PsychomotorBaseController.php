<?php

namespace App\Http\Controllers\School\Framework\Psychomotor;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Psychomotor\PsychomotorBase;
use App\Models\School\Framework\Psychomotor\PsychomotorKey;

class PsychomotorBaseController extends Controller
{
    // load school psychomotors 
    public function index()
    {
        $data = DB::table('psychomotor_bases as b')
                    ->join('categories as c','c.pid','b.category_pid')
                    // ->leftjoin('users as u','u.pid','s.user_pid')
                    ->where(['b.school_pid' => getSchoolPid()])
                    ->get(['b.pid', 'psychomotor', 'b.created_at', 'b.description', 'b.status',
                            'obtainable_score' , 'c.category', 'grade', 'category_pid'
                            ]);
        $categories = DB::table('categories')->select('pid', 'category')->where('school_pid', getSchoolPid())->get();
        
        return datatables($data)
            ->editColumn('type', function ($data) {
                return EXTRA_CURRICULAR_GRADE_STYLE[$data->grade];
            })
            ->editColumn('status', function ($data) {
                return EXTRA_CURRICULAR_GRADE_STYLE[$data->grade];
            })
            ->editColumn('status_', function ($data) {
                return $data->status == 1 ? 'Enabled' : 'Disabled';
            })
            ->editColumn('action', function ($data) use($categories) {
                return view('school.framework.extra-curricular.extra-curricular-action-button',['data'=>$data, 'categories' => $categories]);
            })
            // ->rawColumns(['data', 'status'])
            ->make(true);
    }

    // load school psychomotor key 
    public function psychomotorKeys(Request $request)
    {
        if(isset($request->pid) && isset($request->category)){

            $where = ['k.school_pid' => getSchoolPid(), 'k.psychomotor_pid' => $request->pid, 'b.category_pid'=> $request->category ];

        }
        else if(isset($request->pid) || isset($request->category)){

            if(isset($request->pid)){
                $where = ['k.school_pid' => getSchoolPid(), 'k.psychomotor_pid' => $request->pid];
            }

            if(isset($request->category)){
                $where = ['k.school_pid' => getSchoolPid(), 'b.category_pid' => $request->category];
            }

        }else{

            $where = ['k.school_pid' => getSchoolPid()];

        }
        $data = DB::table('psychomotor_keys as k')->join('psychomotor_bases as b', 'k.psychomotor_pid', 'b.pid')
            ->join('categories as c', 'c.pid', 'b.category_pid')
            ->where($where)->orderBy('category')
            ->get(['k.pid', 'psychomotor', 'title', 'k.created_at', 'k.status', 'max_score', 'category']);
        
        return datatables($data)
        ->addIndexColumn()
            ->editColumn('category', function ($data) {
                return $data->category.', '.$data->psychomotor;
            })
            // ->editColumn('status', function ($data) {
            //     return $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
            // })
            // ->rawColumns(['data', 'status'])
            ->make(true);
    }


    public function createPsychomotorBase(Request $request){
        $validator = Validator::make($request->all(), [
            'psychomotor.*' => [
                            'required',
                            'max:30',
                            "regex:/^[a-zA-Z0-9,-_.()'\s\/]+$/",
                        //     Rule::unique('psychomotor_bases')->where(function($param) use ($request){
                        //         $param->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid)->where('category_pid',$request->category);
                        //     }
                        // )
                    ],
            'category'=>'required' ,
            'grade'=>'required' ,
            'score.*'=> 'required|numeric|digits_between:1,5'
        ], [
            'psychomotor.max' => 'Maximum of 30 character',
            // 'psychomotor.unique' => $request->psychomotor.' Already Exist',
            'psychomotor.regex' => 'only number and text is allowed',
        ]);

        if (!$validator->fails()) {

            try {
                $data = [
                    // 'psychomotor' => $request->psychomotor,
                    // 'description' => $request->description,
                    // 'obtainable_score' => $request->score,
                    'grade' => $request->grade,
                    'category_pid' => $request->category,
                    'pid' => public_id(),
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid()
                ];

                $count = count($request->psychomotor);

                for ($i=0; $i < $count ; $i++) { 
                    $data['pid'] = public_id();
                    $data['psychomotor'] = $request->psychomotor[$i];
                    $data['obtainable_score'] = $request->score[$i];
                    $result = $this->createOrUpdatePsychomotorBase($data);
                }
                
                if ($result) {
                    $msg = 'Extra Curricular activity created successfully';
                    if ($request->pid) {
                        $msg = 'Extra Curricular activity updated successfully';
                    }

                    return response()->json(['status' => 1, 'message' => $msg]);
                }
                return response()->json(['status' => 'error', 'message' => 'Something Weng Wrong']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    


    public function updatePsychomotorBase(Request $request){
        $validator = Validator::make($request->all(), [
            'psychomotor' => [
                            'required',
                            'max:30',
                            "regex:/^[a-zA-Z0-9,-_.()'\s\/]+$/",
                            Rule::unique('psychomotor_bases')->where(function($param) use ($request){
                                $param->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid)->where('category_pid',$request->category);
                            }
                        )
                    ],
            'category'=>'required' ,
            'grade'=>'required' ,
            'score'=> 'required|numeric'
        ], [
            'psychomotor.max' => 'Maximum of 30 character',
            'psychomotor.unique' => $request->psychomotor.' Already Exist',
            'psychomotor.regex' => 'only number and text is allowed',
        ]);
        if (!$validator->fails()) {
            try {
                $data = [
                    'psychomotor' => $request->psychomotor,
                    'obtainable_score' => $request->score,
                    'grade' => $request->grade,
                    'status' => $request->status,
                    'category_pid' => $request->category,
                    'pid' => $request->pid,
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid()
                ];
                $result = $this->createOrUpdatePsychomotorBase($data);
                if ($result) {
                    return response()->json(['status' => 1, 'message' => 'Extra Curricular activity updated successfully']);
                }
                return response()->json(['status' => 'error', 'message' => 'Something Weng Wrong']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => ER_500]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    public function deletePsychomotorBase(Request $request){

        try {

            $key = PsychomotorKey::where('psychomotor_pid', $request->pid)->exists();
            if ($key) {
                $result = PsychomotorBase::where('pid', $request->pid)->first(['id','status']);
                $result->status = 0;
                $result->save();
                return response()->json(['status' => 1, 'message' => 'Extra Curricular activity disabled.']);
            }
            $result = PsychomotorBase::where('pid', $request->pid)->delete();
            if ($result) {
                return response()->json(['status' => 1, 'message' => 'Extra Curricular activity Deleted!!!']);
            }
            return response()->json(['status' => 2, 'message' => 'Failed to delete Extra Curricular activity']);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went Wrong... error logged']);
        }
    }



    public function clonePsychomotorBase(Request $request){

        $validator = Validator::make($request->all(), [
            'psychomotor.*' => 'required',
            'category.*' => 'required' ,
        ], );

        if (!$validator->fails()) {

            try {
                $result = false;
                foreach($request->category as $category){
                    $bases = PsychomotorBase::whereIn('pid',$request->psychomotor)->where('school_pid',getSchoolPid())->get()->toArray();
                    foreach($bases as $base){
                        $exists = PsychomotorBase::where(['category_pid' => $category, 'psychomotor' => $base['psychomotor'] , 'school_pid' => getSchoolPid()])->exists(); 
                        if($exists){
                            continue;
                        }
                        $base['staff_pid'] = getSchoolUserPid();
                        $base['created_at'] = $base['updated_at'] = fullDate();
                        unset($base['id']);
                        $base['category_pid'] = $category;
                        $base_keys = PsychomotorKey::where(['psychomotor_pid' => $base['pid'], 'school_pid' => getSchoolPid()])->get()->toArray();
                        $base['pid'] = public_id(); // update the pid to a new one
                        $result = $this->createOrUpdatePsychomotorBase($base);
                        foreach($base_keys as $array){
                            $array['created_at'] = $array['updated_at'] = fullDate();
                            $array['staff_pid'] = getSchoolUserPid();
                            $array['pid'] = public_id();
                            $array['psychomotor_pid'] = $result->pid;
                            unset($array['id']);
                            $results = $this->createOrUpdatePsychomotorKey($array);
                        }
                    }
                   
                }
               
                if ($result) {
                    // DB::commit();
                    return response()->json(['status' => 1, 'message' => 'Selected Extra Curricula Cloned']);
                }
                // DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Failed to clone']);
            } catch (\Throwable $e) {
                // DB::rollBack();
                logError($e->getMessage());
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function createOrUpdatePsychomotorBase($data)
    {
        try {
            return  PsychomotorBase::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


    public function createPsychomotorKey(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title.*' => 
                        [
                            'required',
                            // 'max:30',
                            "regex:/^[a-zA-Z0-9-._,\/()'\s]+$/",
                            // Rule::unique('psychomotor_keys')->where(function($param) use($request){
                            //     $param->where([
                            //                 'school_pid'=>getSchoolPid(),
                            //                 'psychomotor_pid'=>$request->psychomotor_pid])->where('pid','<>',$request->pid);
                            // })
                        ],
            'psychomotor_pid' => 'required',
            // 'score' => 'required|int|digits_between:1,5'
        ], [
            'title.max' => 'Maximum of 30 character',
            'title.regex' => 'Special character is not allowed',
            'title.unique' => 'Title already Exist',
            'score.required' => 'Enter Obtainable Score',
            'score.digits_between' => 'Obtainable Score 5 Maximum',
        ]);

        if (!$validator->fails()) {
            

            foreach($request->title as $title){
                $data = [
                    'title' => $title ,
                    'psychomotor_pid' => $request->psychomotor_pid ,
                    // 'max_score' => $request->score ,
                    'pid' => public_id(),
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid()
                ];
                $result = $this->createOrUpdatePsychomotorKey($data);
            }
            if ($result) {
                $msg = 'Psychomotor key Created Successfully';
                if ($request->pid) {
                    $msg = 'Psychomotor key Updated Successfully';
                }

                return response()->json(['status' => 1, 'message' => $msg]);
            }
            return response()->json(['status' => 'error', 'message' => 'Something Weng Wrong']);
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function createOrUpdatePsychomotorKey($data)
    {
        try {
            return  PsychomotorKey::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

}
