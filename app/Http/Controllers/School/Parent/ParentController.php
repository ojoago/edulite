<?php

namespace App\Http\Controllers\School\Parent;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Registration\SchoolParent;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = SchoolParent::join('user_details','user_details.user_pid','school_parents.user_pid')
                    ->join('users','users.pid','school_parents.user_pid')
                    ->where(['school_parents.school_pid'=>getSchoolPid()])
                    ->get([
                        'fullname',
                        'gsm','email','username',
                         'address','school_parents.pid',
                        'school_parents.created_at'
                    ]);
        return datatables($data)
                        ->editColumn('date',function($data){
                                return $data->created_at->diffForHumans();
                        })
                        ->editColumn('count',function($data){
                                return StudentController::countParentStudent($data->pid);
                        })
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

    public static function getParentFullname($pid){
        return SchoolParent::join('user_details','user_details.user_pid','school_parents.user_pid')
                            ->where('school_parents.pid',$pid)->pluck('fullname')->first();
    }

}
