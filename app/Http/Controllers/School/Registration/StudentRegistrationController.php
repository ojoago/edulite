<?php

namespace App\Http\Controllers\School\Registration;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Registration\SchoolStudent;
use App\Models\School\School;
use App\Models\School\Student\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentRegistrationController extends Controller
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
        $cnd = ['school_pid',getSchoolPid()];
        $data = User::get(['pid','username']);
        $school = School::get(['pid','school_name']);
        $arm = ClassArm::get(['pid','arm']);
        return view('school.registration.student.index',compact('data','school','arm'));
    }

    public function registerStudent(Request $request){
        $request->validate([
            'reg_number'=>'required',
            // 'reg_number'=>'required',
        ]);
        $request['pid'] = public_id();
        try {
            $result = Student::create($request->all());
            if($result){
                return back()->with('success','student registered');
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
            return back()->with('success','student registered');

        }
        dd($request->all());
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
