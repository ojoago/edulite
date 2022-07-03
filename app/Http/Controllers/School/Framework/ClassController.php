<?php

namespace App\Http\Controllers\School\Framework;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\Classes;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = Category::where(['school_pid'=>getSchoolPid()])->get(['category','pid']);
        $class = Classes::where(['school_pid'=>getSchoolPid()])->get(['class','pid']);
        return view('school.framework.class.index',compact('data','class'));
    }
    public function createCategory(Request $request)
    {
        $request->validate([
            'category'=>'required'
        ]);
        $result = $this->insertOrUpdateCategory($request->all());
        if($result){
            return redirect()->back()->with('success','operation successfull');
        }
        return redirect()->back()->with('danger','operation failed');
    }

    private function insertOrUpdateCategory($data){
        try {
            $data['school_pid'] = getSchoolPid();
            $data['staff_pid'] = getUserPid();
            $data['pid'] = public_id();
            return Category::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function createClass(Request $request)
    {
        $request->validate([
            'category_pid'=>'required',
            'class'=>'required',
        ]);
        $result = $this->insertOrUpdateClass($request->all());
        if($result){
            return redirect()->back()->with('success','Operation Successfull');
        }
        return redirect()->back()->with('danger','operation failed');
    }

    private function insertOrUpdateClass($data){
        try {
            $data['school_pid'] = getSchoolPid();
            $data['staff_pid'] = getUserPid();
            $data['pid'] = public_id();
            return Classes::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    public function createClassArm(Request $request)
    {
        $request->validate([
            'arm'=>'required',
            'class_pid'=>'required',
        ]);
        $result = $this->insertOrUpdateClassArm($request->all());
        if($result){
            return redirect()->back()->with('success','Operation Successfull');
        }
        return redirect()->back()->with('danger','operation failed');
    }

    private function insertOrUpdateClassArm($data){
        try {
            $data['school_pid'] = getSchoolPid();
            $data['staff_pid'] = getUserPid();
            $data['pid'] = public_id();
            return ClassArm::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
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
