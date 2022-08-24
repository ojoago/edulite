<?php

namespace App\Http\Controllers\Framework;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\SchoolStaff;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\ClassArmSubject;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Subject\Subject;

class Select2Controller extends Controller
{
    // load list of session on create active session modal dropdown 
    public function loadSchoolSession()
    {
        $result = Session::where(['school_pid' => getSchoolPid()])
            ->limit(10)->orderBy('id', 'DESC')
            ->get(['pid', 'session']);
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->session,
            ];
        }
        return response()->json($data);
    }
    public function loadAvailableCategory($pid=null)
    {
        $result = Category::where(['school_pid' => getSchoolPid()])
            ->orderBy('category')->get(['pid', 'category']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->category,
            ];
        }
        return response()->json($data);
    }
    public function loadAvailableSelectedCategorySubject(Request $request){
        $result = Subject::where(['school_pid' => getSchoolPid(), 'status' => 1, 'category_pid' => $request->pid])
            ->orderBy('subject')->get(['pid', 'subject']); //
        if($result){
            foreach ($result as $row) {
                $data[] = [
                    'id' => $row->pid,
                    'text' => $row->subject,
                ];
            }
            return response()->json($data);
        }
    }
    public function loadAvailableCategoryHead(){
        $result = SchoolStaff::join('user_details', 'user_details.user_pid','school_staff.user_pid')
                            ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status' => 1])
                            ->WhereIn('role_id',[500,505])
            ->orderBy('fullname')->get(['school_staff.pid', 'user_details.fullname']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname,
            ];
        }
        return response()->json($data);
    }

    public function loadAvailableTeacher(){
        $result = SchoolStaff::join('user_details', 'user_details.user_pid','school_staff.user_pid')
                            ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status' => 1])
                            ->WhereNotIn('role_id',[400,405])
            ->orderBy('fullname')->limit(35)->get(['school_staff.pid', 'user_details.fullname','role_id']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname.' - Role - '. matchStaffRole($row->role_id),
            ];
        }
        return response()->json($data);
    }
    // load class 
    // select 2 
    public function loadAvailableClass(Request $request)
    {
 
        $result = Classes::where(['school_pid' => getSchoolPid(), 'status' => 1,'category_pid'=>$request->pid])
                            ->orderBy('class')->get(['pid', 'class']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->class,
            ];
        }
        return response()->json($data);
    }

    public function loadAvailableClassArm(Request $request)
    {
        $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1,'class_pid'=>$request->pid])
        ->orderBy('arm')->get(['pid', 'arm']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->arm,
            ];
        }
        return response()->json($data);
    }
    public function loadAvailableClassArmSubject(Request $request)
    {
        $result = ClassArmSubject::join('class_arms','class_arms.pid','arm_pid')
                                   ->join('subjects','subjects.pid', 'subject_pid')
                                   ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' =>$request->pid])
                                   ->orderBy('arm')->get(['class_arm_subjects.pid', 'arm','subject']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row-> subject . ' - ' . $row->arm,
            ];
        }
        return response()->json($data);
    }
}
