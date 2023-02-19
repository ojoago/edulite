<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\Users\HireAble;
use App\Models\Users\UserDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Framework\Events\SchoolNotificationController;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Hire\SchoolAdvert;
use App\Models\School\Framework\Hire\SchoolJobApplied;


class HireAbleController extends Controller
{

    public function index(){
        $data = DB::table('school_adverts as r')->join('schools as s','s.pid','r.school_pid')
                    ->leftJoin('states as t','t.id','s.state')
                    ->leftJoin('state_lgas as l','l.id','s.lga')
                    ->select('t.state', 'l.lga', 'r.subjects', 'school_name', 'qualification', 'years', 'end_date',
                     'note', 'school_logo', 'school_address', 'course','r.pid')->get();//->dd();
        return view('hiring',compact('data'));
    }

    public function applyJob(Request $request){
       if(!empty(getUserPid()) && getUserPid() !== null){
            try {
                $job = SchoolAdvert::where('pid', $request->pid)->first();
                if ($job->status === 1) {
                    $applied = SchoolJobApplied::where(['job_pid' => $request->pid, 'user_pid' => getUserPid()])->first();
                    if (!$applied) {
                        $result = SchoolJobApplied::create(['job_pid' => $request->pid, 'user_pid' => getUserPid()]);
                        if ($result) {
                            $userData = UserController::getUserDetail(getUserPid());
                            $schoolData = $this->getSchoolDetailsByJobPid($request->pid);
                            $message = 'Your Application for '.$schoolData->title.' has been submitted, the school management will contact you when necessary.';
                            SchoolNotificationController::sendSchoolMail($schoolData,$userData,$message, $schoolData->title.' Application Sent');
                            return response()->json(['status' => 1, 'message' => 'You have successfully Applied']);
                        }
                    }
                    return response()->json(['status'=>2,'message'=>'You already applied for the job']);
                }
            } catch (\Throwable $e) {
                logError($e->getMessage());

                return response()->json(['status'=>2,'message'=>'Something Went Wrong... error logged']);
            }

            return response()->json(['status'=>2,'message'=>'Job is no longer available']);
       }

       return response()->json(['status'=>0,'message'=>'Login First','login'=>1]);
    }

    private function getSchoolDetailsByJobPid($pid){
        try {
            $data = DB::table('school_adverts as r')->join('schools as s', 's.pid', 'r.school_pid')->where(['r.pid' => $pid])
            ->select(
                'r.subjects',
                'school_name',
                'title',
                'school_logo',
                'school_address',
                'school_contact'
            )->first();
            return $data;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
    }

    public function jobDetail($id){
       $session = ['apply'=>true,'job_id'=>$id];
       $this->middleware('auth');
        $data = DB::table('school_adverts as r')->join('schools as s', 's.pid', 'r.school_pid')
        ->leftJoin('states as t', 't.id', 's.state')
        ->leftJoin('state_lgas as l', 'l.id', 's.lga')->where(['r.pid'=>base64Decode($id)])
            ->select(
                't.state',
                'l.lga',
                'r.subjects',
                'school_name',
                'qualification',
                'years',
                'end_date',
                'note',
                'school_logo',
                'school_address',
                'course',
                'r.pid'
            )->first();
        return view('', compact('data'));
    }
    public function hireMeConfig(Request $request){

        if(!$this->confirmDetail()){
            return response(['status' => 'error', 'message' => 'Update your user details first!!!']);
        }
        $validator = Validator::make($request->all(),[
            'about'=>'required|string|max:250',
            'qualification'=>'required|string|max:100',
            'course'=>'nullable|max:64',
            'years'=>'int|nullable',
            'status'=>'int|required',
            'state'=>'required',
            'lga'=>'nullable|string'
        ]);

        if(!$validator->fails()){
            $data = [
                'qualification' => $request->qualification,
                'course' => $request->course,
                'years' => $request->years,
                'status' => $request->status,
                'state' => $request->state,
                'lga' => $request->lga,
                'area' => $request->area,
                'years' => $request->years,
                // 'subjects' => json_encode($request->subject),
                'user_pid' => getUserPid(),
            ];
            if(isset($request->about)){
                $this->updateAbout($request->about);
            }
            $data['subjects'] = $this->getSubjectName($request->subject);
            $result = $this->updateOrCreateHireMeDetail($data);
            if($result){
                return response(['status'=>1,'message'=>'Details Updated']);
            }
            return response(['status'=>'error','message'=>'Something Went Wrong...']);
        }
        return response(['status'=>0,'message'=>'Fill the form Correctly','error'=>$validator->errors()->toArray()]);
    }
    
    private function updateOrCreateHireMeDetail(array $data){
        try{
          return HireAble::updateOrCreate(['user_pid'=>getUserPid()],$data);
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }

    }

    private function updateAbout(string $about){
        try{
            $dtl = UserDetail::where(['user_pid' => getUserPid()])->update(['about'=>$about]);
            return $dtl;
        }catch(\Throwable $e){
            logError($e->getMessage());
            return false;
        }
    }

    private function confirmDetail(){
        try {
            return UserDetail::where(['user_pid' => getUserPid()])->first(['id']);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


    public function loadHireMeConfig(){
        try {
            $data = DB::table('user_details as d')->leftJoin('hire_ables as h', 'd.user_pid', 'h.user_pid')
                ->where('d.user_pid', getUserPid())->select('h.*', 'd.about')->first();
            return $data;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
    }

    // school recruitment 
    public function submitAdvert(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'qualification' => 'required|string|max:100',
            'course' => 'nullable|max:64',
            'years' => 'int|nullable',
            'status' => 'int|required',
            'note' => 'nullable|string'
        ],['qualification.required'=>'Enter Job minimum Qualification','title.required'=>'Enter Job Title']);

        if(!$validator->fails()){
            $data = [
                'qualification' => $request->qualification,
                'title' => $request->title,
                'course' => $request->course,
                'years' => $request->years,
                'status' => $request->status,
                'note' => $request->note,
                'pid' => $request->pid ?? public_id(),
                'school_pid' => getSchoolPid()
            ];
            $data['subjects'] = $this->getSubjectName($request->subject);
            $result = $this->updateOrCreateSchoolRecruitment($data);
            if($result){
                return response(['status' => 1, 'message' => 'Submitted Successful']);
            }
            return response(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
        return response(['status' => 0, 'message' => 'Fill the form Correctly', 'error' => $validator->errors()->toArray()]);

    }

    public function loadAdvertConfig(){
        $data = SchoolAdvert::where(['school_pid' => getSchoolPid()])->get();
        return datatables($data)
            ->editColumn('years', function ($data) {
                return $data->years ? $data->years . ' year (s)' : '';
            })
            ->addIndexColumn()
            ->make(true);
    }
    public function loadJobApplicant(Request $request){
        $data = DB::table('school_adverts as sa')->join('school_job_applieds as ja','ja.job_pid','sa.pid')
                                                ->join('user_details as d','d.user_pid','ja.user_pid')
                                                ->leftJoin('hire_ables as h','h.user_pid','d.user_pid')->where(['sa.school_pid'=>getSchoolPid()])->select('h.qualification','sa.title','d.fullname')->get();
        return datatables($data)
            // ->editColumn('years', function ($data) {
            //     return $data->years . ' year (s)';
            // })
            ->addIndexColumn()
            ->make(true);
    }
    private function updateOrCreateSchoolRecruitment(array $data){
        try {
            return SchoolAdvert::updateOrCreate(['pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    // load avaible hire for school 
    public function loadPotentialApplicantHireConfig(Request $request){
        $data = DB::table('user_details as d')->join('users as u','u.pid','d.user_pid')
                    ->join('hire_ables as h', 'd.user_pid', 'h.user_pid')
                    ->leftJoin('states as s','s.id','d.state')->leftJoin('state_lgas as lg','lg.id','d.lga')
        ->where('h.status',1)
        ->select('qualification', 'course', 'd.about', 'years','status','subjects','d.fullname','u.gsm')->get();
        return datatables($data)
        ->editColumn('years', function ($data) {
            return $data->years . ' year (s)';
        })
        ->addIndexColumn()
            ->make(true);
    }

    private function getSubjectName(array|null $data){
        $sbj = '';
        if($data ==null){
            return '';
        }
        foreach ($data as $row) {
           $sbj.= getSubjectNameByPid($row) .', ';
        }
        return removeThis(trim($sbj));
    }

}
