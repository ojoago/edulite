<?php

namespace App\Http\Controllers\School\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\StaffAttendance;
use App\Models\School\Staff\StaffAttendanceConfig;
use Illuminate\Support\Facades\Validator;

class StaffAttendanceController extends Controller
{
    public function loadStaffAttendanceConfig(){
        try {
            $data = StaffAttendanceConfig::where('school_pid', getSchoolPid())->first();
            return response()->json($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    //
    public function staffAttendance()
    {
        try {
           
            $data = StaffAttendance::from('staff_attendances as a')
                                    ->join('school_staff as s','s.pid','a.staff_pid')
                                    ->join('user_details as d','d.user_pid','s.user_pid')
                                    ->where(['a.school_pid' => getSchoolPid()])->select('a.*', 'd.fullname', 's.staff_id')->get();
            return datatables($data)->addIndexColumn()
            ->addColumn('image', function ($data) {
                return view('school.lists.staff.self-attendance-img', ['data' => $data]);
            })
            ->make(true);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    //
    public function loadMyAttendance()
    {
        try {
            $data = StaffAttendance::where(['school_pid' => getSchoolPid() , 'staff_pid' => getSchoolUserPid()])->get();
            return datatables($data)->addIndexColumn()
            ->addColumn('image', function ($data) {
                return view('school.lists.staff.self-attendance-img', ['data' => $data]);
            })
            ->make(true);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    //
    public function configStaffAttendance(Request $request){

        $validator = Validator::make($request->all(), [
            'clock_in_begin' => 'required|string',
            'clock_in_end' => 'required|string',
            'late_time' => 'required',
            'office_resume_time' => 'required',
            'office_close_time' => 'required',
        ]);
        if (!$validator->fails()) {
            
            $data = [
                'clock_in_begin' => $request->clock_in_begin ,
                'clock_in_end' => $request->clock_in_end ,
                'late_time' => $request->late_time ,
                'office_resume_time' => $request->office_resume_time ,
                'office_close_time' => $request->office_close_time ,
                'latitude' => $request->latitude ,
                'longitude' => $request->longitude ,
                'fence_radius' => $request->fence_radius ,
                'school_pid' => getSchoolPid() ,
                'created_by' => getSchoolUserPid() ,
                'area' => $request->area ,
            ];

            $result = $this->updateLocation($data);
            if($result){
                return response()->json(['status' => 1, 'message' => 'Staff Attendance Configured']);
            }
            return response()->json(['status' => 2, 'message' => 'Failed to configure staff attendance']);
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    public function captureAttendance(Request $request){
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'browser' => 'required',
            'area' => 'required',
            'image' => 'required',
        ]);
        
        if (!$validator->fails()) {
            try {

                $config = StaffAttendanceConfig::where('school_pid', getSchoolPid())->first();

                if($config->clock_in_begin > timeNow()){
                    return response()->json(['status' => 2, 'message' => 'Wait till '. $config->clock_in_begin]);

                }
                if ($config->clock_in_end < timeNow()) {
                    return response()->json(['status' => 2, 'message' => 'Clock in close by ' . $config->clock_in_end]);
                }

                $data = [
                    'cordinates' => ['latitude' => $request->latitude, 'longitude' => $request->longitude, 'accuracy' => null],
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid(),
                    'session_pid' => activeSession(),
                    'term_pid' => activeTerm(),
                    'status'  => 1,
                    // 'platform' => $request->browser,
                    // 'device' => $request->browser,
                    'browser' => $request->browser,
                    'address' => $request->area,
                    'clock_in' => fullDate(),
                    'late' => $config->late > timeNow(),

                ];
                if ($this->attendanceRecord($data)) {
                    return response()->json(['status' => 2, 'message' => 'You already taken Attendance']);
                }


                if (isset($request->image)) {
                    $data['path'] = saveBase64File(file: $request->image,path: 'staff/ttendance/');
                }

                $result = StaffAttendance::create($data);
                if ($result) {
                    return response()->json(['status' => 1, 'message' => 'Attendance Taken']);
                }
                return response()->json(['status' => 2, 'message' => 'Failed to take attendance']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => ER_500]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }


    private function updateLocation($data){
        try {
            return StaffAttendanceConfig::updateOrCreate(['school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    private function attendanceRecord($data){
        try {
            return StaffAttendanceConfig::where(['school_pid' => $data['school_pid'] , 'staff_pid'  => $data['staff_pid'], 'date'  => $data['date']])->exists();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


}
