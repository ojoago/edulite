<?php

namespace App\Http\Controllers\Framework;

use Illuminate\Http\Request;
use App\Models\School\System\State;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\System\StateLga;
use App\Models\School\Staff\SchoolStaff;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Subject\Subject;
use App\Models\School\Registration\SchoolParent;
use App\Models\School\Framework\Subject\SubjectType;
use App\Models\School\Framework\Class\ClassArmSubject;
use App\Models\School\Framework\Hostel\Hostel;
use App\Models\School\Rider\SchoolRider;

class Select2Controller extends Controller
{
    // load list of session on create active session modal dropdown 
    public function loadSchoolSession(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = Session::where(['school_pid' => getSchoolPid()])
            ->where('session','like','%'.$request->q.'%')
            ->limit($request->page_limit)->orderBy('id', 'DESC')->get(['pid', 'session']);
        else
        $result = Session::where(['school_pid' => getSchoolPid()])
            ->limit(10)->orderBy('id', 'DESC')->get(['pid', 'session']);
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->session,
            ];
        }
        return response()->json($data);
    }
    public function loadAvailableCategory(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = Category::where(['school_pid' => getSchoolPid()])
            ->where('category', 'like', '%' . $request->q . '%')
            ->limit($request->page_limit)
            ->orderBy('category')->get(['pid', 'category']); //
        else
        $result = Category::where(['school_pid' => getSchoolPid()])
            ->orderBy('category')->get(['pid', 'category']); //
        if(!$result){
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->category,
            ];
        }
        return response()->json($data);
    }
    public function loadAvailableSelectedCategorySubject(Request $request){
        $data = null;
        if ($request->has('q'))
        $result = Subject::where(['school_pid' => getSchoolPid(), 'status' => 1, 'category_pid' => $request->pid])
            ->where('subject', 'like', '%' . $request->q . '%')
            ->limit($request->page_limit)
            ->orderBy('subject')->get(['pid', 'subject']); //
        else
        $result = Subject::where(['school_pid' => getSchoolPid(), 'status' => 1, 'category_pid' => $request->pid])
            ->limit(10)->orderBy('subject')->get(['pid', 'subject']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
            foreach ($result as $row) {
                $data[] = [
                    'id' => $row->pid,
                    'text' => $row->subject,
                ];
            return response()->json($data);
        }
    }
    public function loadAvailableCategoryHead(){
        $data = null;
        $result = SchoolStaff::join('user_details', 'user_details.user_pid','school_staff.user_pid')
                            ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status' => 1])
                            ->WhereIn('role',[500,505])
            ->orderBy('fullname')->get(['school_staff.pid', 'user_details.fullname']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname,
            ];
        }
        return response()->json($data);
    }

    public function loadAvailableTeacher(Request $request){
        $data = null;
        if ($request->has('q'))
        $result = SchoolStaff::join('user_details', 'user_details.user_pid','school_staff.user_pid')
                            ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status' => 1])
                            ->where('user_details.fullname', 'like', '%' . $request->q . '%')
                            // ->limit($request->page_limit)
                            ->WhereNotIn('role',[400,405])
            ->orderBy('school_staff.id', 'DESC')->limit(5)->get(['school_staff.pid', 'user_details.fullname','role']); //
        else
        $result = SchoolStaff::join('user_details', 'user_details.user_pid','school_staff.user_pid')
                            ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status' => 1])
                            ->WhereNotIn('role',[400,405])
            ->orderBy('school_staff.id', 'DESC')->limit(10)->get(['school_staff.pid', 'user_details.fullname','role']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname.' - Role - '. matchStaffRole($row->role),
            ];
        }
        return response()->json($data);
    }
    
    // load school student 
    public function loadStudents(Request $request){
        $data = null;
        if ($request->has('q'))
        $result = Student::where([['school_pid',getSchoolPid()],
                                    ['status', 1],
                                    ['fullname', 'like', '%' . $request->q . '%']
                                    ])
                                ->orwhere([
                                    ['school_pid', getSchoolPid()],
                                    ['status', 1],
                                    ['reg_number', 'like', '%' . $request->q . '%']])
                                    ->limit($request->page_limit)
            ->orderBy('id', 'DESC')->get(['pid', 'fullname', 'reg_number']); //
        else
        $result = Student::where('school_pid',getSchoolPid())
                            ->limit(10)
                            ->orderBy('id', 'DESC')->get(['pid', 'fullname','reg_number']);
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname.' - '. $row->reg_number,
            ];
        }
        return response()->json($data);
    }
    // load boarding student 
    public function loadBoardingStudents(Request $request){
        $data = null;
        if ($request->has('q'))
        $result = Student::where([['school_pid',getSchoolPid()],
                                    ['status', 1],
                                    ['type', 2],
                                    ['fullname', 'like', '%' . $request->q . '%']
                                    ])
                                ->orwhere([
                                    ['school_pid', getSchoolPid()],
                                    ['status', 1],
                                    ['type', 2],
                                    ['reg_number', 'like', '%' . $request->q . '%']])
                                    ->limit($request->page_limit)
            ->orderBy('id', 'DESC')->get(['pid', 'fullname', 'reg_number']); //
        else
        $result = Student::where(['school_pid'=>getSchoolPid(),'status'=>1,'type'=>2])
                            ->limit(10)
                            ->orderBy('id', 'DESC')->get(['pid', 'fullname','reg_number']);
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname.' - '. $row->reg_number,
            ];
        }
        return response()->json($data);
    }
    // load class arm student 
    public function loadClassArmStudents(Request $request){
        $data = null;
        if ($request->has('q'))
        $result = Student::where([['school_pid',getSchoolPid()],
                                    ['status', 1],
                                    ['fullname', 'like', '%' . $request->q . '%'],
                                    ['current_class',$request->pid]
                                    ])
                                ->orwhere([
                                    ['school_pid', getSchoolPid()],
                                    ['status', 1],
                                    ['current_class',$request->pid]])
                                    ->limit($request->page_limit)
            ->orderBy('id', 'DESC')->get(['pid', 'fullname', 'reg_number']); //
        else
        $result = Student::where('school_pid',getSchoolPid())
                            ->limit(10)
                            ->orderBy('id', 'DESC')->get(['pid', 'fullname','reg_number']);
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname.' - '. $row->reg_number,
            ];
        }
        return response()->json($data);
    }
    // load class 
    // load parents 
    public function loadSchoolParent(Request $request){
        $data = null;
        if ($request->has('q'))
        $result = SchoolParent::join('user_details', 'user_details.user_pid', 'school_parents.user_pid')
                            ->join('users', 'users.pid', 'user_details.user_pid')
                            ->where([
                                ['school_parents.school_pid',getSchoolPid()],
                                ['school_parents.status', 1],
                                ['user_details.fullname', 'like', '%' . $request->q . '%']
                                ])

                            ->limit($request->page_limit)
            ->orderBy('school_parents.id','DESC')->get(['school_parents.pid', 'user_details.fullname','users.gsm']); //
        else
        $result = SchoolParent::join('user_details', 'user_details.user_pid', 'school_parents.user_pid')
                            ->join('users','users.pid', 'user_details.user_pid')
                            ->where([
                                ['school_parents.school_pid',getSchoolPid()],
                                ['school_parents.status', 1]])
                            ->limit(5)
                            ->orderBy('school_parents.id', 'DESC')->get(['school_parents.pid', 'user_details.fullname','users.gsm']);
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname.' - '. $row->gsm,
            ];
        }
        return response()->json($data);
    }
    // load parents 
    public function loadSchoolRider(Request $request){
        $data = null;
        if ($request->has('q')){
            $param = [
                ['school_riders.school_pid', getSchoolPid()],
                ['school_riders.status', 1],
                ['user_details.fullname', 'like', '%' . $request->q . '%']
            ];
            $limit = $request->page_limit;
        }
        else{
            $param = [
                ['school_riders.school_pid', getSchoolPid()],
                ['school_riders.status', 1]
            ];
            $limit = 5;
        }
            
        $result = SchoolRider::join('user_details', 'user_details.user_pid', 'school_riders.user_pid')
                            ->join('users','users.pid', 'user_details.user_pid')
                            ->where($param)
                            ->limit($limit)
                            ->orderBy('school_riders.id', 'DESC')
                            ->get(['school_riders.pid', 'user_details.fullname','users.gsm']);
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname.' - '. $row->gsm,
            ];
        }
        return response()->json($data);
    }

    public function loadAvailablePortals(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = SchoolStaff::join('user_details', 'user_details.user_pid', 'school_staff.user_pid')
        ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status' => 1])
        ->where('user_details.fullname', 'like', '%' . $request->q . '%')
            // ->limit($request->page_limit)
            ->Where('role',307)
            ->orderBy('school_staff.id', 'DESC')->limit(5)->get(['school_staff.pid', 'user_details.fullname', 'role']); //
        else
        $result = SchoolStaff::join('user_details', 'user_details.user_pid', 'school_staff.user_pid')
        ->where(['school_staff.school_pid' => getSchoolPid(), 'school_staff.status' => 1])
        ->Where('role', 307)
            ->orderBy('school_staff.id', 'DESC')->limit(10)->get(['school_staff.pid', 'user_details.fullname', 'role']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fullname . ' - Role - ' . matchStaffRole($row->role),
            ];
        }
        return response()->json($data);
    }
    // load class 
    // select 2 
    public function loadAvailableClass(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = Classes::where(['school_pid' => getSchoolPid(), 'status' => 1,'category_pid'=>$request->pid])
            ->where('class', 'like', '%' . $request->q . '%')
            ->limit(5)->orderBy('class')->get(['pid', 'class']); //
        else
        $result = Classes::where(['school_pid' => getSchoolPid(), 'status' => 1,'category_pid'=>$request->pid])
                            ->limit(5)->orderBy('class')->get(['pid', 'class']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
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
        $data = null;
        if ($request->has('q'))
        $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1,'class_pid'=>$request->pid])
            ->where('arm', 'like', '%' . $request->q . '%')
            ->limit(5)->orderBy('arm')->get(['pid', 'arm']); //
        else
        $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1,'class_pid'=>$request->pid])
                             ->limit(5)->orderBy('arm')->get(['pid', 'arm']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->arm,
            ];
        }
        return response()->json($data);
    }
    public function loadAllClassArm(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1])
            ->where('arm', 'like', '%' . $request->q . '%')
            ->limit(5)->orderBy('arm')->get(['pid', 'arm']); //
        else
        $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1])
                             ->limit(5)->orderBy('arm')->get(['pid', 'arm']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
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
        $data = null;
        if ($request->has('q'))
            $result = ClassArmSubject::join('class_arms','class_arms.pid','arm_pid')
                                   ->join('subjects','subjects.pid', 'subject_pid')
                                   ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' =>$request->pid])
                                   ->where('subject', 'like', '%' . $request->q . '%')
                                    ->limit($request->page_limit)->orderBy('arm')
                                    ->get(['class_arm_subjects.pid', 'arm','subject']); //
        else 
            $result = ClassArmSubject::join('class_arms','class_arms.pid','arm_pid')
                                   ->join('subjects','subjects.pid', 'subject_pid')
                                   ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' =>$request->pid])
                                   ->limit(10)->orderBy('arm')->get(['class_arm_subjects.pid', 'arm','subject']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row-> subject . ' - ' . $row->arm,
            ];
        }
        return response()->json($data);
    }

    // states and local govt 
    public function loadStates(Request $request){
        $data = null;
        if ($request->has('q'))
         $result = State::where('state', 'like', '%' . $request->q . '%')
            ->limit(5)->get(['id','state']); //
        else
        $result = State::limit(10)->get(['id','state']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->id,
                'text' => $row->state,
            ];
        }
        return response()->json($data);
    }
    // states and local govt 
    public function loadStatesLga(Request $request){
       $data = null;
        if($request->has('q'))

            $result = StateLga::where('state_id', $request->pid)->where('lga','like','%'.trim($request->q).'%')->get(['id','lga']); //

        else
            $result = StateLga::where('state_id', $request->pid)->get(['id','lga']); //

        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->id,
                'text' => $row->lga,
            ];
        }
        return response()->json($data);
    }

    // subject  
    // subject type 
    public function loadAvailableSubjectType(Request $request)
    {
        $data = null;
        if ($request->has('q'))
            $result = SubjectType::where(['school_pid' => getSchoolPid()])->where('subject_type','like','%'.$request->q.'%')
                ->orderBy('subject_type')->limit($request->page_limit)->get(['pid', 'subject_type']); //
        else
            $result = SubjectType::where(['school_pid' => getSchoolPid()])
                ->orderBy('subject_type')->limit(10)->get(['pid', 'subject_type']); //
        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->subject_type,
            ];
        }
        return response()->json($data);
    }

    public function loadAvailableHostels(Request $request){
        $data = null;
        if ($request->has('q'))
            $result = Hostel::where(['school_pid' => getSchoolPid()])->where('name', 'like', '%' . $request->q . '%')
                ->orderBy('name')->limit($request->page_limit)->get(['pid', 'name']); //
        else
            $result = Hostel::where(['school_pid' => getSchoolPid()])
                ->orderBy('name')->limit(10)->get(['pid', 'name']); //
        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->name,
            ];
        }
        return response()->json($data);
    }
    
    public function userTitle(){

    }

    private function titleArray(){
        $data = [
            '1'=>'Mr',
            '2'=>'Mrs',
            '3'=>'Mss',
            '4'=>'Dr',
            '4'=>'Dr',
            
        ];
    }
}
