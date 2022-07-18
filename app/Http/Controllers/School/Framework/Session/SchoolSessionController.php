<?php

namespace App\Http\Controllers\School\Framework\Session;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Session\ActiveSession;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Staff\SchoolStaff;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolSessionController extends Controller
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
    public function ajax()
    {
        $data = Session::where(['school_pid'=>getSchoolPid()])->get(['pid','session','created_at']);
        return datatables($data)->make(true);
       return view('school.framework.session.school_session',compact('data'));
    }
    public function index()
    {
        $data = Session::where(['school_pid'=>getSchoolPid()])->get(['pid','session','created_at']);
       return view('school.framework.session.school_session',compact('data'));
    }
    public function createSession(Request $request)
    {
        //return 'it sends';
        $validator = Validator::make($request->all(),[
            'session' => 'required'
        ]);
       if(!$validator->fails()){
            
            $data = [
                'pid' =>public_id(),
                'school_pid'=>getSchoolPid(),
                'staff_pid'=>getSchoolUserPid(),
                'session'=>$request->session
            ];
            $query = Session::where(['school_pid'=>getSchoolPid(),'session'=>$data['session']])->first();
            if($query){
                $data = $query;
                // $msg = "exists in is it";
            }
            $result = $this->createOrUpdateSession($data);
            if ($result) {
                return response()->json(['status'=>1,'message'=> 'Session created']);
            }
       }
       
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function createOrUpdateSession($data){
        try {
           return  Session::updateOrCreate(['pid'=>$data['pid'],'school_pid'=>$data['school_pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    public function setActiveSession(Request $request)
    {
       $request->validate([
            'session_pid'=>'required'
       ]);
       try {
            $request['school_pid'] = getSchoolPid();
            //    $request['staff_pid'] = getUserPid();
            $result = ActiveSession::updateOrCreate(['session_pid' => $request['session_pid'], 'school_pid' => $request['school_pid']], $request->all());
            if ($result) {
                return redirect()->back()->with('success', 'session updated');
            }
            return redirect()->back()->with('error', 'failed to create session');
       } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
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
