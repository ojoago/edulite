<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Subject\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function createSubject(Request $request)
    {
        $request->validate([
            'subject' => 'required:string',
            'subject_type_pid' => 'required:string'
        ]);
        $request['school_pid'] = getSchoolPid();
        $request['pid'] = public_id();
        $request['staff_pid'] = getUserPid();
        $data = $this->createOrUpdateSubject($request->all());
        if ($data) {
            return redirect()->route('school.subject.type')->with('success', 'Subject type created');
        }
        return redirect()->route('school.subject.type')->with('danger', 'failed to create Subject type');
    }

    private function createOrUpdateSubject($data)
    {
        try {
            return  Subject::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
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
