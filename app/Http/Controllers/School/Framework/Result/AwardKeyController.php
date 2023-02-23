<?php

namespace App\Http\Controllers\School\Framework\Result;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Result\AwardKey;

class AwardKeyController extends Controller
{

    public function index(){
        $data = AwardKey::where(['school_pid'=>getSchoolPid()])->get(['award','status', 'created_at']);
        return datatables($data)
        ->editColumn('date', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })
        // ->addColumn('action', function ($data) {
        //     return view('school.framework.terms.term-action-button', ['data' => $data]);
        // })
        ->addIndexColumn()
        ->make(true);
    
    }

    public function createStudentAward(Request $request){
        // 'term' => ['required', Rule::unique('terms')->where(function ($query) use($request) {
        //         $query->where('school_pid', '=', getSchoolPid())->where('pid','<>',$request->pid);
        //     })]
        $validator = Validator::make($request->all(), [
            'award' => ['required','string','max:50','regex:/^[a-zA-Z0-9\s]+$/',
                        Rule::unique('award_keys')->where(function($query) use($request){
                                $query->where('school_pid','=',getSchoolPid())->where('pid','<>',$request->pid);
                        })
                    ],
            'type' => 'nullable',
        ],['required' => 'Enter Award Name', 'max' => '50 is maximum characters', 'regex' => 'Specail Character not allowed']);

        if (!$validator->fails()) {
            $data = [
                'award' => $request->award,
                // 'type' => $request->type,
                'pid' => $request->pid ?? public_id(),
                'school_pid' => getSchoolPid()
            ];
            $result = $this->updateOrCreateAward($data);
            if ($result) {
                return response(['status' => 1, 'message' => 'Submitted Successful']);
            }
            return response(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
        return response(['status' => 0, 'message' => 'Fill the form Correctly', 'error' => $validator->errors()->toArray()]);

    }

    private function updateOrCreateAward($data){
        try {
            return AwardKey::updateOrCreate(['pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
}
