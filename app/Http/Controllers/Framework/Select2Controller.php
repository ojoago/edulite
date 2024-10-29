<?php

namespace App\Http\Controllers\Framework;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\School\System\State;
use App\Http\Controllers\Controller;
use App\Models\School\Student\Student;
use App\Models\School\System\StateLga;
use App\Models\School\Rider\SchoolRider;
use App\Models\School\Staff\SchoolStaff;
use App\Models\School\Framework\Term\Term;
use App\Models\School\Framework\Fees\FeeItem;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Hostel\Hostel;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Subject\Subject;
use App\Models\School\Registration\SchoolParent;
use App\Models\School\Framework\Subject\SubjectType;
use App\Models\School\Framework\Class\ClassArmSubject;
use App\Models\School\Framework\Assessment\AssessmentTitle;
use App\Models\School\Framework\Fees\FeeAccount;
use App\Models\School\Framework\Psychomotor\PsychomotorBase;
use App\Models\School\Framework\Result\AwardKey;

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
            ->limit(40)
            ->orderBy('subject')
            ->get(['pid', 'subject']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
            foreach ($result as $row) {
                $data[] = [
                    'id' => $row->pid,
                    'text' => $row->subject,
                ];
            }
            return response()->json($data);
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
            ->orderBy('school_staff.id', 'DESC')->limit(30)->get(['school_staff.pid', 'user_details.fullname','role']); //
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
        $result = Student::where(['school_pid'=>getSchoolPid(),'status'=>1])
                            ->limit(35)
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
                            ->limit(35)
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
                                    ['current_class_pid',$request->pid]
                                    ])
                                ->orwhere([
                                    ['school_pid', getSchoolPid()],
                                    ['status', 1],
                                    ['current_class_pid',$request->pid]])
                                    ->limit($request->page_limit)
            ->orderBy('id', 'DESC')->get(['pid', 'fullname', 'reg_number']); //
        else
        $result = Student::where('school_pid',getSchoolPid())
                            ->limit(35)
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
                            ->limit(30)
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
            $limit = 25;
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
                            ->limit(25)->orderBy('class')->get(['pid', 'class']); //
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
    // load all category class 2 
    public function loadAvailableAllClasses(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = Classes::where(['school_pid' => getSchoolPid(), 'status' => 1])
            ->where('class', 'like', '%' . $request->q . '%')
            ->limit(5)->orderBy('class')->get(['pid', 'class']); //
        else
        $result = Classes::where(['school_pid' => getSchoolPid(), 'status' => 1])
                            ->limit(25)->orderBy('class')->get(['pid', 'class']); //
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
    public function loadAvailableAdmissionClass(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = DB::table('classes as c')
                        ->join('admission_setups as as','c.pid','as.class_pid')
                        ->join('admission_details as ad','ad.pid','as.admission_pid')
                        ->join('active_admissions  as t', 't.admission_pid','as.admission_pid')
                        ->where(['ad.school_pid' => getSchoolPid()])
            ->where('class', 'like', '%' . $request->q . '%')
            ->limit(10)->orderBy('class')->get(['c.pid', 'c.class']); //
        else
        $result = DB::table('classes as c')
                    ->join('admission_setups as as', 'c.pid', 'as.class_pid')
                    ->join('admission_details as ad', 'ad.pid', 'as.admission_pid')
                    ->join('active_admissions  as t', 't.admission_pid', 'as.admission_pid')
                    ->where(['ad.school_pid' => getSchoolPid()])
                    ->limit(25)->orderBy('class')->get(['c.pid', 'c.class']); //
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
                             ->limit(25)->orderBy('arm')->get(['pid', 'arm']); //
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
                             ->limit(25)->orderBy('arm')->get(['pid', 'arm']); //
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
        if (schoolAdmin()){
            if ($request->has('q'))
                $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
                    ->join('subjects', 'subjects.pid', 'subject_pid')
                    ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' => $request->pid])
                    ->where('subject', 'like', '%' . $request->q . '%')
                    ->limit($request->page_limit)->orderBy('arm')
                    ->get(['class_arm_subjects.pid', 'arm', 'subject']); //
            else
                $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
                    ->join('subjects', 'subjects.pid', 'subject_pid')
                    ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' => $request->pid])
                    ->limit(35)->orderBy('arm')->get(['class_arm_subjects.pid', 'arm', 'subject']); //
        }
        else{
            if ($request->has('q')){
                // load subject classes assigend  to class teacher 
                $class = DB::table('class_arm_subjects as cas')->join('class_arms as ca', 'ca.pid', 'arm_pid')
                ->join('subjects as s', 'subjects.pid', 'subject_pid')
                ->join('staff_classes as sc', 'sc.arm_pid', 'ca.pid')
                ->where([
                    'ca.school_pid' => getSchoolPid(), 
                    'cas.arm_pid' => $request->pid,
                    'sc.teacher_pid'=>getSchoolUserPid(),
                    'sc.term_pid'=>activeTerm(),
                    'sc.session_pid'=>activeSession(),'s.status'=>1])
                    ->where('subject', 'like', '%' . $request->q . '%')
                    ->limit($request->page_limit)->orderBy('arm')
                    ->get(['cas.pid', 'arm', 'subject']); //
                // load class subject assigned to teacher 
                $sbj = DB::table('class_arm_subjects as cas')->join('class_arms as ca', 'ca.pid', 'arm_pid')
                ->join('subjects as s', 's.pid', 'cas.subject_pid')
                ->join('staff_subjects as sb', 'sb.arm_subject_pid', 'ca.pid')
                ->where([
                    'ca.school_pid' => getSchoolPid(),
                    'cas.arm_pid' => $request->pid,
                    'sb.teacher_pid' => getSchoolUserPid(),
                    'sb.term_pid' => activeTerm(),
                    'sb.session_pid' => activeSession(), 's.status' => 1
                ])
                    ->where('subject', 'like', '%' . $request->q . '%')
                    ->limit($request->page_limit)->orderBy('arm')
                    ->get(['cas.pid', 'arm', 'subject']); //
                    // merge to avoid duplicate 
                $result = $class->merge($sbj);
            }else{
                // load subject classes assigend  to class teacher 
                $class = DB::table('class_arm_subjects as cas')->join('class_arms as ca', 'ca.pid', 'arm_pid')
                    ->join('subjects as s', 's.pid', 'cas.subject_pid')
                    ->join('staff_classes as sc', 'sc.arm_pid', 'ca.pid')
                    ->where([
                        'ca.school_pid' => getSchoolPid(),
                        'cas.arm_pid' => $request->pid,
                        'sc.teacher_pid' => getSchoolUserPid(),
                        'sc.term_pid' => activeTerm(),
                        'sc.session_pid' => activeSession(), 's.status' => 1
                    ])
                    // ->where('subject', 'like', '%' . $request->q . '%')
                    ->limit(25)->orderBy('arm')
                    ->get(['cas.pid', 'arm', 's.subject']); //
                // load class subject assigned to teacher 
                $sbj = DB::table('class_arm_subjects as cas')->join('class_arms as ca', 'ca.pid', 'arm_pid')
                    ->join('subjects as s', 's.pid', 'cas.subject_pid')
                    ->join('staff_subjects as sb', 'sb.arm_subject_pid', 'cas.pid')
                    ->where([
                        'ca.school_pid' => getSchoolPid(),
                        'cas.arm_pid' => $request->pid,
                        'sb.teacher_pid' => getSchoolUserPid(),
                        'sb.term_pid' => activeTerm(),
                        'sb.session_pid' => activeSession(),
                         's.status' => 1
                    ])
                    // ->where('subject', 'like', '%' . $request->q . '%')
                    ->limit(25)->orderBy('arm')
                    ->get(['cas.pid', 'arm', 's.subject']); //
                // merge to avoid duplicate 
                $result = $class->merge($sbj);
            }
                // $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
                //     ->join('subjects', 'subjects.pid', 'subject_pid')
                //     ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' => $request->pid])
                //     ->limit(10)->orderBy('arm')->get(['class_arm_subjects.pid', 'arm', 'subject']); //
        }
        
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        $dup = [];
        foreach ($result as $row) {
            $txt = $row->subject . ' - ' . $row->arm;
            if(!in_array($txt,$dup)){
                $data[] = [
                    'id' => $row->pid,
                    'text' => $txt,
                ];
            }
            $dup[] = $txt;
        }
        return response()->json($data);
    }
    public function loadAvailableClassAllArmsSubject(Request $request)
    {
        $data = null;
        if ($request->has('q'))
            $result = ClassArmSubject::join('class_arms','class_arms.pid','arm_pid')
                                   ->join('subjects','subjects.pid', 'subject_pid')
                                   ->where(['class_arms.school_pid' => getSchoolPid(), 'class_pid' =>$request->pid])
                                   ->where('subject', 'like', '%' . $request->q . '%')
                                    ->limit(25)->orderBy('arm')
                                    ->get(['class_arm_subjects.pid', 'arm','subject']); //
        else 
            $result = ClassArmSubject::join('class_arms','class_arms.pid','arm_pid')
                                   ->join('subjects','subjects.pid', 'subject_pid')
                                   ->where(['class_arms.school_pid' => getSchoolPid(), 'class_pid' =>$request->pid])
                                   ->limit(25)->orderBy('arm')->get(['class_arm_subjects.pid', 'arm','subject']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        $dup = [];
        foreach ($result as $row) {
            $txt = $row->subject . ' - ' . $row->arm;
            if (!in_array($txt, $dup)) {
                $data[] = [
                    'id' => $row->pid,
                    'text' => $txt,
                ];
            }
            $dup[] = $txt;
        }
        return response()->json($data);
    }
    public function loadAllSchoolSubject(Request $request)
    {
        $data = null;
        if ($request->has('q'))
            $result = Subject::where(['school_pid' => getSchoolPid(), 'status' =>1])
                                   ->where('subject', 'like', '%' . $request->q . '%')
                                    ->limit(25)->orderBy('subject')
                                    ->get(['pid', 'subject']); //
        else
            $result = Subject::where(['school_pid' => getSchoolPid(), 'status' => 1])
            // ->where('subject', 'like', '%' . $request->q . '%')
                ->limit(25)->orderBy('subject')
                ->get(['pid', 'subject']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row-> subject,
            ];
        }
        return response()->json($data);
    }


    // load all classes based on what is assigned to form/class teacher 
    public function loadClassTeacherClass(Request $request)
    {
       
            if ($request->has('q')){
                $class = DB::table('class_arms as c')->join('staff_classes as s','s.arm_pid','c.pid')
                ->where(['s.teacher_pid'=> getSchoolUserPid(),
                's.school_pid'=>getSchoolPid(),
                'c.status'=>1, 
                'c.class_pid' => $request->pid, 
                's.term_pid' => activeTerm(),
                's.session_pid' => activeSession()])
                ->where('c.arm', 'like', '%' . $request->q . '%')
                ->limit(20)->orderBy('c.arm')
                ->get(['c.pid as id', 'c.arm as text']);
            }
            else{
                $class = DB::table('class_arms as c')->join('staff_classes as s', 's.arm_pid', 'c.pid')
                ->where([
                    's.teacher_pid' => getSchoolUserPid(), 
                    's.school_pid' => getSchoolPid(), 
                    'c.status' => 1, 
                    'c.class_pid' => $request->pid,
                    's.term_pid' => activeTerm(),
                    's.session_pid' => activeSession(),
                    ])
                    ->limit(20)->orderBy('c.arm')
                    ->get(['c.pid as id', 'c.arm as text']); //
            }
        if ($class->isEmpty()) {
            
            return response()->json(['id' => null, 'text' => 'No Class Assigned to you']);
        }
        
        return response()->json($class);
    }
    // load all classes based on what is assigned to form/class teacher 
    public function loadClassTeacherClassArms(Request $request)
    {
       
        $data = null;
        if(schoolAdmin()){
            if ($request->has('q'))
                $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1, 'class_pid' => $request->pid])
                    ->where('arm', 'like', '%' . $request->q . '%')
                    ->limit(20)->orderBy('arm')->distinct('ca.arm')->get(['pid', 'arm']); //
            else
                $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1, 'class_pid' => $request->pid])
                    ->limit(20)->orderBy('arm')->distinct('ca.arm')->get(['pid', 'arm']); //
        }else{
            if ($request->has('q')){
                $class = DB::table('class_arms as c')->join('staff_classes as s','s.arm_pid','c.pid')
                ->where(['s.teacher_pid'=> getSchoolUserPid(),
                's.school_pid'=>getSchoolPid(),
                'c.status'=>1, 
                'c.class_pid' => $request->pid, 
                's.term_pid' => activeTerm(),
                's.session_pid' => activeSession()])
                ->where('c.arm', 'like', '%' . $request->q . '%')
                ->limit(20)->orderBy('c.arm')
                    ->distinct('ca.arm')
                ->get(['c.pid', 'c.arm']);
                $sbj = DB::table('class_arms as ca')->join('class_arm_subjects as cas','cas.arm_pid','ca.pid')
                                                    ->join('staff_subjects as sb', 'cas.pid', 'sb.arm_subject_pid')
                ->where(['sb.teacher_pid' => getSchoolUserPid(),
                        'sb.term_pid'=>activeTerm(),
                        'sb.session_pid'=>activeSession(),
                        'ca.school_pid' => getSchoolPid(), 
                        'ca.class_pid' => $request->pid,
                        'cas.status' => 1])
                        ->where('c.arm', 'like', '%' . $request->q . '%')
                ->limit(20)->orderBy('ca.arm')
                    ->distinct('ca.arm')
                ->get(['ca.pid', 'ca.arm']);
                $result = $class->merge($sbj);
            }
            else{
                $class = DB::table('class_arms as c')->join('staff_classes as s', 's.arm_pid', 'c.pid')
                ->where([
                    's.teacher_pid' => getSchoolUserPid(), 
                    's.school_pid' => getSchoolPid(), 
                    'c.status' => 1, 
                    'c.class_pid' => $request->pid,
                    's.term_pid' => activeTerm(),
                    's.session_pid' => activeSession(),
                    ])
                    ->limit(20)->orderBy('c.arm')
                    ->distinct('ca.arm')
                    ->get(['c.pid', 'c.arm']); //
                    
                    $sbj = DB::table('class_arms as ca')->join('class_arm_subjects as cas', 'cas.arm_pid', 'ca.pid')
                    ->join('staff_subjects as sb', 'cas.pid', 'sb.arm_subject_pid')
                    ->where([
                        'sb.teacher_pid' => getSchoolUserPid(),
                        'sb.term_pid' => activeTerm(),
                        'sb.session_pid' => activeSession(),
                        'ca.school_pid' => getSchoolPid(),
                        'ca.class_pid' => $request->pid,
                        'cas.status' => 1
                        ])
                        ->limit(20)->orderBy('ca.arm')
                        ->distinct('ca.arm')
                        ->get(['ca.pid', 'ca.arm']);
          

                $result = $class->merge($sbj);
            }
        }
        if (!$result) {
            
            return response()->json(['id' => null, 'text' => 'no class assigned to you']);
        }
        // $result = array_unique($result);
        $dup = [];
        foreach ($result as $row) {
            if(!in_array($row->arm,$dup)){
                $data[] = [
                    'id' => $row->pid,
                    'text' => $row->arm,
                ];
            }
            $dup[] = $row->arm;
            
        }
        return response()->json($data);
    }


    // load class arms subject for teacher or class teacher or previliged staff 
    public function loadClassTeacherClassArmsSubject(Request $request)
    {
        $data = null;
        if(schoolAdmin()){
            if ($request->has('q'))
                $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
                    ->join('subjects', 'subjects.pid', 'subject_pid')
                    ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' => $request->pid])
                    ->where('subject', 'like', '%' . $request->q . '%')
                    ->limit(25)->orderBy('arm')
                    ->get(['class_arm_subjects.pid', 'arm', 'subject']); //
            else
                $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
                    ->join('subjects', 'subjects.pid', 'subject_pid')
                    ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' => $request->pid])
                    ->limit(25)->orderBy('arm')->get(['class_arm_subjects.pid', 'arm', 'subject']); //
        }else{
            if ($request->has('q'))
                $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
                    ->join('subjects', 'subjects.pid', 'subject_pid')
                    ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' => $request->pid])
                    ->where('subject', 'like', '%' . $request->q . '%')
                    ->limit(25)->orderBy('arm')
                    ->get(['class_arm_subjects.pid', 'arm', 'subject']); //
            else
                $result = ClassArmSubject::join('class_arms', 'class_arms.pid', 'arm_pid')
                    ->join('subjects', 'subjects.pid', 'subject_pid')
                    ->where(['class_arms.school_pid' => getSchoolPid(), 'arm_pid' => $request->pid])
                    ->limit(25)->orderBy('arm')->get(['class_arm_subjects.pid', 'arm', 'subject']); //
        }
        if (!$result) {
            return response()->json(['id' => 0, 'text' => null]);
        }
        // $result = array();
        // foreach ($array as $key => $value) {
        //     if (!in_array($value, $result))
        //     $result[$key] = $value;
        // }
        $dup = [];
        foreach ($result as $row) {
            $txt = $row->subject . ' - ' . $row->arm;
            if(!in_array($txt,$dup)){
                $data[] = [
                    'id' => $row->pid,
                    'text' => $txt,
                ];
            }
            $dup[] = $txt;
        }
        return response()->json($data);
    }
    // states and local govt 
    public function loadStates(Request $request){
        $data = null;
        if ($request->has('q'))
         $result = State::where('state', 'like', '%' . $request->q . '%')
            ->limit(40)->get(['id','state']); //
        else
        $result = State::limit(40)->get(['id','state']); //
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
                ->orderBy('subject_type')->limit(25)->get(['pid', 'subject_type']); //
        else
            $result = SubjectType::where(['school_pid' => getSchoolPid()])
                ->orderBy('subject_type')->limit(25)->get(['pid', 'subject_type']); //
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

    public function loadAvailablePsychomotors(Request $request){
        $data = null;
        if ($request->has('q'))
            $result = PsychomotorBase::where(['school_pid' => getSchoolPid(), 'status' => 1,'category_pid'=>$request->pid])
                                        ->where('psychomotor', 'like', '%' . $request->q . '%')->where('status',1)
                ->orderBy('psychomotor')->limit($request->page_limit)->get(['pid', 'psychomotor']); //
        else
            $result = PsychomotorBase::where(['school_pid' => getSchoolPid(),'status'=>1, 'category_pid' => $request->pid])
                ->orderBy('psychomotor')->limit(10)->get(['pid', 'psychomotor']); //
        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->psychomotor,
            ];
        }
        return response()->json($data);
    }
    public function loadAvailableAllPsychomotors(Request $request){
        $data = null;
        if ($request->has('q'))
            $result = PsychomotorBase::where(['school_pid' => getSchoolPid(), 'status' => 1])
                                        ->where('psychomotor', 'like', '%' . $request->q . '%')->where('status', 1)
                ->orderBy('psychomotor')->limit($request->page_limit)->get(['pid', 'psychomotor']); //
        else
            $result = PsychomotorBase::where(['school_pid' => getSchoolPid(),'status'=>1])
                ->orderBy('psychomotor')->limit(10)->get(['pid', 'psychomotor']); //
        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->psychomotor,
            ];
        }
        return response()->json($data);
    }

    // load fee name 
    public function loadAvailableFeeAccount(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = FeeAccount::where(['school_pid' => getSchoolPid()])->where('account_name', 'like', '%' . $request->q . '%')
            ->orderBy('bank_name')->limit(25)->get(['pid', 'account_name' , 'bank_name']); //
        else
        $result = FeeAccount::where(['school_pid' => getSchoolPid()])
        ->orderBy('bank_name')->limit(25)->get(['pid', 'account_name', 'bank_name']); //
        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->account_name.' | ' . $row->bank_name ,
            ];
        }
        return response()->json($data);
    }

    
    // load fee name 
    public function loadAvailableFeeItem(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = FeeItem::where(['school_pid' => getSchoolPid()])->where('fee_name', 'like', '%' . $request->q . '%')
            ->orderBy('fee_name')->limit(25)->get(['pid', 'fee_name']); //
        else
        $result = FeeItem::where(['school_pid' => getSchoolPid()])
        ->orderBy('fee_name')->limit(25)->get(['pid', 'fee_name']); //
        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->fee_name,
            ];
        }
        return response()->json($data);
    }



    public function loadAvailableOnDemandFee(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = $data = DB::table('fee_configurations as c')
            ->join('fee_items as f', 'f.pid', 'c.fee_item_pid')
            ->join('fee_item_amounts as i', 'i.config_pid', 'c.pid')
            ->join('class_arms as a', 'a.pid', 'i.arm_pid')
            ->where(['i.school_pid' => getSchoolPid(), 'type' => 2])->where('fee_name', 'like', '%' . $request->q . '%')
            ->orderBy('fee_name')->limit(25)->select('amount','i.pid','fee_name')->get(); //
        else
        $result = $data = DB::table('fee_configurations as c')
        ->join('fee_items as f', 'f.pid', 'c.fee_item_pid')
        ->join('fee_item_amounts as i', 'i.config_pid', 'c.pid')
        ->join('class_arms as a', 'a.pid', 'i.arm_pid')
        ->where(['i.school_pid' => getSchoolPid(),'type'=>2])
            ->select('amount','i.pid','fee_name')
            ->orderBy('fee_name')->orderBy('arm')
            ->get();
        if (!$result) {
            $data[] = ['id' => null, 'text' => null];
            return response()->json($data);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->amount,
                'text' => $row->fee_name.' : ' .number_format($row->amount,2),
            ];
            
        }
        return response()->json($data);
    }


    // hire me 
    public function loadAllStateSchoolSubject(Request $request)
    {
        $data = null;
        if ($request->has('q'))
        $result = DB::table('subjects as b')->join('schools as s', 's.pid', 'b.school_pid')
            ->where(['s.state' => $request->pid,'b.status'=>1])
            ->where('subject', 'like', '%' . $request->q . '%')
            ->limit(25)->orderBy('subject')
            ->get(['b.pid', 'subject']); //
        else
        $result = DB::table('subjects as b')->join('schools as s', 's.pid', 'b.school_pid')
            ->where(['s.state' => $request->pid, 'b.status' => 1])
            ->limit(25)->orderBy('subject')->get(['b.pid', 'subject']); //
        if (!$result) {
            return response()->json(['id' => null, 'text' => null]);
        }
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->subject,
            ];
        }
        return response()->json($data);
    }

    public function loadSchoolTerm()
    {
        try {
            $data = [];
            $result = Term::where(['school_pid' => getSchoolPid()])
            ->limit(10)->orderBy('id', 'DESC')
            ->get(['pid', 'term']);
            foreach ($result as $row) {
                $data[] = [
                    'id' => $row->pid,
                    'text' => $row->term,
                ];
            }
            return response()->json($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
    }

    public function loadAvailableTitle()
    {
        $result = AssessmentTitle::where(['school_pid' => getSchoolPid(), 'status' => 1])
            ->orderBy('title')->get(['pid', 'title']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->title,
            ];
        }
        return response()->json($data);
    }


    public function loadAward(Request $request)
    {
        $data = [];
        $result = AwardKey::where(['school_pid' => getSchoolPid(), 'status' => 1])
            ->orderBy('award')->get(['pid', 'award', 'type']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->award .' - '. AWARD_TYPE[$row->type] ,
            ];
        }
        return response()->json($data);
    }


}
