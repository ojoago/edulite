<?php

namespace App\Http\Controllers\School\Framework\Term;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Framework\Term\ActiveTerm;
use App\Models\School\Framework\Term\ActiveTermDetail;

class SchoolTermController extends Controller
{
    
    public function index()
    {
        $data = Term::where('school_pid',getSchoolPid())->get(['pid','term','description','created_at']);
                return datatables($data)->editColumn('created_at', function ($data) {
                    return date('d F Y', strtotime($data->created_at));
                })->addColumn('action', function ($data) {
            return view('school.framework.terms.term-action-button', ['data' => $data]);
        })->make(true);
    }
    public function createSchoolTerm(Request $request)
    {
        $in = $request['term'];
        // $request['term'] = strtoupper($request['term']); 
        $validator = Validator::make($request->all(),[
            'term' => ['required', Rule::unique('terms')->where(function ($query) use($request) {
                $query->where('school_pid', '=', getSchoolPid())->where('pid','<>',$request->pid);
            })]
        ],['term.required'=>'Enter Term name','term.unique'=>$in.' already exists']);
   
        if(!$validator->fails()){
            $data = [
                'pid'=> $request->pid ?? public_id(),
                'school_pid'=>getSchoolPid(),
                'term'=>$request->term,
                'description'=>$request->description,
            ];
            $result = $this->createOrUpdateTerm($data);
            if ($result) {
                if($request->pid){

                    return response()->json(['status'=>1,'message'=>'Term Updated']);
                }
                return response()->json(['status'=>1,'message'=>'Term Created']);

            }

            return response()->json(['status'=>2,'message'=>'failed to create term']);

        }

        return response()->json(['status'=>0, 'error' => $validator->errors()->toArray()]);

    }

    private function createOrUpdateTerm($data)
    {
        try {
            return  Term::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    public function loadSchoolTerm(){
        $result = Term::where(['school_pid' => getSchoolPid()])
            ->limit(10)->orderBy('id', 'DESC')
            ->get(['pid', 'term']);
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->term,
            ];
        }
        return response()->json($data);
    }
    public function setSchoolActiveTerm(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'active_session'=>'required|string',
            'active_term'=>'required|string',
            'term_begin'=>'required',
            'term_end'=>'required',
        ],[
            'term_begin:requred'=>'enter begin of term date',
            'term_end:requred'=>'enter end date'
        ]);

        if(!$validator->fails()){
            $data = [
                'school_pid'=>getSchoolPid(),
                'session_pid'=>$request->active_session,
                'term_pid'=>$request->active_term,
                'begin'=>$request->term_begin,
                'end'=>$request->term_end,
                'note'=>$request->note,
            ];
            $term = [
                'school_pid' => getSchoolPid(),
                'term_pid' => $request->active_term,
            ];
            $result = $this->updateOrCreateActiveTerm($term);
            if($result){
                $this->updateOrCreateActiveTermDetail($data);
            }
            if($result){

                return response()->json(['status'=>1,'message'=>'Active Term Set']);
            }
            return response()->json(['status'=>2,'message'=>'failed to submit']);
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function updateOrCreateActiveTerm(array $data){
        try {
            return ActiveTerm::updateOrCreate(['school_pid' => $data['school_pid']], $data);
            
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
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
            $error = $e->getMessage();
            logError($error);
        }
    }

    public function loaSchoolActiveTerm()
    {

        $data = Term::join('active_terms', 'terms.pid', 'active_terms.term_pid')
        ->where(['terms.school_pid' => getSchoolPid()])
            ->select(['term', 'active_terms.updated_at'])->get();
        return datatables($data)->editColumn('date',function($data){
            return date('d F Y', strtotime($data->updated_at));
        })->make(true);
    }
    public function loaSchoolActiveTermDetails(){

        $data = Term::join('active_term_details', 'terms.pid', 'active_term_details.term_pid')
                        ->join('sessions','sessions.pid', 'active_term_details.session_pid')
        ->where(['terms.school_pid' => getSchoolPid()])
            ->select(['term', 'begin','end','note','session'])->orderByDesc('active_term_details.id')->get();
        return datatables($data)->make(true);

    }
     
}
