<?php

namespace App\Http\Controllers\School\Framework\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Grade\GradeKey;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Grade\SchoolGrade;

class GradeKeyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $arm=$session=$term=$data = [];
       $cnd = ['school_pid'=> getSchoolPid()];
       $cat = Category::where($cnd)->get(['pid', 'category']);
       $arm = ClassArm::where($cnd)->get(['pid','arm']);
       $session = Session::where($cnd)->get(['pid','session']);
       $term = Term::where($cnd)->get(['pid','term']);  
       return view('school.framework.grade.index',compact('data','session','term','arm','cat'));
    }
    public function createGradeKey(Request $request)
    {
    //    dd($request->all());
        $request['school_pid'] = getSchoolPid();
        $request['staff_pid'] = getUserPid();
        $pid = $this->createSchoolGrade($request->all());
        $request['grade_pid'] = $pid;
        $request['pid'] = public_id();
        try{
            GradeKey::create($request->all());
            return redirect()->back()->with('success','grade created');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    private function createSchoolGrade($data){
        try {
            $data['pid'] = public_id();
            $data = SchoolGrade::create($data);
            return $data->pid;
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
