<?php

use App\Models\Users\UserDetail;
use Illuminate\Support\Facades\DB;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Term\ActiveTerm;
use App\Models\School\Framework\Session\ActiveSession;
use App\Models\School\Framework\Events\SchoolNotification;
use App\Models\School\Framework\Events\SchoolNotificationStatus;
use App\Models\School\Framework\Subject\Subject;
use App\Models\School\Student\Assessment\Psychomotor\PsychomotorRecord;
use App\Models\School\Student\Assessment\AffectiveDomain\AffectiveDomainRecord;

    function activeSession()
    {
        try {
            return ActiveSession::where('school_pid', getSchoolPid())->orderBy('id', 'DESC')->pluck('session_pid')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function activeTerm(){
        try {
            return ActiveTerm::where('school_pid', getSchoolPid())->orderBy('id', 'DESC')->pluck('term_pid')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function authUsername(){
        try {
            return UserDetail::where('user_pid', getUserPid())->pluck('fullname')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getTitleScore($student,$pid,$param=null,$subject=null){
        try {
            return DB::table('subject_score_params as p')
                ->join('student_score_sheets as s', 'p.pid', 's.score_param_pid')
                ->where([
                    's.student_pid' => $student,
                    's.ca_type_pid' => $pid,
                    'p.subject_pid' => $subject ?? session('subject'),
                    'p.school_pid' => getSchoolPid(),
                    'p.pid' => $param ?? getActionablePid()
                ])->pluck('score')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getTitleAVGScore($student, $pid, $param,$sub){
        // dd($student, $pid, $param, $sub);
        
        try {
            $ca = DB::table('student_score_sheets as s')
            ->join('subject_score_params as p', 's.score_param_pid', 'p.pid')
            ->select(DB::raw("AVG(score) AS score"))
            ->where([
                's.student_pid' => $student,
                's.ca_type_pid' => $pid,
                'p.subject_type' => $sub,
                'p.school_pid' => getSchoolPid(),
                'p.class_param_pid' => $param
            ])
                // ->groupBy('type_pid')
                ->groupBy('p.subject_type')
                ->pluck('score')->first(); //->toArray();
            return $ca;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getSubjectTotalScore($student, $param, $sub){
        // dd($student, $pid, $param, $sub);
        try {
            $ca = DB::table('student_subject_results')
                ->select("total")
                ->where([
                    'student_pid' => $student,
                    'subject_type' => $sub,
                    'school_pid' => getSchoolPid(),
                    'class_param_pid' => $param
                ])->pluck('total')->first();
                return $ca;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return null;
        }
    }

    function getSubjectAVGScore($student, $session,$sub){
        // dd($student, $pid, $param, $sub);
        try {
        $ca = DB::table('student_subject_results as r')
            ->join('student_class_result_params as p', 'r.class_param_pid', 'p.pid')
            ->select(DB::raw("AVG(total) AS score"))
            ->where([
                'r.seated' => 1,
                'r.student_pid' => $student,
                'r.subject_type' => $sub,
                'p.school_pid' => getSchoolPid(),
                'p.session_pid' => $session
            ])->pluck('score')->first();;
            return $ca;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return null;
        }
    }
    function getScoreGrade($total, $param){
        
        try {
       
            return DB::table('grade_key_bases as b')->join('class_arms as a','a.class_pid','b.class_pid')
                                                    ->join('student_class_result_params as p', 'p.arm_pid','a.pid')->where(['p.pid' => $param])
                ->whereRaw('? between min_score and max_score', [$total])
                ->select([ 'grade','color' ,'remark', 'title'])->first();    
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return null;
        }
    }


    function termName($pid){
        $term = Term::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('term')->first();
        return $term;
    }
    function sessionName($pid){
        $session = Session::where(['school_pid'=>getSchoolPid(),'pid'=>$pid])->pluck('session')->first();
        return $session;
    }
function activeSessionName()
{
    $session = DB::table('active_sessions as a')
            ->join('sessions as s','s.pid','a.session_pid')
            ->where('a.school_pid',getSchoolPid())->orderBy('a.id', 'DESC')
            ->pluck('session')->first();
    return $session;
}

function activeTermName()
{
    $term = DB::table('active_terms as a')
            ->join('terms as t','t.pid','a.term_pid')
            ->where('a.school_pid', getSchoolPid())
            ->orderBy('a.id', 'DESC')->pluck('term')->first();
    // $term = ActiveTerm::where('school_pid', getSchoolPid())->orderBy('id', 'DESC')->pluck('term_pid')->first();
    return $term;
}

    function getClassArmNameByPid($pid){
        $arm = ClassArm::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->pluck('arm')->first();
        return $arm;
    }

    function getClassNameByPid($pid){
        try {
            return Classes::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->pluck('class')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            false;
        }
    }
    // psychomoter 

    function getPsychoKeyScore($student,$param,$key){
        try {
            $score = PsychomotorRecord::where([
                'student_pid' => $student,
                'class_param_pid' => $param,
                'key_pid' => $key,
                'school_pid' => getSchoolPid()
            ])->pluck('score')->first();
            // logError($score);
            return $score;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    // psychomoter 

    function getDomainKeyScore($student,$param,$key){
        $score = AffectiveDomainRecord::where([
                            'student_pid'=>$student,
                            'class_param_pid'=>$param,
                            'key_pid'=>$key,
                            'school_pid'=>getSchoolPid()
                        ])->pluck('score')->first();
        return $score;
    }

   

    function loadMyNotificationDetails(){
        switch (getUserActiveRole()) {
            case 610: //rider
            $ntfn = SchoolNotification::where(['school_pid' => getSchoolPid()])->whereIn('type', [3, 4, 5])
                ->get(['message', 'created_at','updated_at', 'type','begin','end']);
                break;
            case 605: //parent
             $ntfn = SchoolNotification::where(['school_pid'=>getSchoolPid()])->whereIn('type', [2, 4, 5])
                ->get(['message', 'created_at','updated_at', 'type','begin','end']);
                break;
            case 600: //student
            $ntfn = SchoolNotification::where(['school_pid' => getSchoolPid()])->whereIn('type', [5, 4, 5])
                ->get(['message', 'created_at','updated_at', 'type','begin','end']);
                break;
            case 200: //School Super Admin
            case 205: //School Admin
            case 300: //Teacher
            case 301: //Form/Class Teacher
            case 303: //Clerk
            case 305: //Secretary
            case 307: //Portals
            case 400: //Office Assisstnace
            case 405: //Security
            case 500: //Principal/Head Teacher
            $ntfn = SchoolNotification::where(['school_pid' => getSchoolPid()])->whereIn('type',[6,4,5])
            ->get(['message', 'created_at', 'updated_at', 'type', 'begin', 'end']);
                break;
            default:
                null;
                break;
        }

    return $ntfn;
    }

    function loadRecentNotification(){
        switch (getUserActiveRole()) {
            case 610: //rider
            return SchoolNotification::where(['school_pid' => getSchoolPid()])->whereIn('type', [2, 4, 5])
                ->whereNotIn('n.pid', function ($query) {
                    $query->select('message_pid')
                        ->from('school_notification_statuses')->where('viewer_pid', getSchoolUserPid());
                })
                ->get(['message', 'created_at', 'type']);
                break;
            case 605: //parent
             return SchoolNotification::where(['school_pid'=>getSchoolPid()])->whereIn('type',[2,4,5])
                ->whereNotIn('n.pid', function ($query) {
                    $query->select('message_pid')
                        ->from('school_notification_statuses')->where('viewer_pid', getSchoolUserPid());
                })
                ->get(['message','created_at', 'type']);
                break;
            case 600: //student
            return DB::table('school_notifications as n')->where(['n.school_pid' => getSchoolPid()])
                            ->whereIn('n.type', [2, 4, 5])
                            ->whereNotIn('n.pid', function ($query) {
                        $query->select('message_pid')
                        ->from('school_notification_statuses');
                        })
                ->get(['message','created_at', 'type']);
                break;
            case 200: //School Super Admin
            case 205: //School Admin
            case 300: //Teacher
            case 301: //Form/Class Teacher
            case 303: //Clerk
            case 305: //Secretary
            case 307: //Portals
            case 400: //Office Assisstnace
            case 405: //Security
            case 500: //Principal/Head Teacher
            return DB::table('school_notifications as n')->where(['school_pid' => getSchoolPid()])
            ->whereIn('type', [1, 5, 4])
                ->whereNotIn('n.pid', function ($query) {
                    $query->select('message_pid')
                        ->from('school_notification_statuses')->where('viewer_pid',getSchoolUserPid());
                })
                ->get(['message', 'created_at','type','n.pid']);
               
            default:
             return   null;
        }

 
    }
    
    function loadAllNotifications(){
        switch (getUserActiveRole()) {
            case 610: //rider
            return SchoolNotification::where(['school_pid' => getSchoolPid()])->whereIn('type', [2, 4, 5])
                ->get(['message', 'created_at', 'type']);
                break;
            case 605: //parent
             return SchoolNotification::where(['school_pid'=>getSchoolPid()])->whereIn('type',[2,4,5])
                ->get(['message','created_at', 'type']);
                break;
            case 600: //student
            return DB::table('school_notifications as n')->where(['n.school_pid' => getSchoolPid()])
                            ->whereIn('n.type', [2, 4, 5])
                           
                ->get(['message','created_at', 'type']);
                break;
            case 200: //School Super Admin
            case 205: //School Admin
            case 300: //Teacher
            case 301: //Form/Class Teacher
            case 303: //Clerk
            case 305: //Secretary
            case 307: //Portals
            case 400: //Office Assisstnace
            case 405: //Security
            case 500: //Principal/Head Teacher
            return DB::table('school_notifications as n')->where(['school_pid' => getSchoolPid()])
            ->whereIn('type', [1, 5, 4])
                
                ->get(['message', 'created_at','type','n.pid']);
               
            default:
             return   null;
        }

 
    }


    function updateViewedNotification(array $data){
        try {
            return SchoolNotificationStatus::insert($data); // use insert or ignore
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


    function countRecentNotification()
    {
        switch (getUserActiveRole()) {
            case 610: //rider
               return SchoolNotification::where(['school_pid' => getSchoolPid()])
                ->whereIn('type', [4,2,5])->whereNotIn('school_notifications.pid', function ($query) {
                    $query->select('message_pid')
                        ->from('school_notification_statuses')->where('viewer_pid', getSchoolUserPid());
                })
                ->count('type');
                
            case 605: //parent
               return SchoolNotification::where(['school_pid' => getSchoolPid()])
                ->whereIn('type', [4,5])->count('type');
                
            case 600: //student
               return SchoolNotification::where(['school_pid' => getSchoolPid()])->whereIn('type', [4, 2, 5])
                ->whereNotIn('school_notifications.pid', function ($query) {
                $query->select('message_pid')
                    ->from('school_notification_statuses')->where('viewer_pid', getSchoolUserPid());
            })
            ->count('type');
               
            case 200: //School Super Admin
            case 205: //School Admin
            case 300: //Teacher
            case 301: //Form/Class Teacher
            case 303: //Clerk
            case 305: //Secretary
            case 307: //Portals
            case 400: //Office Assisstnace
            case 405: //Security
            case 500: //Principal/Head Teacher
               return SchoolNotification::where(['school_pid' => getSchoolPid()])
                ->whereIn('type' , [1,5,4])->whereNotIn('school_notifications.pid', function ($query) {
                    $query->select('message_pid')
                        ->from('school_notification_statuses')->where('viewer_pid', getSchoolUserPid());
                })->count('type');
                
            default:
            $ntfn= null;
                break;
        }

        return $ntfn;
    }

    // load class arm by class pid 
    function loadClassArms($pid){
       $data = ClassArm::where(['school_pid'=>getSchoolPid(),'class_pid'=>$pid])->get(['pid','arm']);
       return $data;
    }
    // load class arm by class pid 
    function loadClassByArm($pid){
       try {
            return ClassArm::where(['school_pid' => getSchoolPid(), 'pid' => $pid])->pluck('class_pid')->first();
       } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
       }
    }

    function getSubjectNameByPid($pid){
        return Subject::where(['pid'=>$pid])->pluck('subject')->first();
    }