<?php

namespace App\Http\Controllers\School\Framework\Fees;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Fees\FeeItem;
use App\Models\School\Framework\Fees\FeeItemAmount;
use App\Models\School\Framework\Fees\FeeConfiguration;
use App\Http\Controllers\School\Framework\ClassController;
use Yajra\DataTables\Html\Editor\Fields\Select;

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

    public function loadFeeAmount(Request $request){
        if(isset($request->session_pid) && isset($request->term_pid)){
            $where = ['i.term_pid' => $request->term_pid, 'i.session_pid' => $request->session_pid, 'i.school_pid' => getSchoolPid()];
        }else{
            $where = ['i.term_pid' => activeTerm(), 'i.session_pid' => activeSession(), 'i.school_pid' => getSchoolPid()];
        }
        $data = DB::table('fee_configurations as c')
                    ->join('fee_items as f','f.pid','c.fee_item_pid')
                    ->join('fee_item_amounts as i','i.config_pid','c.pid')
                    ->join('class_arms as a','a.pid','i.arm_pid')
                    ->join('terms as t','t.pid','i.term_pid')
                    ->join('sessions as s','s.pid','i.session_pid')
                    ->where($where)
                    ->select('arm','amount','i.pid','term','session','fee_name','category','gender','religion','type','payment_model')
                    ->orderBy('fee_name')->orderBy('arm')->orderBy('term')->get();
        return datatables($data)
            ->editColumn('amount', function ($data) {
                return number_format($data->amount,2);
            })
            ->editColumn('model', function ($data) {
                return matchPaymentModel($data->payment_model);
            })
            ->editColumn('condition', function ($data) {
                return matchGender($data->gender).' ' .matchReligion($data->religion) ;
            })
            ->editColumn('type', function ($data) {
                return matchPaymentType($data->type);
            })
        // ->editColumn('date', function ($data) {
        //     return $data->created_at->diffForHumans();
        // })
        ->addColumn('action', function ($data) {
            return view('school.framework.fees.fee-amount-action-button', ['data' => $data]);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function loadFeeConfig(){
        $data = DB::table('fee_configurations as c')
                    ->join('fee_items as f','f.pid','c.fee_item_pid')
                    ->select('fee_name','category','gender','religion','type','payment_model','c.created_at')
                    ->orderBy('fee_name')->get();
        return datatables($data)
            ->editColumn('model', function ($data) {
                return matchPaymentModel($data->payment_model);
            })
            ->editColumn('condition', function ($data) {
                return matchGender($data->gender).' ' .matchReligion($data->religion) ;
            })
            ->editColumn('type', function ($data) {
                return matchPaymentType($data->type);
            })
            ->editColumn('category', function ($data) {
                return matchPaymentCategory($data->type);
            })
            ->editColumn('date', function ($data) {
                return date('d F Y',strtotime($data->created_at));
            })
        // ->addColumn('action', function ($data) {
        //     return view('school.framework.fees.fee-amount-action-button', ['data' => $data]);
        // })
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



    // fee and amount configuration goes here 
    public function  feeConfigurationAndAmount(Request $request){

        $validator = Validator::make($request->all(),[
            'fee_item_pid' => 'required',
            'type' => 'required',
            'category' => 'required',
            'payment_model' => 'required',
            'amount.*' => 'required_if:category,3,1',
            'arm.*' => 'required_if:category,3,1',
            'fixed_amount' => 'required_if:category,4,2',
            // 'fixed_amount' => 'required_if:category,==,4',
            // 'gender'=> 'required',
            // 'religion'=>'required',
        ],[
            'fee_item_pid.required'=>'Select Fee Item',
            'type.required'=>'Select Type',
            'category.required'=>'Select Fee Category',
            'amount.*.required_if'=>'Enter This Amount or Remove it',
            'arm.*.required_if'=>'Enter This or Remove it',
            'fixed_amount.required_if'=>'Enter Amount',
            'payment_model.required'=>'Select Payment Model',
        ]);

        if(!$validator->fails()){
            $data = [
                'fee_item_pid'  => $request->fee_item_pid,
                'type'          => $request->type,
                'category'      => $request->category,
                'gender'        => $request->gender,
                'payment_model' => $request->payment_model,
                'religion'      => $request->religion,
                'arms'          => $request->arm,
                'amount'        => $request->amount,
                'fixed_amount'  => $request->fixed_amount,
                'school_pid'    => getSchoolPid()
            ];
            $result = $this->updateOrCreateFeeConfig($data);
            if($result){
                $result = $this->prepareFeeAmount(pid:$result,param:$data);
                if($result){
                    
                    return response()->json(['status'=>1,'message'=>'Fee amount Configured successfully']);
                }
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong... error log']);
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }


    // this method sort class and amount based on category selected 
    private function prepareFeeAmount(string $pid, array $param){
        $data = [
            'school_pid' => getSchoolPid(),
            'config_pid' => $pid,
            'term_pid' => activeTerm(),
            'session_pid' => activeSession()
        ];
        if($param['category'] == 2 || $param['category'] == 4){
            $class = ClassController::loadAllClassArms();
            foreach($class as $row) {
                $data['amount'] = $param['fixed_amount'];               
                $data['arm_pid'] = $row->pid;
                $data['pid'] = public_id();
               $result = $this->updateOrCreateFeeAmount($data);               
            }
        }else{
            $count = count($param['arms']);
            for ($i=0; $i <$count; $i++) {
                $data['amount'] = $param['amount'][$i];
                $data['arm_pid'] = $param['arms'][$i];
                $data['pid'] = public_id();
                $result = $this->updateOrCreateFeeAmount($data);               
            }
        }
        return $result;
    }
    // this method insert fee amount and class arm 
    private function updateOrCreateFeeAmount(array $data){
        try {
            $dupParam = $data;
            unset($dupParam['pid']);
            unset($dupParam['amount']);
            return FeeItemAmount::updateOrCreate($dupParam, $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }
    // this goes to fee configuration table 
    private function updateOrCreateFeeConfig(array $data){// this return pid
        unset($data['arms']);
        unset($data['amount']);
        unset($data['fixed_amount']);
        try {
            $pid = self::getFeeConfigPid(item_pid: $data['fee_item_pid'], type: $data['type'], category: $data['category']);
            if ($pid) {
                return $pid;
            }
            $data['pid'] = public_id();
            $result = FeeConfiguration::create($data);
            return $result->pid;
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }

    // this return fee configuration pid 
    public static function getFeeConfigPid($item_pid,$type,$category){
       try {
            return FeeConfiguration::where([
                                            'fee_item_pid' => $item_pid,
                                            'type' => $type, 
                                            'category' => $category,
                                            'school_pid'=>getSchoolPid()
                                        ])->pluck('pid')->first();
       } catch (\Throwable $e) {
            logError($e->getMessage());
       }
    }
}
