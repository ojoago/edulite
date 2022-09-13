<?php

namespace App\Http\Controllers\School\Parent;

use App\Http\Controllers\Controller;
use App\Models\School\Registration\SchoolParent;
use App\Models\School\Student\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = DB::table('school_parents as p')
                    ->join('user_details as d','p.user_pid','d.user_pid')
                    ->join('users as u','u.pid','p.user_pid')
                    ->leftJoin('students as s','s.parent_pid','p.pid')
                    ->where('p.school_pid',getSchoolPid())
                    ->select(DB::raw('COUNT(s.parent_pid) AS count,d.fullname,gsm,p.pid,email,d.address,username,p.created_at,p.status'))
                    ->groupBy('p.pid')->get();
                     return datatables($data)
                        ->editColumn('date',function($data){
                                return date('d F Y',strtotime($data->created_at));
                        })
                        // ->editColumn('status',function($data){
                        //         return $data->status==1 ? '<span class="text-success">Enabled</span>' : '<span class="text-success">Disabled</span>';
                        // })
                        ->addColumn('action',function($data){
                                return view('school.lists.parent.parent-action-buttons',['data'=>$data]);
                        })
                        ->addIndexColumn()->make(true);
    }


    public static function createSchoolParent($data){
        $dupParams = [
            'school_pid'=>$data['school_pid'],
            'pid'=>$data['pid'],
        ];
        try {
            return SchoolParent::updateOrCreate($dupParams,$data);
        } catch (\Throwable $e) {
           $error = $e->getMessage();
           logError($error);
        }
    }
    public static function parentProfile ($id){
        $data = DB::table('school_parents as p')->join('users as u','u.pid','p.user_pid')
                        ->join('user_details as d','d.user_pid','p.user_pid')
                        ->leftJoin('students as s','s.parent_pid','p.pid')->where('p.pid',base64Decode($id))
                        ->select(DB::raw('COUNT(s.parent_pid) AS count,d.fullname,d.address,d.dob,gsm,username,email,d.gender,d.religion,d.title,d.state,d.lga,p.passport,account_status as status,p.pid'))->groupBy('p.pid')->first();
        return view('school.lists.parent.parent-profile', compact('data'));
    }

    public function myWards($id){
        $data = DB::table("students as s")->join("class_arms as a",'a.pid', 's.current_class')
                ->join('sessions as e','e.pid', 's.current_session_pid')
                ->join('users as u','u.pid','s.user_pid')
                ->join('user_details as d','d.user_pid','s.user_pid')
                ->where(['s.school_pid'=>getSchoolPid(),'parent_pid'=>base64Decode($id)])->orderByDesc('s.id')
                ->get(['reg_number', 's.fullname', 'type', 's.status','passport', 's.religion','session','arm','username','gsm','gender','dob', 'parent_pid']);
        return view('school.lists.parent.wards.wards',compact('data'));
    }

    public static function getParentFullname($pid){
        return SchoolParent::join('user_details','user_details.user_pid','school_parents.user_pid')
                            ->where('school_parents.pid',$pid)->pluck('fullname')->first();
    }

    public function toggleParentStatus(Request $request){
        if($request->pid)
            return self::updateParentStatus(base64Decode($request->pid));
        else 
        return 'Wrong Parameter sent';
    }

    public static function updateParentStatus($pid){
        $parent = SchoolParent::where('pid',$pid)->first(['id','status']);
        $parent->status = $parent->status == 1 ? 0 : 1;
        $parent->save();
        return 'Status updated';
    }
}
