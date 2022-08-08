<?php

namespace App\Http\Controllers\School\Framework\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Framework\Subject\SubjectType;
use Illuminate\Support\Facades\Validator;

class SubjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $data = SubjectType::join('school_staff', 'school_staff.pid','subject_types.staff_pid')
                            ->join('users','users.pid','school_staff.user_pid')
                            ->where(['subject_types.school_pid'=>getSchoolPid()])
                            ->get(['subject_types.pid','subject_type', 'subject_types.created_at', 'subject_types.description','username']);
        return datatables($data)
            ->addColumn('action', function ($data) {
                $html = '
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#editSubjectModal' . $data->pid . '">
                    <i class="bi bi-box-arrow-up" aria-hidden="true"></i>
                </button>
                <div class="modal fade" id="editSubjectModal' . $data->pid . '" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Lite S</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" class="" id="createSubjectForm">
                                    <p class="text-danger category_pid_error"></p>
                                    <input type="text" name="subject" value="' . $data->subject_type . '" class="form-control form-control-sm" placeholder="name of school" required>
                                    <p class="text-danger subject_error"></p>
                                    <textarea type="text" name="description" class="form-control form-control-sm" placeholder="description" required>' . $data->description . '</textarea>
                                    <p class="text-danger description_error"></p>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="createSubjectBtn">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                ';
                return $html;
            })
            ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
            ->rawColumns(['data', 'action'])
            ->make(true);
    }

    public function loadAvailableSubjectType(){

        $result = SubjectType::where(['school_pid' => getSchoolPid()])
            ->orderBy('subject_type')->limit(20)->get(['pid', 'subject_type']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->subject_type,
            ];
        }
        return response()->json($data);

    }

    public function createSubjectType(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject'=> 'required|string|min:3|max:22|regex:/^[a-zA-Z0-9\s]+$/',
            // Rule::unique()
            
        ],[
            'subject.required'=>'Enter Subject Type',
            'subject.max'=>'Subject Type should not be more than 22 character',
            'subject.max'=>'Maximum of 22 characters',
            'subject.min'=>'Minimum of 3 characters',
            'subject.regex'=>'Special Character not allowed e.g #$%^*. etc',
        ]);
        if(!$validator->fails()){

            $data = [
                'school_pid'=> getSchoolPid(),
                'pid'=> public_id(),
                'staff_pid'=> getSchoolUserPid(),
                'subject_type'=>strtoupper($request->subject),
                'description'=>$request->description
            ];

            $result = $this->createOrUpdateSubjectType($data);
            
            if ($result) {
                return response()->json(['status'=>1,'message'=>'Subject Type Created']);
            }
            return response()->json(['status'=>2,'message'=>'Something Went Wrong']);
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        //uniqueNess('subject_types','subject',$request->subject);
        
    }

    private function createOrUpdateSubjectType($data)
    {
        try {
            return  SubjectType::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
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
