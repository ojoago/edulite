<?php

namespace App\Http\Controllers\School\Framework\Fees;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Fees\FeeItem;

class FeeItemController extends Controller
{
    
    public function loadFeeItems(){
        $data = FeeItem::where(['school_pid'=>getSchoolPid()])->get();
        return datatables($data)
        ->editColumn('status',function($data){
            return $data->status== 1 ? 'Enabled' : 'Disabled';
        })
        ->editColumn('date',function($data){
            return $data->created_at->diffForHumans();
        })
        ->addColumn('action',function($data){
            return view('school.framework.fees.fee-item-action-button',['data'=>$data]);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function createFeeName(Request $request){
        $validator = Validator::make($request->all(),[
            'fee_name'=>[
                'required',
                'string',
                Rule::unique('fee_items')->where(function($param) use($request){
                    $param->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid);
                })]
        ]);

        if(!$validator->fails()){
            $data = [
                'fee_name'=>$request->fee_name,
                'fee_description'=>$request->fee_description,
                'pid'=>$request->pid ?? public_id(),
                'school_pid'=>getSchoolPid(),
                'staff_pid'=>getSchoolUserPid()
            ];
            if ($request->pid) {
                $data['status'] = $request->status;
            }
            $result = $this->updateOrCreateFeeName($data);
            if($result){
                if($request->pid){
                    return response()->json(['status'=>1,'message'=>'fee name updated']);
                }
                return response()->json(['status'=>1,'message'=>'fee name created']);
            }
        }
        return response()->json(['status'=>0,'error' => $validator->errors()->toArray()]);
    }

    private function updateOrCreateFeeName(array $data){

        return FeeItem::updateOrCreate(['pid'=>$data['pid'],'school_pid'=>$data['school_pid']],$data);
    }
}
