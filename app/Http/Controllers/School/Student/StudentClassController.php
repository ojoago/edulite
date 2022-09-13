<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\School\Student\StudentClass;


class StudentClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
}
