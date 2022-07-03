<?php

namespace App\Http\Controllers\School\Framework\Session;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Session\ActiveSession;
use App\Models\School\Framework\Session\Session;
use Illuminate\Http\Request;

class SchoolSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Session::where(['school_pid'=>getSchoolPid()])->get(['pid','session']);
       return view('school.framework.session.index',compact('data'));
    }
    public function createSession(Request $request)
    {
       $request->validate([
        'session'=>'required'
       ]);
       $request['pid'] = public_id();
       $request['school_pid'] = getSchoolPid();
       $request['staff_pid'] = getUserPid();
       $result = $this->createOrUpdateSession($request->all());
       if($result){
            return redirect()->back()->with('success','session created');
        }
        return redirect()->back()->with('error','failed to create session');
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
