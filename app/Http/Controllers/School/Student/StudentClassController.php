<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\School\Student\StudentCLass;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function createStudentClassRecord($data){
        $dupParams = [
            'student_pid' =>$data['student_pid'], 
            'session_pid' => $data['session_pid'],
            'arm_pid' => $data['arm_pid'], 
            'school_pid' => $data['school_pid'],
            'pid' => public_id()
        ];
        try {
           return StudentClass::updateOrCreate($dupParams, $data);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
        }
    }
}
