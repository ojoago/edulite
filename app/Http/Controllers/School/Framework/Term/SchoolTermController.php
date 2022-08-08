<?php

namespace App\Http\Controllers\School\Framework\Term;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Term\ActiveTerm;
use App\Models\School\Framework\Term\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolTermController extends Controller
{
    public function __construct()
    {
        // school member auth 
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Term::where('school_pid',getSchoolPid())->get(['pid','term','description','created_at']);
                return datatables($data)->editColumn('created_at', function ($data) {
                    return date('d F Y', strtotime($data->created_at));
                })->make(true);
    }
    public function createSchoolTerm(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'term' => 'required',
        ]);
        if(!$validator->fails()){
            $data = [
                'pid'=>public_id(),
                'school_pid'=>getSchoolPid(),
                'term'=>ucwords($request->term),
                'description'=>$request->description,
            ];
            $result = $this->createOrUpdateTerm($data);
            if ($result) {

                return response()->json(['status'=>1,'message'=>'term created']);

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
            dd($error);
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
            $result = $this->updateOrCreateActiveTerm($data);
            if($result){

                return response()->json(['status'=>1,'message'=>'active term Set']);
            }
            return response()->json(['status'=>2,'message'=>'failed to submit']);
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function updateOrCreateActiveTerm($data){
        try {
            $request['school_pid'] = getSchoolPid();
            $result = ActiveTerm::updateOrCreate(['term_pid' => $data['term_pid'], 'school_pid' => $data['school_pid']], $data);
            if ($result) {
                return redirect()->route('school.term')->with('success', 'active term set');
            }
            return redirect()->back()->with('error', 'failed to set active term');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function loaSchoolActiveTerm(){

        $data = Term::join('active_terms', 'terms.pid', 'active_terms.term_pid')
        ->where(['terms.school_pid' => getSchoolPid()])
            ->select(['terms.term', 'active_terms.begin','active_terms.end',
                    'active_terms.note']);
        return datatables($data)->make(true);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
