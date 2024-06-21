<?php

namespace App\Http\Controllers\School\Framework\Result;

use App\Http\Controllers\Controller;
use App\Models\School\Framework\Class\Category;

class ResultConfigController extends Controller
{
    //
    public function index(){
        $files = [];
        $dir = public_path("/files/result-template/");
        $images = glob($dir. "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        foreach ($images as $file) {
            $pathInfo = pathinfo($file);
            $files[] = [
                'name' => $pathInfo['filename'],
                'path' => '/files/result-template/'. $pathInfo['filename'].'.'. $pathInfo['extension'],
            ];
        }
        $categories = Category::where('school_pid',getSchoolPid())->get(["pid","category"]);
        return view('school.framework.result.result-config',compact('categories','files'));
    }
}
