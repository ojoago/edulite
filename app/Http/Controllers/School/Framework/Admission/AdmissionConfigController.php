<?php

namespace App\Http\Controllers\School\Framework\Admission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Admission\AdmissionSetup;
use App\Models\School\Framework\Admission\AdmissionDetail;

class AdmissionConfigController extends Controller
{
    

    public function index(){
        $data = $this->loadAdmission();
        return datatables($data)
        ->editColumn('date', function ($data) {
            return date('d F Y',  strtotime($data->created_at));
        })
        ->addIndexColumn()
        ->make(true);
    }
    private function loadAdmission(){
        $data = DB::table('admission_details as ad')->join('sessions as s', 's.pid', 'ad.session_pid')
            ->join('admission_setups as as', 'as.admission_pid', 'ad.pid')
            ->join('classes as c', 'c.pid', 'as.class_pid')
            ->select('from', 'to', 'class', 'session', 'ad.created_at','amount','as.id')
            ->orderByDesc('ad.id')
            ->get();
        return $data;
    }
    public function setup(){
        $data = $this->loadAdmission();
        return datatables($data)
        ->editColumn('date', function ($data) {
            return date('d F Y',  strtotime($data->created_at));
        })
        ->editColumn('amount', function ($data) {
            return number_format($data->amount,2);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function setAdmissionClass(Request $request){
        $validator = Validator::make($request->all(),[
            'from'=> 'required|date|before_or_equal:to',
            'to'=> 'required|date|after_or_equal:from',
            'session_pid'=>'required',
            'class_pid'=>'required',
        ],[
            'to.required'=>'closing date is required',
            'from.required'=>'start date is required',
            'class_pid.required'=>'Select 1 class at least',
            'session_pid.required'=>'Select Session',
            'from.before_or_equal'=> 'start must be equal or less than closing date',
            'to.before_or_equal'=> 'closing must be equal or greater than start date'
        ]);

        if(!$validator->fails()){
            $data = [
                'pid'=> $request->pid ?? public_id(),
                'from'=>$request->from,
                'to'=>$request->to,
                'session_pid'=>$request->session_pid,
                'creator'=>getSchoolUserPid(),
                'school_pid'=>getSchoolPid()
            ];

            $result = $this->setupAdmission($data);
            if($result){
                $data = ['admission_pid'=>$result->pid,'class'=>$request->class_pid,'amount'=>$request->fee];
                $result = $this->setupAdmissionclass($data);
                if($result){

                    return response()->json(['status'=>1,'message'=>'Admission Configration Successfully created']);
                }
            }
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function setupAdmission(array $data){
        return  AdmissionDetail::updateOrCreate(['session_pid'=>$data['session_pid']],$data);
    }
    private function setupAdmissionclass(array $data){
        $count = count($data['class']);
        $setup = [
            'admission_pid' => $data['admission_pid'],
            'school_pid'=>getSchoolPid()
        ];
        DB::statement("DELETE FROM admission_setups where admission_pid = '".$data['admission_pid']."' ");
        $setups = [];
        for ($i=0; $i < $count; $i++) { 
            $setup['class_pid'] = $data['class'][$i];
            $setup['amount'] = $data['amount'] ?? 0;
            $setup['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');
            // $result = AdmissionSetup::updateOrCreate($dupParam, $setup);
            $setups[] = $setup;
        }
        $result = AdmissionSetup::insert($setups);
        return $result;
    }

}
