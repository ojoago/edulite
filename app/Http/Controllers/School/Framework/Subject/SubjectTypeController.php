<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Subject\SubjectType;

class SubjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $data = SubjectType::where(['school_pid'=>getSchoolPid()])->get(['pid','subject']);
        return view('school.framework.subject.index',compact('data'));
    }
    public function createSubjectType(Request $request)
    {
        $request->validate([
            'subject'=> 'required:string'
        ]);
        
        //uniqueNess('subject_types','subject',$request->subject);
        
        $request['school_pid'] = getSchoolPid();
        $request['pid'] = public_id();
        $request['staff_pid'] = getUserPid();
        $data = $this->createOrUpdateSubjectType($request->all());
        if($data){
            return redirect()->route('school.subject.type')->with('success','Subject type created');
        }
        return redirect()->route('school.subject.type')->with('danger','failed to create Subject type');
    }

    private function createOrUpdateSubjectType($data)
    {
        try {
            return  SubjectType::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
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
