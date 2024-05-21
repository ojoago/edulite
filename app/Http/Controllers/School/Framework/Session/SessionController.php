<?php

namespace App\Http\Controllers\School\Framework\Session;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Session\ActiveSession;

class SessionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  create and list session tab begin 
    public function index()
    {
        // datatable serve 
        $data = Session::where(['school_pid'=>getSchoolPid()])->select(['pid','session','created_at']);
        return datatables($data)->editColumn('date', function ($data) {
            return $data->created_at->diffForHumans();
        })->addColumn('action',function($data){
            return view('school.framework.session.session-action-button', ['data' => $data]);
        })->make(true);

    }

    public function createSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session' => ['required',Rule::unique('sessions')->where(function($q) use ($request){
                $q->where('school_pid',getSchoolPid())->where('pid','<>',$request->pid);
            })]
        ],['session.required'=>'Enter session','session.unique'=>$request->session.' already exist']);
        if (!$validator->fails()) {
            $data = [
                'pid' => $request->pid ?? public_id(),
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid(),
                'session' => $request->session
            ];
            $result = $this->createOrUpdateSession($data);
            if ($result) {
                if($request->pid){
                    return response()->json(['status' => 1, 'message' => 'Session Updated']);
                }
                return response()->json(['status' => 1, 'message' => 'Session created']);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function createOrUpdateSession($data)
    {
        try {
            return  Session::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    // end 

    
    // active session tab

    public function loadSchoolActiveSession()
    {
        $data = Session::join('active_sessions', 'sessions.pid', 'active_sessions.session_pid')
        ->where(['sessions.school_pid' => getSchoolPid()])
            ->select(['sessions.session', 'active_sessions.created_at']);
        return datatables($data)->editColumn('created_at', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })->make(true);
    }
    
   
    
    public function setActiveSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'active_session' => 'required'
        ]
        // , ['session_pid:required' => 'Select Active Session']
    );
        if(!$validator->fails()){
            $data = [
                'school_pid'=>getSchoolPid(),
                'session_pid'=>$request->active_session
            ];
            $result = $this->updateActiveSession($data);
            if($result){
                return response()->json(['status' => 1, 'message' => 'School Active session updated']);
            }
            return response()->json(['status' => 2, 'message' => 'update failed']);
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function updateActiveSession($data){
        try {
          return ActiveSession::updateOrCreate(['school_pid' => $data['school_pid']],$data);
            
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
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
