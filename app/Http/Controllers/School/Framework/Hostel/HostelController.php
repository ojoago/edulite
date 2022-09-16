<?php

namespace App\Http\Controllers\School\Framework\Hostel;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Hostel\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HostelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadHostel()
    {
        $data = Hostel::where('school_pid',getSchoolPid())->get();
        return datatables($data)->addColumn('action',function($data){
                        return view('school.framework.hostels.hostels-action-button',['data'=>$data]);
                        })->editColumn('date',function($data){
                            return $data->created_at->diffForHumans();
                        })
                        ->make(true);
    }

     
    public function createHostel(Request $request)
    {
        $n = $request->name;
            $request->name = strtoupper($request->name);
        $validator = Validator::make($request->all(),[
            'name'=>['required',Rule::unique('hostels')->where(function($param) use ($request){
                    $param->where('school_pid',getSchoolPid())->where('pid','!=',$request->pid);
            })],
            'capacity'=>'required|min:1|int',
            'location'=>'required|string'
        ],['name.required'=>'Enter Hostel Name','name.unique'=> $n.' Already exists']);

        if(!$validator->fails()){
            $data = [
                'name' => $request->name,
                'capacity' => $request->capacity,
                'location' => $request->location,
                'pid' => $request->pid ?? public_id(),
                'school_pid' => getSchoolPid(),
            ];
            $result = $this->updateOrCreateHostel($data);
            if($result){

                return response()->json(['status'=>1,'message'=>'Hostel Created Successfully']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong... Error log']);
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }

    private function updateOrCreateHostel(array $data){
        try {
            $dupParam = $data;
            $data['staff_pid'] = getSchoolUserPid();
            return Hostel::updateOrCreate($dupParam,$data);
        } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
            logError($error);
        }
    }
     
}
