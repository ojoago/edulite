<?php

namespace App\Http\Controllers\School\Framework\Fees;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Fees\FeeItem;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Fees\FeeAccount;
use App\Models\School\Framework\Fees\FeeItemAmount;
use App\Models\School\Framework\Fees\StudentInvoice;
use App\Models\School\Framework\Fees\FeeConfiguration;
use App\Models\School\Framework\Fees\ClassInvoiceParam;
use App\Http\Controllers\School\Framework\ClassController;

class FeeItemController extends Controller
{
    
    public function loadFeeAccount(){
        $data = FeeAccount::where(['school_pid'=>getSchoolPid()])->get();
        return datatables($data)
        
        ->addColumn('action',function($data){
            return view('school.framework.fees.fee-account-action-button',['data'=>$data]);
        })
        ->addIndexColumn()
        ->make(true);
    }


    public function loadFeeItems(){
        $result = FeeAccount::where(['school_pid' => getSchoolPid()])
            ->orderBy('bank_name')->get(['pid', 'account_name', 'bank_name']); //
        $data = DB::table('fee_items as f')->join('fee_accounts as a','a.pid','f.account_pid')->where(['f.school_pid' => getSchoolPid()])->select('a.account_name','f.*')->get();
        return datatables($data)
        ->editColumn('status',function($data){
            return $data->status == 1 ? 'Enabled' : 'Disabled';
        })
        // ->editColumn('date',function($data){
        //     return $data->created_at->diffForHumans();
        // })
        ->addColumn('action',function($data) use ($result){
            return view('school.framework.fees.fee-item-action-button',['data'=>$data,'accounts'=> $result]);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function loadFeeAmount(){

        $arms = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1])->orderBy('arm')->get(['pid', 'arm']); //
        $fees = FeeItem::where(['school_pid' => getSchoolPid()])->orderBy('fee_name')->get(['pid', 'fee_name']); //
        $data = DB::table('fee_configurations as c')
                    ->join('fee_items as f','f.pid','c.fee_item_pid')
                    ->join('fee_item_amounts as i','i.config_pid','c.pid')
                    ->join('class_arms as a','a.pid','i.arm_pid')
                    ->where(['i.school_pid' => getSchoolPid()])
                    ->select('arm','amount','i.pid',
                    'fee_name','category','gender','religion','type','payment_model')
                    ->orderBy('fee_name')->orderBy('arm')
                    ->get();
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
        ->addColumn('action', function ($data) use($arms,$fees) {
            return view('school.framework.fees.fee-amount-action-button', ['data' => $data,'fees' => $fees , 'arms' => $arms]);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function loadFeeConfig(){
        $data = DB::table('fee_configurations as c')
                    ->join('fee_items as f','f.pid','c.fee_item_pid')
                    ->select('fee_name','category','gender','religion','type','payment_model','c.created_at')->where(['c.school_pid'=>getSchoolPid()])
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
                return matchPaymentCategory($data->category);
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

    // load student invoice 
    public function loadStudentInvoice(Request $request)
    {

        if (isset($request->session_pid) && isset($request->term_pid)) {
            $where = ['p.term_pid' => $request->term_pid, 'p.session_pid' => $request->session_pid, 'si.school_pid' => getSchoolPid(), 'si.status' => 0];
        } else {
            $where = ['p.term_pid' => activeTerm(), 'p.session_pid' => activeSession(), 'p.school_pid' => getSchoolPid(), 'si.status' => 0];
        }

        $data = DB::table('student_invoices as si')
            ->join('fee_item_amounts as fa','fa.pid', 'si.item_amount_pid')
            ->join('fee_configurations as fc', 'fa.config_pid', 'fc.pid')
            ->join('students as st','st.pid','si.student_pid')
            ->join('class_invoice_params as p','p.pid','si.param_pid')
            ->join('fee_items as f', 'f.pid', 'fc.fee_item_pid')
            ->join('class_arms as a', 'a.pid', 'p.arm_pid')
            ->join('terms as t','t.pid','p.term_pid')
            ->join('sessions as s','s.pid','p.session_pid')
            ->where($where)
            ->select(
                'reg_number',
                'fullname',
                'st.pid as spid',
                'a.arm',
                'si.amount',
                'si.pid',
                't.term',
                's.session',
                'fee_name',
                'fc.type',
                'si.created_at'
            )
            ->orderBy('fee_name')->orderBy('arm')
            ->orderBy('fullname')
            ->orderBy('fee_name')
            ->get();
        return $this->addDatatable($data);
    }


    public function loadStudentPaidInvoice(Request $request)
    {

        if (isset($request->session_pid) && isset($request->term_pid)) {
            $where = ['p.term_pid' => $request->term_pid, 'p.session_pid' => $request->session_pid, 'si.school_pid' => getSchoolPid(),'si.status'=>1];
        } else {
            $where = ['p.term_pid' => activeTerm(), 'p.session_pid' => activeSession(), 'p.school_pid' => getSchoolPid(), 'si.status' => 1];
        }

        $data = DB::table('student_invoices as si')
            ->join('fee_item_amounts as fa','fa.pid', 'si.item_amount_pid')
            ->join('fee_configurations as fc', 'fa.config_pid', 'fc.pid')
            ->join('students as st','st.pid','si.student_pid')
            ->join('class_invoice_params as p','p.pid','si.param_pid')
            ->join('fee_items as f', 'f.pid', 'fc.fee_item_pid')
            ->join('class_arms as a', 'a.pid', 'p.arm_pid')
            ->join('terms as t','t.pid','p.term_pid')
            ->join('sessions as s','s.pid','p.session_pid')
            ->where($where)
            ->select(
                'reg_number',
                'fullname',
                'st.pid as spid',
                'a.arm',
                'si.amount',
                'si.pid',
                't.term',
                's.session',
                'fee_name',
                'fc.type',
                'si.created_at'
            )
            ->orderBy('fee_name')->orderBy('arm')
            ->orderBy('fullname')
            ->get();
        return $this->addDatatable($data);
    }

    private function addDatatable($data){
        return datatables($data)
            ->editColumn('fullname', function ($data) {
                return @$data->reg_number.' '.@$data->fullname;
            })
            ->editColumn('amount', function ($data) {
                return number_format($data->amount, 2);
            })
            ->editColumn('type', function ($data) {
                return matchPaymentType($data->type);
            })
            ->editColumn('date', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            // ->addColumn('action', function ($data) {
            //     return view('school.framework.fees.fee-amount-action-button', ['data' => $data]);
            // })
            ->addIndexColumn()
            ->make(true);
    }

    // load particular student invoice 
    public function loadParticularStudentInvoice(Request $request)
    {
        if (isset($request->session_pid) && isset($request->term_pid)) {
            $where = ['p.term_pid' => $request->term_pid, 'p.session_pid' => $request->session_pid, 'si.school_pid' => getSchoolPid(), 'si.status' =>0, 'si.student_pid' => $request->pid];
        } else {
            $where = ['p.term_pid' => activeTerm(), 'p.session_pid' => activeSession(), 'p.school_pid' => getSchoolPid(), 'si.status' => 0, 'si.student_pid'=>$request->pid];
        }
        // logError($request->pid);
        $data = DB::table('student_invoices as si')
        ->join('fee_item_amounts as fa', 'fa.pid', 'si.item_amount_pid')
        ->join('fee_configurations as fc', 'fa.config_pid', 'fc.pid')
        ->join('class_invoice_params as p', 'p.pid', 'si.param_pid')
        ->join('fee_items as f', 'f.pid', 'fc.fee_item_pid')
        ->join('class_arms as a', 'a.pid', 'p.arm_pid')
            ->join('terms as t', 't.pid', 'p.term_pid')
            ->join('sessions as s', 's.pid', 'p.session_pid')
            ->where($where)
            ->select(
                'a.arm',
                'si.amount',
                'si.pid',
                't.term',
                's.session',
                'fee_name',
                'fc.type',
                'si.created_at'
            )
            ->orderBy('fee_name')->orderBy('arm')
            ->get();
        return $this->addDatatable($data);
    }

    // load particular student invoice 
    public function loadParticularStudentPayment(Request $request)
    {
        // if (isset($request->session_pid) && isset($request->term_pid)) {
        //     $where = ['p.term_pid' => $request->term_pid, 'p.session_pid' => $request->session_pid, 'si.school_pid' => getSchoolPid(), 'si.status' =>0, 'si.student_pid' => base64Decode($request->pid)];
        // } else {
        //     $where = ['p.term_pid' => activeTerm(), 'p.session_pid' => activeSession(), 'p.school_pid' => getSchoolPid(), 'si.status' => 0, 'si.student_pid'=>base64Decode($request->pid)];
        // }
        // logError($request->pid);
        $data = DB::table('student_invoice_payments as sip')
            ->where(['sip.student_pid'=>$request->pid,'school_pid'=>getSchoolPid(),'sip.status'=>1])
            ->select(
                'sip.amount_paid',
                'sip.total',
                'sip.pid',
                'sip.invoice_number',
                'sip.created_at'
            )
            ->orderBy('created_at','DESC')
            ->get();
        return datatables($data)
            ->editColumn('total', function ($data) {
                return number_format($data->total, 2);
            })
            ->editColumn('paid', function ($data) {
                return number_format($data->amount_paid, 2);
            })
            ->editColumn('date', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->addIndexColumn()
            ->make(true);
    }

   
    // create school fee names 
    public function createFeeName(Request $request){
        $validator = Validator::make($request->all(),[
            'fee_name'=>[
                'required',
                'string',
                Rule::unique('fee_items')->where(function($param) use($request){
                    $param->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid);
                })],
            'account_pid' => 'required'
        ]);

        if(!$validator->fails()){
            $data = [
                'fee_name'=>$request->fee_name,
                'account_pid'=>$request->account_pid,
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

    // create the name 
    
    // create school fee names 
    public function createFeeAccount(Request $request){
        $validator = Validator::make($request->all(),[
            'account_number'=>[
                'required',
                'digits:10',
                Rule::unique('fee_accounts')->where(function($param) use($request){
                    $param->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid);
                })],
            'account_name' => 'required' ,
            'bank_name' => 'required'
        ]);

        if(!$validator->fails()){
            $data = [
                'account_number' => $request->account_number ,
                'account_name' => $request->account_name ,
                'bank_name' => $request->bank_name ,
                'bank_code' => ' ' ,
                'pid'=> $request->pid ?? public_id() ,
                'school_pid' => getSchoolPid() ,
                // 'staff_pid'=>getSchoolUserPid()
            ];
            // 
            $result = $this->updateOrCreateFeeAccount($data);
            if($result){
                return response()->json(['status'=>1,'message' => $request->pid ? 'Bank Account updated' : 'Bank Account Added']);
            }
        }
        return response()->json(['status'=>0,'error' => $validator->errors()->toArray()]);
    }

    // create the name 



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
    // fee and amount configuration goes here 
    public function  updateFeeAmount(Request $request){

        $validator = Validator::make($request->all(),[
            'pid' => 'required',
            'amount' => 'required|numeric',
            'arm' => 'required',
        ],[
            'pid.required'=>'Select Fee Item',
            'arm.required'=>'Enter This or Remove it',
            'amount.required'=>'Enter Amount',
        ]);

        if(!$validator->fails()){
            $data['amount'] = $request->amount;
            $data['arm_pid'] = $request->arm;
            $data['pid'] = $request->pid;
            $fee = FeeItemAmount::where('pid', $request->pid)->first();
            $fee->amount = $request->amount;
            $fee->arm_pid = $request->arm;
            $result = $fee->save();
            if($result){
                return response()->json(['status'=>1,'message'=>'Fee amount updated successfully']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong... error log']);
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }

    private function updateOrCreateFeeAccount(array $data) {
        try {
            return FeeAccount::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    private function updateOrCreateFeeName(array $data) {
        try {
            return FeeItem::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    // this method sort class and amount based on category selected 
    private function prepareFeeAmount(string $pid, array $param){
        $data = [
            'school_pid' => getSchoolPid(),
            'config_pid' => $pid,
            // 'term_pid' => activeTerm(),
            // 'session_pid' => activeSession()
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
            return false;
        }
    }
    // this goes to fee configuration table 
    private function updateOrCreateFeeConfig(array $data){// this return pid
        unset($data['arms']);
        unset($data['amount']);
        unset($data['fixed_amount']);
        try {
            $pid = self::getFeeConfigPid(item_pid: $data['fee_item_pid'], type: $data['type'], category: $data['category'],model:$data['payment_model']);
            if ($pid) {
                return $pid;
            }
            $data['pid'] = public_id();
            $result = FeeConfiguration::create($data);
            return $result->pid;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    // this return fee configuration pid 
    public static function getFeeConfigPid($item_pid,$type,$category,$model){
       try {
            return FeeConfiguration::where([
                                            'fee_item_pid' => $item_pid,
                                            // 'payment_model' => $model, 
                                            // 'type' => $type, 
                                            'category' => $category,
                                            'school_pid'=>getSchoolPid()
                                        ])->pluck('pid')->first();
       } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    // this methode initiate invoice generation for the class 
    public function generateAllInvoice(Request $request){
        $data = DB::table('fee_item_amounts as fa')->join('fee_configurations as fc', 'fa.config_pid', 'fc.pid')
                    ->where(['fa.school_pid'=>getSchoolPid()])->where('type','<>',2)
                    ->get(['fa.pid', 'amount', 'arm_pid','gender','religion','type','payment_model']);
        if($data->isNotEmpty()){
            $result = $this->prepareInvoice($data);
            if($result){
                return response()->json(['status' => 1, 'message' => ' Invoice generated for all classes based on configuration']);
            }
            return response()->json(['status' => 'error', 'message' => 'Invoice not completely generated']);
        }
        return response()->json(['status' => 'error', 'message' => 'No Fee item configured for any class']);
        
    }

    public function reGenerateAllInvoice(Request $request){
        $data = DB::table('fee_item_amounts as fa')->join('fee_configurations as fc', 'fa.config_pid', 'fc.pid')
                    ->where(['fa.school_pid'=>getSchoolPid()])->where('type','<>',3)
                    ->get(['fa.pid', 'amount', 'arm_pid','gender','religion','type','payment_model']);
        $result = $this->prepareInvoice($data);
        if($result){
            return response()->json(['status' => 1, 'message' => $data->count().' Invoice(s) generated for all classes']);
        }
        
        return response()->json(['status' => 0, 'message' => 'Something Went Wrong Y']);
    }

    private function prepareInvoice(array|null|object $params){
        try {
            $invoiceData = [];
            $parents=[];
            foreach ($params as $row) {
                $param_pid = $this->createClassInvoiceParam($row->arm_pid);// create class param and return the pid to avoid repeation

                $classStudent = $this->loadClassStudent($row->arm_pid,$row->gender,$row->religion);// load all student in a particular class arm
                foreach($classStudent as $std){ //loop a each 
                    $dupParam = [
                        'school_pid' => getSchoolPid(),
                        'student_pid'=>$std->pid,
                        'item_amount_pid' => $row->pid, // this should be item pid
                        'param_pid' => $param_pid,
                    ];
                    if($this->getStudentInvoice($dupParam)){ // check if the particular item invoice has been generated for the student 
                        $result = true;
                        continue; //if it exist continue 
                    }
                    $parents[]=$std->parent_pid; //save parent id in an array which will be used to send email later
                    $data = $dupParam;
                    $data['amount'] = $row->amount;
                    $data['pid'] = public_id();
                    $data['created_at'] = $data['updated_at'] = fullDate();
                    $invoiceData[] = $data;
                }
                $result = $this->generateStudentInvoice($invoiceData);// generate invoice for all student in a class arm
                $invoiceData = [];// set this to empty again an continue to the next class
            }
            return $result;

        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    // load student of a particular class arm based on configuration params
    private function loadClassStudent(string|null $arm_pid,null|int $gender,null|int $religion){// return current student in the selected class
        try {
            if($gender && $religion){
                $where = ['school_pid'=>getSchoolPid(),'religion'=>$religion,'gender'=>$gender, 'current_class_pid' => $arm_pid];
            }
            elseif($gender && !$religion){
                $where = ['school_pid' => getSchoolPid(), 'gender' =>$gender, 'current_class_pid' => $arm_pid];
            }
            elseif(!$gender && $religion){
                $where = ['school_pid' => getSchoolPid(),'religion' => $religion,  'current_class_pid' => $arm_pid];
            }
            else{
                $where = ['school_pid' => getSchoolPid(), 'current_class_pid' => $arm_pid];
            }
            $data = Student::where($where)->whereIn('status',[1,2])->get(['pid','parent_pid']);
            return $data;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    // create class param 
    private function createClassInvoiceParam(string|null $arm_pid){// return pid
        try {
            $data = [
                'arm_pid' => $arm_pid,
                'school_pid' => getSchoolPid(),
                'session_pid' => activeSession(),
                'term_pid' => activeTerm(),
            ];
            $result = ClassInvoiceParam::where($data)->pluck('pid')->first();
            if ($result) {
                return $result;
            }
            $data['pid'] = public_id();
            $result = ClassInvoiceParam::create($data);
            return $result->pid;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    // generate invoice 
    private function generateStudentInvoice(array|null $data){
        try {
           return StudentInvoice::insert($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    // check if invoice exist for item for a particular student
    private function getStudentInvoice(array|null $data){// return false or id
        return StudentInvoice::where($data)->pluck('id')->first();
    }


    // load all unpaid invoice of a particular student for payment
    public function loadStudentInvoiceByPid(Request $request){
        $data = DB::table('student_invoices as si')
        ->join('fee_item_amounts as fa', 'fa.pid', 'si.item_amount_pid')
        ->join('students as st', 'st.pid', 'si.student_pid')
        ->join('fee_configurations as fc', 'fa.config_pid', 'fc.pid')
            ->join('class_invoice_params as p', 'p.pid', 'si.param_pid')
            ->join('fee_items as f', 'f.pid', 'fc.fee_item_pid')
            ->join('class_arms as a', 'a.pid', 'p.arm_pid')
            ->join('terms as t', 't.pid', 'p.term_pid')
            ->join('sessions as s', 's.pid', 'p.session_pid')
            ->where(['si.school_pid'=>getSchoolPid(),'si.student_pid'=>$request->pid,'si.status'=>0])
            ->select('si.pid','a.arm','t.term','s.session','fee_name','si.amount','si.created_at','st.fullname','st.reg_number')
            ->orderBy('arm')
            ->orderBy('term')
            ->orderBy('session')
            ->get();
        return formatStudentFees($data);
    }

   
}
