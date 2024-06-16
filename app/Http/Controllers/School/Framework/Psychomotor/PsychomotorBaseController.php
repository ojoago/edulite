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
                            'obtainable_score' , 'c.category', 'grade'
                            ]);
        return datatables($data)
            // ->editColumn('created_at', function ($data) {
            //     return date('d F Y', strtotime($data->created_at));
            // })
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }
    // load school psychomotor key 
    public function psychomotorKeys(Request $request)
    {
        if(isset($request->pid)){
            $data = DB::table('psychomotor_keys as k')->join('psychomotor_bases as b', 'k.psychomotor_pid', 'b.pid')
                // ->join('school_staff as s', 's.pid', 'k.staff_pid')
                // ->join('users as u', 'u.pid', 's.user_pid')
                ->where(['k.school_pid' => getSchoolPid(), 'k.psychomotor_pid'=>$request->pid])
        ->get(['k.pid', 'psychomotor', 'title', 'k.created_at', 'k.status',  'max_score',/*'username',*/]);
        }else{
            $data = DB::table('psychomotor_keys as k')->join('psychomotor_bases as b', 'k.psychomotor_pid', 'b.pid')
            // ->join('school_staff as s', 's.pid', 'k.staff_pid')
            // ->join('users as u', 'u.pid', 's.user_pid')
                ->where(['k.school_pid' => getSchoolPid()])
                ->get(['k.pid', 'psychomotor', 'title', 'k.created_at', 'k.status', 'max_score',/*'username',*/]);
        }
        
        return datatables($data)
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }


    public function createPsychomotorBase(Request $request){
        $validator = Validator::make($request->all(), [
            'psychomotor' => [
                            'required',
                            'max:30',
                            "regex:/^[a-zA-Z0-9,'\s]+$/",
                            Rule::unique('psychomotor_bases')->where(function($param) use ($request){
                                $param->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid)->where('category_pid',$request->category);
                            }
                        )],
            'category'=>'required' ,
            'grade'=>'required' ,
            'score'=> 'required|numeric|digits_between:1,5'
        ], [
            'psychomotor.max' => 'Maximum of 30 character',
            'psychomotor.unique' => $request->psychomotor.' Already Exist',
            'psychomotor.regex' => 'only number and text is allowed',
        ]);

        if (!$validator->fails()) {

            try {
                $data = [
                    'psychomotor' => $request->psychomotor ,
                    'description' => $request->description ,
                    'obtainable_score' => $request->score ,
                    'grade' => $request->grade ,
                    'category_pid' => $request->category ,
                    'pid' => public_id() ,
                    'school_pid' => getSchoolPid() ,
                    'staff_pid' => getSchoolUserPid()
                ];
                $result = $this->createOrUpdatePsychomotorBase($data);
                if ($result) {
                    $msg = 'Psychomotor created successfully';
                    if ($request->pid) {
                        $msg = 'Psychomotor updated successfully';
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
                            'max:30',
                            "regex:/^[a-zA-Z0-9,'\s]+$/",
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
