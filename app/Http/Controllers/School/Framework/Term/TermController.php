<?php

namespace App\Http\Controllers\School\Framework\Term;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Payment\ResultRecordController;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Payment\ResultRecord;
use App\Models\School\Framework\Term\ActiveTerm;
use App\Http\Controllers\School\Staff\StaffController;
use App\Models\School\Framework\Term\ActiveTermDetail;
use App\Models\School\Student\Result\StudentClassResultParam;
use App\Http\Controllers\School\Student\StudentScoreController;

class TermController extends Controller
{
    
    public function index()
    {
        $data = Term::where('school_pid',getSchoolPid())->get(['pid','term','description','created_at']);
                return datatables($data)->editColumn('created_at', function ($data) {
                    return formatDate($data->created_at);
                })->addColumn('action', function ($data) {
            return view('school.framework.terms.term-action-button', ['data' => $data]);
        })->make(true);
    }
    
    public function createTerm(Request $request)
    {
        $in = $request['term'];
        // $request['term'] = strtoupper($request['term']); 
        $validator = Validator::make($request->all(),[
            'term' => ['required', Rule::unique('terms')->where(function ($query) use($request) {
                $query->where('school_pid', '=', getSchoolPid())->where('pid','<>',$request->pid);
            })]
        ],['term.required'=>'Enter Term name','term.unique'=>$in.' already exists']);
   
        if(!$validator->fails()){
            try {
                $data = [
                    'pid' => $request->pid ?? public_id(),
                    'school_pid' => getSchoolPid(),
                    'term' => $request->term,
                    'description' => $request->description,
                ];
                $result = $this->createOrUpdateTerm($data);
                if ($result) {

                        return response()->json(['status' => 1, 'message' => $request->pid ? 'Term Updated' : 'Term Created']);
                }

                return response()->json(['status' => 2, 'message' => 'failed to create term']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong... error logged']);
            }

        }

        return response()->json(['status'=>0, 'error' => $validator->errors()->toArray()]);

    }

   
    
    public function setActiveTerm(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'active_session'=>'required|string',
            'active_term'=>'required|string',
            'term_begin'=>'required',
            'term_end'=>'required',
            'next_term'=>'required',
        ],[
            'term_begin:requred'=>'enter begin of term date',
            'term_end:requred'=>'enter end date'
        ]);
        if(!$validator->fails()){
            $data = [
                'school_pid'=>getSchoolPid() ,
                'session_pid'=>$request->active_session ,
                'term_pid'=>$request->active_term ,
                'begin'=>$request->term_begin ,
                'end'=>$request->term_end ,
                'next_term'=>$request->next_term ,
                'note'=>$request->note ,
            ];
            $term = [
                'school_pid' => getSchoolPid(),
                'term_pid' => $request->active_term,
            ];
            $rdata=[
                'term_pid'=>activeTerm() ,
                'session_pid'=>activeSession() ,
                'school_pid' => getSchoolPid() ,
            ];

            ResultRecordController::computeTermlyResults();
            
            $result = $this->updateOrCreateActiveTerm($term);
           
            if($result){
                $this->updateOrCreateActiveTermDetail($data);
                if (isset($request->clone_class)) {
                    StaffController::reAssignClasses($rdata);
                }
                if (isset($request->clone_subject)) {
                    StaffController::reAssignSubjects($rdata);
                }
                return response()->json(['status'=>1,'message'=>'Active Term Set']);
            }
            return response()->json(['status'=>2,'message'=>'failed to submit']);
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }


    public function loaSchoolActiveTerm()
    {

        $data = Term::join('active_terms', 'terms.pid', 'active_terms.term_pid')
        ->where(['terms.school_pid' => getSchoolPid()])
            ->select(['term', 'active_terms.updated_at'])->get();
        return datatables($data)->editColumn('date', function ($data) {
            return formatDate($data->updated_at);
        })->make(true);
    }

    
    public function loaSchoolActiveTermDetails()
    {

        $data = Term::join('active_term_details', 'terms.pid', 'active_term_details.term_pid')
        ->join('sessions', 'sessions.pid', 'active_term_details.session_pid')
        ->where(['terms.school_pid' => getSchoolPid()])
            ->select(['term', 'begin', 'end', 'note', 'session', 'next_term'])->orderByDesc('active_term_details.id')->get();
        return datatables($data)->make(true);
    }

    private function createOrUpdateTerm($data)
    {
        try {
            return  Term::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


    private function updateOrCreateActiveTerm(array $data){
        try {
            return ActiveTerm::updateOrCreate(['school_pid' => $data['school_pid']], $data);
            
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    private function updateOrCreateActiveTermDetail(array $data){
        try {
            return ActiveTermDetail::updateOrCreate([
                                            'school_pid' => $data['school_pid'],
                                            'session_pid' => $data['session_pid'],
                                            'term_pid' => $data['term_pid'],
                                        ], $data);
            
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

  

    
     
}
