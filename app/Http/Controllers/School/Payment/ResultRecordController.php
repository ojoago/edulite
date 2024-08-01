<?php

namespace App\Http\Controllers\School\Payment;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Payment\ResultRecord;
use App\Models\School\Student\Result\StudentClassResultParam;
use Illuminate\Http\Request;

class ResultRecordController extends Controller
{
    //
    public static function computeTermlyResults(){

        $exams = self::termlyResult();

        if ($exams) {
            $total = 0;
            $fee = 500;
            $discount = 0;

            foreach ($exams as $exam) {
                $total += $exam->students;
            }
            $resultArray = [
                'total_students' => $total,
                'fee' => $fee,
                'discount' => $discount,
                'amount' => $total * $fee,
                'term' => activeTermName(),
                'session' => activeSessionName(),
                'term_pid' => activeTerm(),
                'session_pid' => activeSession(),
                "classes" => $exams,
                'school_pid' => getSchoolPid(),
            ];

            $res = self::updateOrAddResultRecord($resultArray);
            if ($res) {
                // student_class_result_params
                StudentClassResultParam::where(['school_pid' => getSchoolPid(), 'term_pid' => activeTerm(), 'session_pid' => activeSession(), 'status' => 1])->update(['status' => 1]);
            }
        }
    }

    public static function termlyResult()
    {
        try {
            $results = DB::table('student_class_result_params as p')->join('class_arms as a', 'a.pid', 'p.arm_pid')
                ->join('classes as e', 'a.class_pid', 'e.pid')
                ->join('categories as c', 'c.pid', 'e.category_pid')
                ->join('student_class_results as r', 'r.class_param_pid', 'p.pid')
                ->where(['p.school_pid' => getSchoolPid(), 'p.term_pid' => activeTerm(), 'p.session_pid' => activeSession(), 'p.status' => 1])
                ->select('category', 'arm_pid', 'class', 'p.arm', DB::raw('count(r.id) as students'))->groupBy('category', 'arm_pid', 'class', 'p.arm')->get();
            return $results;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    public function resultRecords()
    {
        try {

            $result = ResultRecord::where(['school_pid' => getSchoolPid()])->get();

            return datatables($result)
                ->editColumn('amount', function ($data) {
                    return $data->total_students .' * '. $data->fee . ' = '.number_format($data->amount)  ;
                })
                ->editColumn('status', function ($data) {
                    return RESULT_FEE_STATUS[$data->status] ;
                })
                ->addColumn('action', function($data){
                 return view('school.result-record.result-records-action-button', ['data' => $data]);
                } )
                ->addIndexColumn()
                ->make(true);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    public function resultDetails(Request $request)
    {
        try {

            $data = ResultRecord::where(['school_pid' => getSchoolPid() , 'id' => base64Decode($request->id)])->first();
            return view('school.result-record.result-details', compact('data'));
           
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }



    public function loadSchoolResult()
    {

        try {
            $results = self::termlyResult();
            return datatables($results)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('school.student.assessment.publish-action-button', ['data' => $data]);
                })
                ->make(true);
            return view('school.student.assessment.publish-class-result', compact('data', 'scoreParams', 'param'));
        } catch (\Throwable $e) {
            $results = [];
            logError($e->getMessage());
            return view('school.student.assessment.publish-class-result', compact('results'))->with('error', ER_500);
        }
    }


    public function publishSchoolResult()
    {
    }



    private function updateOrAddResultRecord($data)
    {
        try {
            return ResultRecord::updateOrCreate(['term_pid' => $data['term_pid'], 'session_pid' => $data['session_pid'], 'school_pid' => getSchoolPid()], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

}
