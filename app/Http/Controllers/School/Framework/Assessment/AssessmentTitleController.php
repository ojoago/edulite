<?php

namespace App\Http\Controllers\School\Framework\Assessment;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Assessment\AssesmentTitle;
use App\Models\School\Framework\Assessment\ScoreSetting;
use App\Models\School\Framework\Class\ClassArm;
use App\Models\School\Framework\Class\Classes;
use App\Models\School\Framework\Session\Session;
use App\Models\School\Framework\Term\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssessmentTitleController extends Controller
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
    {
        // $session = Session::where('school_pid',getSchoolPid())->get(['pid','session']);//
        $data = AssesmentTitle::where('school_pid',getSchoolPid())
                    ->get(['pid','title','description','category','created_at']); //
        // $term = Term::where('school_pid',getSchoolPid())->get(['pid','term']);//
        // $classes = Classes::where('school_pid',getSchoolPid())->get(['pid','class']);//
        // $arm = ClassArm::where('school_pid',getSchoolPid())->get(['pid','arm']);//class arm
        // $score = ScoreSetting::where('school_pid',getSchoolPid())->get(['pid','score'])->dd();//class arm
        return datatables($data)->editColumn('created_at', function ($data) {
            return date('d F Y', strtotime($data->created_at));
        })->editColumn('category', function ($data) {
            return $data->category == 2 ? 'Mid-Term' : 'General';
        })->make(true);
        // return view('school.framework.assessment.index',compact('data','session','term','classes','arm'));
    }
    public function loadAvailableTitle()
    {
        $result = AssesmentTitle::where(['school_pid'=>getSchoolPid(),'status'=>1])
            ->orderBy('title')->get(['pid','title']); //
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->pid,
                'text' => $row->title,
            ];
        }
        return response()->json($data);
    }
    public function createAssessmentTitle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'category' => 'required|int',
        ]);
        
        if(!$validator->fails()){
            $request['school_pid'] = getSchoolPid();
            $request['staff_pid'] = getUserPid();
            $request['pid'] = public_id();
            $data = [
                'school_pid' => getSchoolPid(),
                'staff_pid' => getSchoolUserPid(),
                'pid' => public_id(),
                'title'=>strtoupper($request->title),
                'category'=>$request->category,
                'description'=>strtoupper($request->description),
            ];
            $result = $this->createOrUpdateAssesmentTitle($data);
            if ($result) {
                return response()->json(['status'=>1,'message'=> 'Title Created']);
            }
        
            return response()->json(['status'=>2,'message'=> 'failed to create title']);
        
        }

        return response()->json(['status'=>0,'error'=> $validator->errors()->toArray()]);
        
    }

    private function createOrUpdateAssesmentTitle($data)
    {
        try {
            return  AssesmentTitle::updateOrCreate(['pid' => $data['pid'], 'school_pid' => $data['school_pid']], $data);
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
