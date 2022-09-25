<?php

namespace App\Http\Controllers\School\Framework\Hostel;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Hostel\Hostel;
use App\Models\School\Framework\Hostel\HostelPortal;
use App\Models\School\Framework\Hostel\HostelStudent;
use App\Models\School\Framework\Hostel\StudentHostelHistory;

class HostelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadHostel()
    {
       
        $data = Hostel::join('school_staff', 'school_staff.pid','hostels.staff_pid')
                        ->leftjoin('user_details','user_details.user_pid', 'school_staff.user_pid')
                        ->where('hostels.school_pid',getSchoolPid())
                        ->get(['name','capacity','location','fullname', 'hostels.created_at','hostels.pid']);
        return datatables($data)
                        ->addColumn('action',function($data){
                        return view('school.framework.hostels.hostels-action-button',['data'=>$data]);
                        })
                        ->editColumn('date',function($data){
                            return $data->created_at->diffForHumans();
                        })
                        ->make(true);
    }
    public function loadHostelPortal()
    {
        $data = Hostel::join('hostel_portals','hostel_pid','hostels.pid')
                        ->join('terms', 'terms.pid', 'hostel_portals.term_pid')
                        ->join('sessions', 'sessions.pid', 'hostel_portals.session_pid')
                        ->join('school_staff', 'school_staff.pid', 'hostel_portals.portal_pid')
                        ->join('user_details','user_details.user_pid', 'school_staff.user_pid')
                        ->where('hostels.school_pid',getSchoolPid())
                        ->get(['name','session','term','fullname', 'hostel_portals.updated_at']);
        return datatables($data)
                        ->editColumn('date',function($data){
                            return $data->updated_at->diffForHumans();
                        })
                        ->make(true);
    }
    public function loadHostelStudent(Request $request)
    {
        if(isset($request->session) && isset($request->hostel)){
            $data = DB::table('hostel_students as sh')
                ->join('students as s', 's.pid', 'sh.student_pid')
                ->join('sessions as ss', 'ss.pid', 's.current_session_pid')
                ->join('class_arms as a', 'a.pid', 's.current_class')
                ->leftJoin('user_details as d', 'd.user_pid', 'sh.staff_pid')
                ->join('hostels as h', 'h.pid', 'sh.hostel_pid')
                ->where(['sh.school_pid' => getSchoolPid(),
                         's.current_session_pid' => $request->session, 
                         'h.pid' => $request->hostel])
                ->select('s.fullname', 'd.fullname as creator', 'reg_number', 'h.name', 'session', 'arm', 'sh.updated_at')->get();
        
        }elseif(isset($request->session) || isset($request->hostel)){
            $data = DB::table('hostel_students as sh')
            ->join('students as s', 's.pid', 'sh.student_pid')
            ->join('sessions as ss', 'ss.pid', 's.current_session_pid')
            ->join('class_arms as a', 'a.pid', 's.current_class')
            ->leftJoin('user_details as d', 'd.user_pid', 'sh.staff_pid')
            ->join('hostels as h', 'h.pid', 'sh.hostel_pid')
            ->where(['sh.school_pid'=> getSchoolPid(), 's.current_session_pid'=>$request->session])
            ->orWhere(['sh.school_pid' => getSchoolPid(), 'h.pid' => $request->hostel])
                ->select('s.fullname', 'd.fullname as creator', 'reg_number', 'h.name', 'session', 'arm', 'sh.updated_at')->get();
        }else{
            $data = DB::table('hostel_students as sh')
            ->join('students as s', 's.pid', 'sh.student_pid')
            ->join('sessions as ss', 'ss.pid', 's.current_session_pid')
            ->join('class_arms as a', 'a.pid', 's.current_class')
            ->leftJoin('user_details as d', 'd.user_pid', 'sh.staff_pid')
            ->join('hostels as h', 'h.pid', 'sh.hostel_pid')->where('sh.school_pid', getSchoolPid())
                ->select('s.fullname', 'd.fullname as creator', 'reg_number', 'h.name', 'session', 'arm', 'sh.updated_at')->get();
        }
        
        return datatables($data)
                        ->editColumn('date',function($data){
                            return  date('d F Y ',strtotime($data->updated_at));
                        })
                        ->make(true);
    }

     
    public function createHostel(Request $request)
    {
        $n = $request->name;
            $request->name = strtoupper($request->name);
        $validator = Validator::make($request->all(),[
            'name'=>['required',Rule::unique('hostels')->where(function($param) use ($request){
                    $param->where('school_pid',getSchoolPid())->where('pid','!=',$request->pid);
            })],
            'capacity'=>'required|min:1|int',
            'location'=>'required|string'
        ],['name.required'=>'Enter Hostel Name','name.unique'=> $n.' Already exists']);

        if(!$validator->fails()){
            $data = [
                'name' => $request->name,
                'capacity' => $request->capacity,
                'location' => $request->location,
                'pid' => $request->pid ?? public_id(),
                'school_pid' => getSchoolPid(),
            ];
            $result = $this->updateOrCreateHostel($data);
            if($result){

                return response()->json(['status'=>1,'message'=>'Hostel Created Successfully']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong... Error log']);
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);

    }

    private function updateOrCreateHostel(array $data){
        try {
            $dupParam = $data;
            $data['staff_pid'] = getSchoolUserPid();
            return Hostel::updateOrCreate($dupParam,$data);
        } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
            logError($error);
        }
    }

    public function assignHostelToPortal(Request $request){
        $validator = Validator::make($request->all(),[
            'session_pid' =>'required',
            'term_pid' => 'required',
            'portal_pid' => 'required',
            'hostel_pid' => 'required',
        ],[
            'session_pid.required'=>'Session is Required',
            'term_pid.required'=>'Term is Required',
            'portal_pid.required'=>'Select Portal',
            'hostel_pid.required'=>'Select 1 Hostel, at least',
        ]);
        
        if(!$validator->fails()){
            $data = [
                'session_pid'=>$request->session_pid,
                'term_pid'=>$request->term_pid,
                'portal_pid'=>$request->portal_pid,
                'hostels'=>$request->hostel_pid,
                'school_pid'=>getSchoolPid(),
            ];
            $result  = $this->assignOrReassignHostel($data);
            if($result){
                
                return response()->json(['status'=>1,'message'=>count($request->hostel_pid) .' (s) Assigned to the selected staff Successfully']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong... error log']);
        }
        
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function assignOrReassignHostel(array $data){
        $hostel = $data['hostels'];
        unset($data['hostels']);
        $dupParam = $data;
        $data['staff_pid'] = getSchoolUserPid();
        try {
            foreach($hostel as $pid){
                $dupParam['hostel_pid'] = $data['hostel_pid'] = $pid;
                $result = HostelPortal::updateOrCreate($dupParam,$data);
            }
            return $result;
        } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
            logError($error);
        }
    }
     

    public function assignHostelToStudent(Request $request){
        $validator = Validator::make($request->all(),[
            'student_pid' => 'required',
            'hostel_pid' => 'required',
        ],[
            'hostel_pid.required'=>'Select Hostel',
            'student_pid.required'=>'Select 1 Student, at least',
        ]);
        
        if(!$validator->fails()){
            $data = [
                'hostel_pid'=>$request->hostel_pid,
                'students'=>$request->student_pid,
                'school_pid'=>getSchoolPid(),
            ];
            $result  = $this->assignOrReassignHostelToStudent($data);
            if($result){
                
                return response()->json(['status'=>1,'message'=>count($request->student_pid) .' (s) Assigned Hostel Successfully']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong... error log']);
        }
        
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function assignOrReassignHostelToStudent(array $data){
        $students = $data['students'];
        unset($data['students']);
        $dupParam = $data;
        $data['staff_pid'] = getSchoolUserPid();
        try {
            foreach($students as $pid){
                $dupParam['student_pid'] = $data['student_pid'] = $pid;
                HostelStudent::updateOrCreate($dupParam,$data);
                $result = StudentHostelHistory::create($data);
            }
            return $result;
        } catch (\Throwable $e) {
            $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
            logError($error);
        }
    }
     
}
