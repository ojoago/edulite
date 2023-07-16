<?php

namespace App\Http\Controllers\School\Framework\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Parent\ParentController;
use App\Http\Controllers\School\Rider\SchoolRiderController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Student\StudentController;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Events\SchoolNotification;

class SchoolNotificationController extends Controller
{

    public function loadMyNotificationHistories(){
        $data = DB::table('school_notifications as n')->leftJoin('school_users as u', 'n.notifyee','u.pid')
                                                        ->leftJoin('user_details as d','d.user_pid','u.user_pid')
                                                        ->select('message', 'begin','end', 'fullname', 'title', 'type', 'notifyee')
                                                        ->where(['n.school_pid' => getSchoolPid(), 'n.session_pid'=>activeSession(),'n.term_pid'=>activeTerm()])
                                                        ->orderByDesc('n.id')->get();
        return datatables($data)
            ->addIndexColumn()
            ->editColumn('message', function ($data) {
                if(matchPid($data->notifyee)){
                    $msg = str_replace(['{you}'], 'YOU:',$data->message);
                    $msg = str_replace(['{your}'], 'Your ',$msg);
                }else{
                    $msg = str_replace(['{you}','{your}'], $data->fullname.':',$data->message);
                }
                return str_replace('<br>',', ', $msg);
            })
            ->editColumn('type', function ($data) {
                
                return NOTIFICATION_TYPE[(int)$data->type];
            })
            ->make(true);
    }
    public function countMyNotificationTip(){
       return countRecentNotification();
    }
    
    public function loadMyNotificationTip(){
        $ntfn = loadRecentNotification();
        return $ntfn ? formatNotification($ntfn) : 0;

    }
    public function loadMyNotificationDetails(){
        $ntfn = loadMyNotificationDetails();
        // return $ntfn ? formatNotification($ntfn) : 0;

        // return formatNotification($ntfn);

    }
    public function myNotification(){
        $notification = loadRecentNotification();
        return view('school.my-notification',compact('notification'));
    }

    public function createSchoolNotification(Request $request){

        $validator = Validator::make($request->all(),[
            'begin'=>'',
            'end'=>'',
            'message'=>'required|string',
            'type'=> 'required|int',
            'begin'=> 'required_with:end',
        ],['message.required'=>'Please Enter Notification Message', 'begin.required_with'=>'Event Begin Is required']);

        if(!$validator->fails()){
            $data = [
                'begin'=>$request->begin,
                'end'=>$request->end,
                'message'=>$request->message,
                'type'=>$request->type,
                'school_pid'=>getSchoolPid(),
                'term_pid'=>activeTerm(),
                'session_pid'=>activeSession(),
                'pid'=>public_id(),
            ];
            $sts = $this->createOrUpdateNotification($data);
            if($sts){
                if($data['type']==1){
                    return response()->json(['status'=>1,'message'=>'Notification Created']);
                }
                $ps = $this->pushNotification($data);
                if($ps){
                    return response()->json(['status'=>1,'message'=>'Notification Created and scheduled']);
                }

            }
            return response()->json(['status'=>'error','message'=>'Failed to Create Notification']);
        }
        
        return response()->json(['status'=>0,'message'=>'','error'=>$validator->errors()->toArray()]);
    }

    public function createSchoolNotifyParent(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ], ['message.required' => 'Please Enter Notification Message']);

        if (!$validator->fails()) {
            $data = [
                'message' => $request->message== 'Student Timetable is ready' ? 'Student Timetable for '. activeTermName().' '.activeSessionName().' is ready' : $request->message,
                'type' => 2,
                'school_pid' => getSchoolPid(),
                'term_pid' => activeTerm(),
                'session_pid' => activeSession(),
                'pid' => public_id(),
            ];
            $sts = $this->createOrUpdateNotification($data);
            if ($sts) {
                if ($data['type'] == 1) {
                    return response()->json(['status' => 1, 'message' => 'Notification Created']);
                }
                $ps = $this->pushNotification($data);
                if ($ps) {
                    return response()->json(['status' => 1, 'message' => 'Notification Created and scheduled']);
                }
            }
            return response()->json(['status' => 'error', 'message' => 'Failed to Create Notification']);
        }

        return response()->json(['status' => 0, 'message' => '', 'error' => $validator->errors()->toArray()]);
    }

    public static function notifyIndividualStaff(string $message,string $pid){
        $data = [
            'message'=>$message,
            'notifyee'=> $pid,
            'user'=>StaffController::getStaffDetailBypId(pid:$pid),
        ];
        return (new self)->individualNotification($data);
    }
    public static function notifyIndividualParent(string $message,string $pid){
        $data = [
            'message'=>$message,
            'notifyee'=> $pid,
            'user'=>ParentController::getParentDetailBypId(pid:$pid),
        ];
        return (new self)->individualNotification($data);
    }
    public static function notifyIndividualRider(string $message,string $pid){
        $data = [
            'message'=>$message,
            'notifyee'=> $pid,
            'user'=>SchoolRiderController::getRiderDetailBypId(pid:$pid),
        ];
        return  (new self)->individualNotification($data);
    }
    public static function notifyIndividualStudent(string $message,string $pid){
        $data = [
            'message'=>$message,
            'notifyee'=> $pid,
            'user'=>StudentController::getStudentDetailBypId(pid:$pid),
        ];
        return (new self)->individualNotification($data);
    }
    private function individualNotification(array $param){
        $data = [
            'message' => $param['message'],
            'notifyee' => $param['notifyee'],
            'type' => 0,
            'school_pid' => getSchoolPid(),
            'term_pid' => activeTerm(),
            'session_pid' => activeSession(),
            'pid' => public_id(),
        ];
        $sts = $this->createOrUpdateNotification($data);
        if($sts){
            /* 
                $user contains 
                gsm
                title
                email
                fullname 
            */
            if($param['user']->email){
                // send mail 
                $schoolData = SchoolController::loadSchoolNotificationDetail(getSchoolPid());
                self::sendSchoolMail($schoolData,$param['user'], str_replace('{you}','You',$param['message']));
            }
            return true;
        }
        return false;
    }

    private function createOrUpdateNotification(array $data){
        return SchoolNotification::updateOrCreate(['pid'=>$data['pid']],$data);
    }
    private function pushNotification($data)
    {
        $list = $this->loadUser($data);
        if($list){
            // schedule mail 
            return true;
        }
        return ;

    }
    private function loadUser($data)
    {
        switch ($data['type']) {
            case 2: //send message to all active parents
                $list = $this->loadActiveParents();
                break;
            case 3: // send message to school rider or student care
                $list = $this->loadActiveRider();
                break;
            case 4: // send general message
                $parents = $this->loadActiveParents();
                $riders = $this->loadActiveRider();
                $students = $this->loadActiveStudent(); 
                $staff = $this->loadActiveStaff(); 
                $list = [];
                array_push($list, $parents);
                array_push($list, $riders);
                array_push($list, $staff);
                array_push($list, $students);
                break;
            case 5: // send message to student only
                $list = $this->loadActiveStudent();
                break;
            case 6: // send message to all staff 
                $list = $this->loadActiveStaff();
                break;
            default:
                return $list = [];
        }
        return $list;
    }
    
    // load parent that has chield or ward in school  
    private function loadActiveParents(){
        $parents = DB::table('school_parents as p')
        ->join('users as u', 'p.user_pid', 'u.pid')
        ->join('user_details as d', 'd.user_pid', 'u.pid')
        ->join('students as s', 's.parent_pid', 'p.pid')
            ->where(['p.school_pid' => getSchoolPid(), 's.status' => 1])->where('email','<>',null)->distinct('p.pid')->get(['d.fullname','email','d.gender']);

        return $parents;
    }

    private function loadActiveStudent(){
        $students = DB::table('students as s')
        ->join('users as u', 's.user_pid', 'u.pid')
            ->where(['s.school_pid' => getSchoolPid(), 's.status' => 1])->where('email', '<>', null)->get(['fullname','email', 'gender']);

        return $students;
    }
    // load child rider  
    private function loadActiveRider(){
        $riders = DB::table('school_riders as r')
            ->join('users as u', 'r.user_pid', 'u.pid')
            ->join('user_details as d', 'd.user_pid', 'u.pid')
            ->where(['r.school_pid' => getSchoolPid(), 'r.status' => 1])->where('email', '<>', null)->get(['fullname','email', 'gender']);

        return $riders;
    }
    // load school active staff  
    private function loadActiveStaff(){
        $staff = DB::table('school_staff as t')
            ->join('users as u', 't.user_pid', 'u.pid')
            ->join('user_details as d', 'd.user_pid', 'u.pid')
            ->where(['t.school_pid' => getSchoolPid(), 't.status' => 1])->where('email', '<>', null)->get(['fullname','email', 'gender']);

        return $staff;
    }

    public static function sendSchoolMail($schoolData,$userData,$message,$subject='Notification'){
        try {
            $data = [
                'email' => $userData->email,
                'name' => matchGenderTitle($userData->gender) . ' ' . $userData->fullname,
                'blade' => 'school-mail',
                'message' => $message,
                // 'url' => 'verify/' . base64Encode($user->pid),
                'subject' => $subject,
                'school' => $schoolData,
            ];
            return sendMail($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
}
