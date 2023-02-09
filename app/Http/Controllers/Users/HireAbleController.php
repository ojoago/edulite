<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\HireAble;
use App\Models\Users\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Stmt\TryCatch;

class HireAbleController extends Controller
{
    public function openForHire(Request $request){

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
                'subjects' => json_encode($request->subject),
                'user_pid' => getUserPid(),
            ];
            if(isset($request->about)){
                $this->updateAbout($request->about);
            }
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
            $dtl = UserDetail::where(['user_pid' => getUserPid()])->update('about', $about);
            return $dtl;
        }catch(\Throwable $e){
            return false;
        }
    }
}
