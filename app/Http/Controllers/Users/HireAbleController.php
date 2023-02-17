<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\Users\HireAble;
use App\Models\Users\UserDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class HireAbleController extends Controller
{
    public function hireMeConfig(Request $request){

        if(!$this->confirmDetail()){
            return response(['status' => 'error', 'message' => 'Update your user details first!!!']);
        }
        $validator = Validator::make($request->all(),[
            'about'=>'required|string|max:250',
            'qualification'=>'required|string|max:100',
            'course'=>'nullable|max:64',
            'years'=>'int|nullable',
            'status'=>'int|required',
            'state'=>'required',
            'lga'=>'nullable|string'
        ]);

        if(!$validator->fails()){
            $data = [
                'qualification' => $request->qualification,
                'course' => $request->course,
                'years' => $request->years,
                'status' => $request->status,
                'state' => $request->state,
                'lga' => $request->lga,
                'area' => $request->area,
                'years' => $request->years,
                // 'subjects' => json_encode($request->subject),
                'user_pid' => getUserPid(),
            ];
            if(isset($request->about)){
                $this->updateAbout($request->about);
            }
            $data['subjects'] = $this->getSubjectName($request->subject);
            $result = $this->updateOrCreateHireMeDetail($data);
            if($result){
                return response(['status'=>1,'message'=>'Details Updated']);
            }
            return response(['status'=>'error','message'=>'Something Went Wrong...']);
        }
        return response(['status'=>0,'message'=>'Fill the form Correctly','error'=>$validator->errors()->toArray()]);
    }
    
    private function updateOrCreateHireMeDetail(array $data){
        try{
          return HireAble::updateOrCreate(['user_pid'=>getUserPid()],$data);
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }

    }

    private function updateAbout(string $about){
        try{
            $dtl = UserDetail::where(['user_pid' => getUserPid()])->update(['about'=>$about]);
            return $dtl;
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }
    }

    private function confirmDetail(){
        try {
            return UserDetail::where(['user_pid' => getUserPid()])->first(['id']);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


    public function loadHireMeConfig(){
        try {
            $data = DB::table('user_details as d')->leftJoin('hire_ables as h', 'd.user_pid', 'h.user_pid')
                ->where('d.user_pid', getUserPid())->select('h.*', 'd.about')->first();
            return $data;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
    }

    // school recruitment 
    public function submitRecruitment(Request $request){

        $validator = Validator::make($request->all(), [
            'qualification' => 'required|string|max:100',
            'course' => 'nullable|max:64',
            'years' => 'int|nullable',
            'status' => 'int|required',
            'note' => 'nullable|string'
        ]);

        if(!$validator->fails()){
            $data = [
                'qualification' => $request->qualification,
                'course' => $request->course,
                'years' => $request->years,
                'status' => $request->status,
                'note' => $request->note
            ];
            
        }

    }

    // load avaible hire for school 
    public function loadPotentialApplicantHireConfig(Request $request){
        $data = DB::table('user_details as d')->join('users as u','u.pid','d.user_pid')
                    ->join('hire_ables as h', 'd.user_pid', 'h.user_pid')
                    ->leftJoin('states as s','s.id','d.state')->leftJoin('state_lgas as lg','lg.id','d.lga')
        ->where('h.status',1)
        ->select('qualification', 'course', 'd.about', 'years','status','subjects','d.fullname','u.gsm')->get();
        return datatables($data)
        ->editColumn('years', function ($data) {
            return $data->years . ' year (s)';
        })
        ->addIndexColumn()
            ->make(true);
    }

    private function getSubjectName(array $data){
        $sbj = '';
        foreach ($data as $row) {
           $sbj.= getSubjectNameByPid($row) .', ';
        }
        return removeThis(trim($sbj));
    }

}
