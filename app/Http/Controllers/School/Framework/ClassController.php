<?php

namespace App\Http\Controllers\School\Framework;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadCategory()
    {
        $data = Category::join('school_staff', 'school_staff.pid', 'categories.staff_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->where(['categories.school_pid' => getSchoolPid()])
            ->get(['categories.pid', 'category', 'categories.created_at', 'description', 'username']);
        return datatables($data)
            // ->addColumn('action', function ($data) {
            //     $html = '
            //     <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#editSubjectModal' . $data->pid . '">
            //         <i class="bi bi-box-arrow-up" aria-hidden="true"></i>
            //     </button>
            //     <div class="modal fade" id="editSubjectModal' . $data->pid . '" tabindex="-1">
            //         <div class="modal-dialog">
            //             <div class="modal-content">
            //                 <div class="modal-header">
            //                     <h5 class="modal-title">Edit Lite S</h5>
            //                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            //                 </div>
            //                 <div class="modal-body">
            //                     <form action="" method="post" class="" id="createSubjectForm">
            //                         <p class="text-danger category_pid_error"></p>
            //                         <input type="text" name="subject" value="' . $data->subject_type . '" class="form-control form-control-sm" placeholder="name of school" required>
            //                         <p class="text-danger subject_error"></p>
            //                         <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required>' . $data->description . '</textarea>
            //                         <p class="text-danger description_error"></p>
            //                     </form>
            //                 </div>
            //                 <div class="modal-footer">
            //                     <button type="button" class="btn btn-primary" id="createSubjectBtn">Submit</button>
            //                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            //     ';
            //     return $html;
            // })
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            // ->rawColumns(['data', 'action'])
            ->make(true);
        
    }


    public function loadClasses()
    {
        $data = Classes::join('school_staff', 'school_staff.pid', 'classes.staff_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->join('categories', 'categories.pid', 'classes.category_pid')
        ->where(['classes.school_pid' => getSchoolPid()])
            ->get(['classes.pid', 'category', 'classes.created_at', 'class', 'classes.status','username']);
        return datatables($data)
            // ->addColumn('action', function ($data) {
            //     $html = '
            //     <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#editSubjectModal' . $data->pid . '">
            //         <i class="bi bi-box-arrow-up" aria-hidden="true"></i>
            //     </button>
            //     <div class="modal fade" id="editSubjectModal' . $data->pid . '" tabindex="-1">
            //         <div class="modal-dialog">
            //             <div class="modal-content">
            //                 <div class="modal-header">
            //                     <h5 class="modal-title">Edit Lite S</h5>
            //                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            //                 </div>
            //                 <div class="modal-body">
            //                     <form action="" method="post" class="" id="createSubjectForm">
            //                         <p class="text-danger category_pid_error"></p>
            //                         <input type="text" name="subject" value="' . $data->subject_type . '" class="form-control form-control-sm" placeholder="name of school" required>
            //                         <p class="text-danger subject_error"></p>
            //                         <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required>' . $data->description . '</textarea>
            //                         <p class="text-danger description_error"></p>
            //                     </form>
            //                 </div>
            //                 <div class="modal-footer">
            //                     <button type="button" class="btn btn-primary" id="createSubjectBtn">Submit</button>
            //                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            //     ';
            //     return $html;
            // })
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->editColumn('status', function ($data) {
                $html = $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
                return $html;
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }
    public function loadClassArm()
    {
        $data = ClassArm::join('school_staff', 'school_staff.pid', 'classes.staff_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->join('classes', 'classes.pid', 'class_arms.class_pid')
        ->where(['class_arms.school_pid' => getSchoolPid()])
            ->get(['class_arms.pid', 'class','arm', 'class_arms.created_at', 'class_arms.status','username']);
        return datatables($data)
            // ->addColumn('action', function ($data) {
            //     $html = '
            //     <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#editSubjectModal' . $data->pid . '">
            //         <i class="bi bi-box-arrow-up" aria-hidden="true"></i>
            //     </button>
            //     <div class="modal fade" id="editSubjectModal' . $data->pid . '" tabindex="-1">
            //         <div class="modal-dialog">
            //             <div class="modal-content">
            //                 <div class="modal-header">
            //                     <h5 class="modal-title">Edit Lite S</h5>
            //                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            //                 </div>
            //                 <div class="modal-body">
            //                     <form action="" method="post" class="" id="createSubjectForm">
            //                         <p class="text-danger category_pid_error"></p>
            //                         <input type="text" name="subject" value="' . $data->subject_type . '" class="form-control form-control-sm" placeholder="name of school" required>
            //                         <p class="text-danger subject_error"></p>
            //                         <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required>' . $data->description . '</textarea>
            //                         <p class="text-danger description_error"></p>
            //                     </form>
            //                 </div>
            //                 <div class="modal-footer">
            //                     <button type="button" class="btn btn-primary" id="createSubjectBtn">Submit</button>
            //                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            //     ';
            //     return $html;
            // })
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->editColumn('status', function ($data) {
                $html = $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
                return $html;
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }

    // select 2 
    public function loadAvailableClass()
    {
        $result = Classes::where(['school_pid' => getSchoolPid(), 'status' => 1])
            ->orderBy('class')->get(['pid', 'class']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->class,
            ];
        }
        return response()->json($data);
    }
    public function loadAvailableClassArm()
    {
        $result = ClassArm::where(['school_pid' => getSchoolPid(), 'status' => 1])
            ->orderBy('arm')->get(['pid', 'arm']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->arm,
            ];
        }
        return response()->json($data);
    }

    // select 2 
    public function loadAvailableCategory()
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
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category' => 'required'
        ]);
        if(!$validator->fails()){
            $data = [
                    'school_pid' => getSchoolPid(),
                    'staff_pid' => getSchoolUserPid(),
                    'pid' => public_id(),
                    'category' => strtoupper($request->category),
                    'description' => $request->category
                ];
            $result = $this->insertOrUpdateCategory($data);
            if ($result) {
                $msg = 'New School category created successfully';
                if(isset($request->pid)){
                    $msg = 'School category update successfully';
                }
                return response()->json(['status'=>1,'message'=>$msg]);
            }
            return response()->json(['status'=>'2', 'message'=>'Operation Failed']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function insertOrUpdateCategory($data){
        try {
            return Category::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }

    public function createClass(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_pid' => 'required',
            'class' => 'required|string',
            'class_number' => 'required|int']
            ,[
            'category_pid.required'=>'select school category',
            'class.required'=>'Enter class Name',
            'class_number.required'=>'Enter a unique class number',
            'class_number.int'=>'class number must a number',
            ]
        );
        if(!$validator->fails()){
            $data = [
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid(),
                'pid' => public_id(),
                'class_number' => $request->class_number,
                'class' => $request->class,
                'category_pid' => $request->category_pid,
            ];
            $result = $this->insertOrUpdateClass($data);
            if ($result) {
                $msg = 'school class created successfully';
                if(isset($request->pid)){
                    $msg = 'class updated successfully';
                }
                return response()->json(['status'=>1,'message'=> $msg]);
            }
            return response()->json(['status'=>'error','message'=> 'operation failed']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function insertOrUpdateClass($data){
        try {
            return Classes::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    public function createClassArm(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'arm' => 'required|min:4|max:25',
            'class_pid' => 'required',
        ],[
            'class_pid.required' => 'select school category',
            'arm.required' => 'Enter class Arm e.g grade 1 a for grade 1 & jss 1 a for jss 1',
            'arm.max' => 'Maxismum of 25 character',
            'arm.min' => 'Minimum of 3 character',
        ]);
        if(!$validator->fails()){
            $data = [
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid(),
                'pid' => public_id(),
                'arm' => $request->arm,
                'class_pid' => $request->class_pid,
            ];
            $result = $this->insertOrUpdateClassArm($data);
            if ($result) {
                $msg = 'Class arm created successfully';
                if(isset($request->pid)){
                    $msg = 'Class arm updated successfully';
                }
                return response()->json(['status'=>1,'message'=> $msg]);
            }
            return response()->json(['status'=>'error','message'=> 'Operation Failed']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function insertOrUpdateClassArm($data){
        try {
            return ClassArm::updateOrCreate(['school_pid'=>$data['school_pid'],'pid'=>$data['pid']],$data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
