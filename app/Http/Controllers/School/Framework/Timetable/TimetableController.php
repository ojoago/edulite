<?php

namespace App\Http\Controllers\School\Framework\Timetable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Timetable\Timetable;
use App\Models\School\Framework\Timetable\TimetableParam;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
       if(isset($request->arm_pid) && isset($request->session_pid) && isset($request->term_pid)){
            $data = DB::table("timetable_params as p")
                ->join('timetables as tt', 'p.pid', 'tt.param_pid')
                ->join('class_arm_subjects as cas', 'cas.pid', 'tt.subject_pid')
                ->join('subjects as s', 's.pid', 'cas.subject_pid')
                ->join('class_arms as a', 'a.pid', 'p.arm_pid')
                ->where(['p.arm_pid'=>$request->arm_pid,
                        'p.session_pid'=>$request->session_pid,
                        'p.term_pid'=>$request->term_pid,
                        'p.school_pid' => getSchoolPid()
                    ])
                ->select('arm', 'subject', 'exam_date', 'exam_time', 'tt.updated_at')->orderBy('arm')->get();
       }
       if(isset($request->arm_pid) && isset($request->session_pid)){
            $data = DB::table("timetable_params as p")
                ->join('timetables as tt', 'p.pid', 'tt.param_pid')
                ->join('class_arm_subjects as cas', 'cas.pid', 'tt.subject_pid')
                ->join('subjects as s', 's.pid', 'cas.subject_pid')
                ->join('class_arms as a', 'a.pid', 'p.arm_pid')
                ->where([
                    'p.arm_pid' => $request->arm_pid,
                    'p.session_pid' => $request->session_pid,
                // 'term_pid' => $request->term_pid
                'p.school_pid' => getSchoolPid()
                ])
                ->select('arm', 'subject', 'exam_date', 'exam_time', 'tt.updated_at')->orderBy('arm')->get();
       }
       if(isset($request->session_pid) && isset($request->term_pid)){
            $data = DB::table("timetable_params as p")
            ->join('timetables as tt', 'p.pid', 'tt.param_pid')
            ->join('class_arm_subjects as cas', 'cas.pid', 'tt.subject_pid')
            ->join('subjects as s', 's.pid', 'cas.subject_pid')
            ->join('class_arms as a', 'a.pid', 'p.arm_pid')
            ->where([
                // 'arm_pid' => $request->arm_pid,
                'p.session_pid' => $request->session_pid,
                'p.term_pid' => $request->term_pid,
                'p.school_pid' => getSchoolPid()
            ])
                ->select('arm', 'subject', 'exam_date', 'exam_time', 'tt.updated_at')->orderBy('arm')->get();
       }
       if(isset($request->arm_pid)){
            $data = DB::table("timetable_params as p")
            ->join('timetables as tt', 'p.pid', 'tt.param_pid')
            ->join('class_arm_subjects as cas', 'cas.pid', 'tt.subject_pid')
            ->join('subjects as s', 's.pid', 'cas.subject_pid')
            ->join('class_arms as a', 'a.pid', 'p.arm_pid')
            ->where([
                'p.arm_pid' => $request->arm_pid,
                'p.session_pid' => activeSession(),
                'p.term_pid' => activeTerm(),
                'p.school_pid' => getSchoolPid()
            ])
                ->select('arm', 'subject', 'exam_date', 'exam_time', 'tt.updated_at')->orderBy('arm')->get();
       }
       else{
            $data = DB::table("timetable_params as p")
                ->join('timetables as tt', 'p.pid', 'tt.param_pid')
                ->join('class_arm_subjects as cas', 'cas.pid', 'tt.subject_pid')
                ->join('subjects as s', 's.pid', 'cas.subject_pid')
                ->join('class_arms as a', 'a.pid', 'p.arm_pid')
                ->where([
                    // 'arm_pid' => $request->arm_pid,
                    'p.session_pid' => activeSession(),
                    'p.term_pid' => activeTerm(),
                    'p.school_pid'=>getSchoolPid()
                ])
                ->select('arm', 'subject', 'exam_date', 'exam_time', 'tt.updated_at')->orderBy('arm')->get();
       }
        return datatables($data)
                    ->editColumn('date',function($data){
                        return date('d M Y',strtotime($data->updated_at));
                    })
                    ->editColumn('exam_time',function($data){
                        return date('h:i A',strtotime($data->exam_time));
                    })
                    ->addIndexColumn()
                    ->make(true);
    }

    public function createClassTimetable(Request $request){
        $validator = Validator::make($request->all(),[
            'category_pid'=>'required',
            'class_pid'=> 'required',
            'arm_pid'=> 'required',
            // 'arm_pid.*'=> 'required|array|min:1',
            'subject'=>'array|min:1',
            'subject.*'=>'required',
            'date.*'=>'required|min:1',
            'time.*'=>'required|min:1',
        ],[
            'category_pid.required'=>'Category is required',
            'class_pid.required'=>'Class is required',
            'arm_pid.required'=>'Class Arm is required',
            'date.*.required'=>'Choose this date or remove it',
            'time.*.required'=> 'Choose this time or remove it',
        ]);

        if(!$validator->fails()){
            $params = [
                'term_pid'=>activeTerm(),
                'school_pid'=>getSchoolPid(),
                'session_pid'=>activeSession()
            ];
            $data = [
                'arms'=>$request->arm_pid,
                'subjects'=>$request->subject,
                'dates'=>$request->date,
                'times'=>$request->time,
            ];
            $timetable=['school_pid'=>getSchoolPid()];
            $len = count($data['times']);
            foreach($data['arms'] as $arm){
                $params['arm_pid'] = $arm;
                $pid = $this->createOrUpdateTimeTableParam($params);
                for ($i=0; $i < $len; $i++) {
                    $timetable['param_pid'] = $pid;
                    $timetable['exam_date'] = $data['dates'][$i];
                    $timetable['exam_time'] = $data['times'][$i];
                    $timetable['subject_pid'] = $data['subjects'][$i];
                    $result = $this->createOrUpdateTimeTable($timetable);
                }
            }
            if($result){

                return response()->json(['status'=>1,'message'=>'Timetable created for the selected arm(s) for '.activeTermName().' '.activeSessionName().' Exams']);
            }
            return response()->json(['status'=>'error','message'=>'Something Went Wrong']);
        }

        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function createOrUpdateTimeTableParam(array $data){
        try {
            $pid = TimetableParam::where($data)->pluck('pid')->first();
            if ($pid) {
                return $pid;
            }
            $data['pid'] = public_id();
            $result = TimetableParam::create($data);
            if ($result) {
               return $result->pid; 
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }
    private function createOrUpdateTimeTable(array $data){
        $dupParam = ['subject_pid' => $data['subject_pid'], 'param_pid' => $data['param_pid']];
        return Timetable::updateOrCreate($dupParam, $data);
    }
}
