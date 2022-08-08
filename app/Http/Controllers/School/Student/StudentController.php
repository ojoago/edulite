<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Parent\ParentController;
use App\Models\School\Registration\SchoolParent;
use App\Models\School\Student\Student;
use App\Models\School\Student\StudentPickUpRider;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
       try {
            $data = Student::join('class_arms', 'class_arms.pid', 'students.current_class')
            ->where(['students.school_pid' => getSchoolPid(), 'students.status' => 1])
            ->get(['arm', 'students.fullname', 'reg_number', 'students.created_at','parent_pid','students.pid']);
            return datatables($data)
                ->addColumn('parent',function($data){
                return ParentController::getParentFullname($data->parent_pid);
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->diffForHumans();
            })->addIndexColumn()
            ->addColumn('action',function($data){
                return view('school.lists.student.student-action-buttons',['data'=>$data]);
            })
            ->make(true);
       } catch (\Throwable $e) {
        $error = $e->getMessage();
        logError($error);
        }
    }

    public function studentProfile($id){

    }
    public function viewStudentProfile(){
        
    }

    public static function createSchoolStudent($data){

        try {
            return Student::create($data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }

    public static function linkParentToStudent(student $studentPid, parent $parentPid){
        $student = Student::where(['pid'=>$studentPid,'school_pid'=>getSchoolPid()])->first();
        $student->parent_pid = $parentPid;
        $student->save();
        //log 
        return $student;
    }

    public static function linkPickUperRiderToStudent(array $data){
        try {
            $dupParams = [
                'student_pid'=>$data['student_pid'],
                'rider_pid'=>$data['student_pid'],
            ];
            return StudentPickUpRider::updateOrCreate($dupParams,$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }


    public static function countParentStudent($parent_pid){
        return SchoolParent::where('pid',$parent_pid)->count('id');
    }
    public static function countRiderStudent($rider_pid){
        return StudentPickUpRider::where('rider_pid', $rider_pid)->count('id');
    }
}
