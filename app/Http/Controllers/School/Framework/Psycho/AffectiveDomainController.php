<?php

namespace App\Http\Controllers\School\Framework\Psycho;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Psycho\AffectiveDomain;

class AffectiveDomainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { {
            $data = AffectiveDomain::join('school_staff', 'school_staff.pid', 'affective_domains.staff_pid')
            ->join('users', 'users.pid', 'school_staff.user_pid')
            ->where(['affective_domains.school_pid' => getSchoolPid()])
                ->get(['affective_domains.pid', 'title', 'affective_domains.created_at', 'affective_domains.max_score', 'affective_domains.status', 'username']);
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
                    return $data->status == 1 ? '<span class="text-success">Enabled</span>' : '<span class="text-danger">Disabled</span>';
                })
                ->rawColumns(['data', 'status'])
                ->make(true);
        }
    }


    public function createEffectiveDomain(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:30|regex:/^[a-zA-Z0-9\s]+$/',
            'score' => 'required|int|digits_between:1,5'
        ], [
            'title.max' => 'Maximum of 30 character',
            'title.regex' => 'only number and text is allowed',
            'score.required' => 'Enter Obtainable Score',
            'score.digits_between' => 'Obtainable Score 5 Maximum',
        ]);

        if (!$validator->fails()) {
            $data = [
                'title' => strtoupper($request->title),
                'max_score' => $request->score,
                'pid' => public_id(),
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid()
            ];
            $result = $this->createOrUpdateEffectiveDomain($data);
            if ($result) {
                $msg = 'Effective Psychomotor domain created successfully';
                if ($request->pid) {
                    $msg = 'Effective Psychomotor domain updated successfully';
                }

                return response()->json(['status' => 1, 'message' => $msg]);
            }
            return response()->json(['status' => 'error', 'message' => 'Something Weng Wrong']);
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    private function createOrUpdateEffectiveDomain($data)
    {
        try {
            return  AffectiveDomain::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
        }
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
