<?php

namespace App\Http\Controllers\School\Framework\Term;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Term\ActiveTerm;
use App\Models\School\Framework\Term\Term;
use Illuminate\Http\Request;

class SchoolTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Term::where('school_pid',getSchoolPid())->get(['pid','term']);
        return view('school.framework.terms.index',compact('data'));
    }
    public function createTerm(Request $request)
    {
        $request->validate([
            'term' => 'required',
        ]);
        $request['pid'] = public_id();
        $request['school_pid'] = getSchoolPid();
        // $request['staff_pid'] = getUserPid();
        $result = $this->createOrUpdateSession($request->all());
        if ($result) {
            return redirect()->back()->with('success', 'Term created');
        }
        return redirect()->back()->with('error', 'failed to create Term');
    }

    private function createOrUpdateSession($data)
    {
        try {
            return  Term::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function setActiveTerm(Request $request)
    {
        $request->validate([
            'term_pid' => 'required'
        ]);
        // dd($request->all());
        try {
            $request['school_pid'] = getSchoolPid();
            $result = ActiveTerm::updateOrCreate(['term_pid' => $request['term_pid'], 'school_pid' => $request['school_pid']], $request->all());
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
