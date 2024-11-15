<?php

namespace App\Http\Controllers\School\Framework\Result;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Framework\Class\Category;
use App\Models\School\Framework\Result\ResultConfig;

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

        $categories = DB::table('categories as c')->leftJoin('result_configs as r','r.category_pid','c.pid')->where('c.school_pid',getSchoolPid())->orderBy('id')->get(["pid","category","r.*"]);
        
        // $categories = Category::where('school_pid',getSchoolPid())->orderBy('id')->get(["pid","category"]);
        return view('school.framework.result.result-config',compact('categories','files'));
    }

    public function saveTemplate(Request $request){
        $validator = Validator::make($request->all(), [
            'template' => 'required'
        ]);
        if (!$validator->fails()) {
            try {
                $temp = $request->template;
                $cat = $request->$temp;
                $config = ResultConfig::where(['school_pid' => getSchoolPid() , 'category_pid' => $cat ])->first();
                if($config){
                    $config->file_name = $temp;
                    $result = $config->save();
                }else{
                    $data = [
                        'sub_dir' => getSchoolCode(). '.' ,
                        'school_pid' => getSchoolPid() ,
                        'file_name' => $temp ,
                        'category_pid' => $cat ,
                    ];
                    $result = ResultConfig::create($data);
                }
                if ($result) {
                    return response()->json(['status' => 1, 'message' => $temp.' Template Saved' ]);
                }
                return response()->json(['status' => 2, 'message' => 'Failed to save Template']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong... error logged']);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray(),'message'=>'Select a Template']);
    }

    public function saveConfig(Request $request){
        // logError($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|max:50' ,
            'student_name' => 'nullable|max:50' ,
            'head_teacher' => 'nullable|max:50' ,
            'class_teacher' => 'nullable|max:50' ,
        ]);
        if (!$validator->fails()) {
            try {

                
                $config = [
                    'show_chart' => $request->show_chart ? 1 : 0 ,
                    'serial_number'  => $request->serial_number ? 1 : 0 ,
                    'class_position'  => $request->class_position ? 1 : 0 ,
                    'subject_position'  => $request->subject_position ? 1 : 0 ,
                    'subject_grade'  => $request->subject_grade ? 1 : 0 ,
                    'remark'  => $request->remark ? 1 : 0 ,
                    'subject_teacher'  => $request->subject_teacher ? 1 : 0 ,
                    'subject_average'  => $request->subject_average ? 1 : 0 ,
                    'chart'  => $request->chart ,
                    'pass_mark'  => $request->pass_mark ?? 40 ,
                ];
                $data = [
                    'school_pid' => getSchoolPid() ,
                    'category_pid' => $request->category ,
                    'title' => strtoupper($request->title) ,
                    'subject_type' => strtoupper($request->subject_type) ,
                    'student_name' => strtoupper($request->student_name) ,
                    'head_teacher' => strtoupper($request->head_teacher) ,
                    'class_teacher' => strtoupper($request->class_teacher) ,
                    'settings' => json_encode($config)
                ];

                $result = ResultConfig::updateOrCreate(['school_pid' => $data['school_pid'] , 'category_pid' => $data['category_pid'] ],$data);
                if ($result) {
                    return response()->json(['status' => 1, 'message' =>  'Configuartion Saved']);
                }
                return response()->json(['status' => 2, 'message' => 'Failed to save Configuartion']);
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Something Went Wrong... error logged']);
            }
        }

        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

    
}
