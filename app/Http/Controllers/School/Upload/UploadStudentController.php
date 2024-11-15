<?php

namespace App\Http\Controllers\School\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Student\StudentController;
use App\Models\School\Student\Student;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
class UploadStudentController extends Controller
{
    // private $pwd = 1234567;
    private $header = ['firstname', 'surname', 'othername', 'gsm', 'dob', 'username', 'email', 'address', 'religion', 'gender','type'];
    public function importStudent(Request $request)
    {
        // logError($request->all());
        $k = 0;
        $validator = Validator::make(
            $request->all(),
            ['file' => 'required|file|mimes:xlsx,xls,csv|max:30|min:9',
                // 'session_pid' => 'required|string',
                // 'term_pid' => 'required|string',
                'category_pid' => 'required|string',
                'class_pid' => 'required|string',
                'arm_pid' => 'required|string',
            ],
            [
                'file.max' => 'Please do not upload more than 100 recored at a time',
                'address.required' => 'Enter Student Residence Address',
                // 'type.required' => 'Select Student Type',
                // 'session_pid.required_without' => 'Select Session for Student',
                // 'term_pid.required_without' => 'Select Term for Student',
                'category_pid.required_without' => 'Select Category for Student',
                'class_pid.required_without' => 'Select Class for Student',
                'arm_pid.required_without' => 'Select Class Arm for Student',
                ]
        );
        if (!$validator->fails()) {
            $errors = [];
            try {
                $path = $request->file('file');//->getRealPath();
                $resource = maatWay(model:new Student,path:$path);
                // $resource = phpWay($path);
                $header = $resource['header'];
                $data = $resource['data'];
                $k = 2;$n=0;
                if ((($header === $this->header))) {
                    foreach ($data as $row) {
                        if (!empty($row[0]) && !empty($row[1])) {
                            if (isset($row[4])) {
                                $dob = $row[4];
                                $dob = ExcelDate::excelToDateTimeObject($dob);
                                $dob = $dob->format('Y-m-d'); // Format as needed
                            } else {
                                $dob = null;
                            }
                               
                            $username = $row[6] ?? '';
                            $email = $row[5] ?? '';
                            $gsm = $row[3] =='' ? false : AuthController::findGsm($row[3]);
                            if (!$gsm) {
                                $data = [
                                    'gsm' => ($row[3]),
                                    // 'email' => AuthController::findEmail($username) ? null : $username,
                                    'account_status' => 1,
                                    'password' => DEFAULT_PASSWORD ,
                                    'username' =>  $username ? AuthController::uniqueUsername($username) : AuthController::uniqueUsername($row[0]),
                                ];
                                if($email){
                                    $data['email'] = AuthController::findEmail($email) ? null : $email;
                                }
                                DB::beginTransaction();

                                $user = AuthController::createUser($data);
                                $detail = [
                                    'firstname' => $row[0],
                                    'lastname' => $row[1],
                                    'othername' => $row[2],
                                    'gender' => (int) $row[9],
                                    'dob' => $dob,
                                    'religion' => (int) $row[8],
                                    'state' => null,
                                    'lga' => null,
                                    'address' => $row[7],
                                    'title' => null,
                                    'user_pid' => $user->pid
                                ];
                                $student = [
                                    'gender' => GENDER[(int) $row[9]],
                                    'dob' => $dob,
                                    'religion' => RELIGION[(int) $row[8]],
                                    'state' => null,
                                    'lga' => null,
                                    'address' => $row[7],
                                    'type' => $row[10] ?? 1,
                                    'pid' => public_id(),
                                    'staff_pid' => getSchoolUserPid(),
                                    'school_pid' => getSchoolPid(),
                                    'user_pid' => $user->pid,
                                    'reg_number' =>  StudentController::studentUniqueId(),
                                    'session_pid' =>  activeSession(),
                                    'term_pid' =>  activeTerm(),
                                    'admitted_class' =>  $request->arm_pid,
                                    'current_class_pid' =>  $request->arm_pid,
                                    'current_session_pid' => activeSession(),
                                ];
                                $userDetails = UserDetailsController::insertUserDetails($detail);
                                
                                if ($userDetails) {
                                    $student['fullname'] = trim($detail['lastname'].' '. $detail['firstname'].' '. $detail['othername']); //get student fullname and save along with student info
                                    $studentClass = [
                                        'session_pid' => activeSession(),
                                        'arm_pid' => $request->arm_pid,
                                        'school_pid' => $student['school_pid'],
                                        'staff_pid' => getSchoolUserPid(),
                                    ];
                                    
                                    $studentDetails = SchoolController::createSchoolStudent($student);
                                    if ($studentDetails) {
                                        $studentClass['student_pid'] = $studentDetails->pid;
                                        StudentController::createStudentClassRecord($studentClass);
                                        $n++;
                                    DB::commit();

                                    }else{
                                        $errors[] = 'Student on row ' . $k . ' not Linked to School';
                                        DB::rollBack();
                                    }
                                } else {
                                    $errors[] = 'Student on row ' . $k . ' partially created use edit to completed it please';
                                }
                            } else {
                                $errors[] = 'Student on row ' . $k . ' not inserted because, Phone number already exists';
                            }
                        } else {
                            $errors[] = 'Student on row ' . $k . ' not inserted because of either firstname, surname or gsm is empty';
                        }
                       $k++;
                    }
                    $msg = $n. ' Student(s) uploaded successfully... & '.count($errors).' error(s)';
                    return response()->json(['status' => 1, 'message' => $msg, 'errors' => $errors]);
                }
                return response()->json(['status' => 'error', 'message' => 'use the template without change it please.']);
            } catch (\Throwable $e) {
                logError(['error'=>$e->getMessage(),'file'=> __FILE__]);
                return response()->json(['status' => 'error', 'message' => 'upload stop on row ' . $k, 'errors' => $errors]);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

}
