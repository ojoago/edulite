<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Subject\Subject;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Subject::join('school_staff', 'school_staff.pid', 'subjects.staff_pid')
        ->join('subject_types', 'subject_types.pid', 'subjects.subject_type_pid')
        ->join('users', 'users.pid', 'school_staff.user_pid')
        ->where(['subjects.school_pid' => getSchoolPid()])
            ->get(['subjects.pid','subject', 'subjects.status','subject_type', 'subjects.created_at', 'subjects.description', 'username']);
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
                return $data->created_at->diffForHumans();
            })
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? '<span class = "text-succses"> Enabled</span>' : '<span class = "text-danger">Disabled</span>';
            })
            ->rawColumns(['data', 'status'])
            ->make(true);
    }

    public function createSchoolCategorySubject(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required|string',
            'subject_type_pid' => 'required|string',
            'category_pid' => 'required|string'
        ],[
            'subject.required'=>'Enter Subject Name', 
            'subject_type_pid.required'=>'Select Subject Type',
            'category_pid.required'=>'Select School Category',
        ]);
        if(!$validator->fails()){
            $request['school_pid'] = getSchoolPid();
            $request['pid'] = public_id();
            $request['staff_pid'] = getUserPid();
            $data = [
                'school_pid'=>getSchoolPid(),
                'pid'=>public_id(),
                'staff_pid'=>getSchoolUserPid(),
                'subject'=>strtoupper($request->subject),
                'subject_type_pid'=>$request->subject_type_pid,
                'category_pid'=>$request->category_pid,
                'description'=>$request->description,
            ];
            $result = $this->createOrUpdateSubject($data);
            if ($result) {
                return response()->json(['status'=>1,'message'=>'Subject Created Successfully']);
            }
            return response()->json(['status'=>'error', 'message' => 'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        
    }

    private function createOrUpdateSubject($data)
    {
        try {
            return  Subject::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
    }
    
}
