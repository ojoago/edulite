<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\ClassRep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentClassController extends Controller
{
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    public function assignClassRep(Request $request){
        $validator = Validator::make($request->all(),[
            // 'session_pid'=>'required',
            // 'term_pid' => 'required',
            'arm_pid' => 'required',
            'student_pid' => 'required',
            'category_pid' => 'required',
            'class_pid' => 'required',
        ],[
            // 'session_pid.required'=>'Select Session',
            // 'term_pid.required'=>'Select Term',
            'arm_pid.required'=>'Select class Arm',
            'student_pid.required'=>'Select class rep',
            'category_pid.required'=>'Category is required',
            'class_pid.required'=>'Class is required',
        ]);
        
        if(!$validator->fails()){
            $data = [
                'session_pid' =>activeSession(),
                'term_pid' => activeTerm(),
                'arm_pid' => $request->arm_pid,
                'student_pid' => $request->student_pid,
                'school_pid'=>getSchoolPid()
            ];
            $result = $this->updateOrCreateClassRep($data);
            if($result){

                return response()->json(['status' => 1, 'message' =>'Class Rep Assign']);
                
            }
            return response()->json(['status' => 'error', 'message' =>'Something Went Wrong']);
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }
    
    private function updateOrCreateClassRep(array $data){
        try {
            $dupParam = $data;
            $data['staff_pid'] = getSchoolUserPid();
            unset($dupParam['student_pid']);
            return ClassRep::updateOrCreate($dupParam, $data);
        } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
            logError($error);
        }
    }
}
