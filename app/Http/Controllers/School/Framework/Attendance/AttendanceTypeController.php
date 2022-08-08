<?php

namespace App\Http\Controllers\School\Framework\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Attendance\AttendanceType;
use App\Models\School\Framework\Attendance\ClassAttendance;
use Illuminate\Support\Facades\Validator;

class AttendanceTypeController extends Controller
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
        $data = AttendanceType::where('school_pid', getSchoolPid())->get(['pid', 'title', 'description', 'created_at']);
        return datatables($data)
        ->addColumn('action', function ($data) {
            $html = '<a href="/reminders/' . $data->pid . '/done"><button class="button is-primary" type="submit" data-toggle="tooltip" title="Edit Session"><i class="fa fa-check-square-o" aria-hidden="true"></i></button></a>';
            return $html;
        })
        ->editColumn('created_at', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })
        ->rawColumns(['data', 'action'])
        ->make(true);
        
    }

    public function createAttendanceType(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string'
        ],['title.required'=>'Enter Attendance Name','title.string'=>'Attendance Name should be text']);
        if(!$validator->fails()){
            $data['pid'] = public_id();
            $data['staff_pid'] = getSchoolUserPid();
            $data['school_pid'] = getSchoolPid();
            $data['title'] = $request->title;
            $data['description'] = $request->description;
            $result = $this->createOrUpdateAttendanceType($data);
            if($result){

                return response()->json(['status'=>1,'message'=>'Attendance Type Created Successfully']);
                
            }
            return response()->json(['status'=>2,'message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        
    }

    private function createOrUpdateAttendanceType($data){
        try {
          return AttendanceType::updateOrCreate(['pid'=>$data['pid'],'school_pid'=>$data['school_pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function createCLassAttendance(Request $request){
        $request->validate([
            'attendance_pid'=>'required|string',
            'arm_pid'=>'required|string',
            'session_pid' => 'required|string',
            'term_pid' => 'required|string',
        ]);
        $request['pid'] = public_id();
        $request['school_pid'] = getSchoolPid();
        $request['staff_pid'] = getUserPid();
        $result = $this->createOrUpdateClassAttendance($request->all());
        if($result){
            return redirect()->route('school.attendance')->with('success','class attendance created');
        }
        return redirect()->route('school.attendance')->with('error','failed to create class attendance');
    }

    private function createOrUpdateClassAttendance($data){
        try {
            return ClassAttendance::updateOrCreate(['pid'=>$data['pid'],'school_pid'=>$data['school_pid']],$data);
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
