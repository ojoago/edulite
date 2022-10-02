<?php

namespace App\Http\Controllers\School\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\Users\UserDetailsController;

class UploadStudentController extends Controller
{
    private $pwd = 1234567;
    private $header = ['firstname', 'surname', 'othername', 'gsm', 'dob', 'username', 'email', 'address', 'religion', 'gender','type'];
    public function importStudent(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['file' => 'required|file|mimes:xlsx,xls,csv|max:30|min:9',
                'session_pid' => 'required|string',
                'term_pid' => 'required|string',
                'category_pid' => 'required|string',
                'class_pid' => 'required|string',
                'arm_pid' => 'required|string',
            ],
            [
                'file.max' => 'Please do not upload more than 100 recored at a time',
                'address.required' => 'Enter Student Residence Address',
                // 'type.required' => 'Select Student Type',
                'session_pid.required_without' => 'Select Session for Student',
                'term_pid.required_without' => 'Select Term for Student',
                'category_pid.required_without' => 'Select Category for Student',
                'class_pid.required_without' => 'Select Class for Student',
                'arm_pid.required_without' => 'Select Class Arm for Student',
                ]
        );
        if (!$validator->fails()) {
            try {
                $path = $request->file('file')->getRealPath();
                // $resource = maatWay(model:new SchoolStaff,path:$path);
                $resource = phpWay($path);
                $header = $resource['header'];
                $data = $resource['data'];
                $errors = [];
                $k = 1;
                if ((($header === $this->header))) {
                    foreach ($data as $row) {
                        if (!empty($row[0]) && !empty($row[1])) {
                            $username = $row[6] ?? '';
                            $gsm = $row[3]=='' ? false : AuthController::findGsm($row[3]);
                            if (!$gsm) {
                                $data = [
                                    'gsm' => ($row[3]),
                                    'email' => AuthController::findEmail($username) ? null : $username,
                                    'account_status' => 1,
                                    'password' => $this->pwd,
                                    'username' =>  $username ? AuthController::uniqueUsername($username) : AuthController::uniqueUsername($row[0]),
                                ];
                                $user = AuthController::createUser($data);
                                // dd($user, $data);
                                $detail = [
                                    'firstname' => $row[0],
                                    'lastname' => $row[1],
                                    'othername' => $row[2],
                                    'gender' => (int) $row[9],
                                    'dob' => $row[4],
                                    'religion' => (int) $row[8],
                                    'state' => null,
                                    'lga' => null,
                                    'address' => $row[7],
                                    'title' => null,
                                    'user_pid' => $user->pid
                                ];
                                $student = [
                                    'gender' => (int) $row[9],
                                    'dob' => $row[4],
                                    'religion' => (int) $row[8],
                                    'state' => null,
                                    'lga' => null,
                                    'address' => $row[7],
                                    'type' => $request->type ?? 1,
                                    'pid' => public_id(),
                                    'staff_pid' => getSchoolUserPid(),
                                    'school_pid' => getSchoolPid(),
                                    'user_pid' => $user->pid,
                                    'reg_number' =>  StudentController::studentUniqueId(),
                                    'session_pid' =>  $request->session_pid,
                                    'term_pid' =>  $request->term_pid,
                                    'admitted_class' =>  $request->arm_pid,
                                    'current_class' =>  $request->arm_pid,
                                    'current_session_pid' =>  $request->session_pid,
                                ];
                                $userDetails = UserDetailsController::insertUserDetails($detail);
                                if ($userDetails) {
                                    $student['fullname'] = $userDetails->fullname; //get student fullname and save along with student info
                                    $studentClass = [
                                        'session_pid' => $request->session_pid,
                                        'arm_pid' => $request->arm_pid,
                                        'school_pid' => $student['school_pid'],
                                        'staff_pid' => getSchoolUserPid(),
                                    ];
                                    $studentDetails = SchoolController::createSchoolStudent($student);
                                    if (!$studentDetails) {
                                        $studentClass['student_pid'] = $studentDetails->pid;
                                        StudentController::createStudentClassRecord($studentClass);
                                        $errors[] = 'Student on row ' . $k . ' not Linked to School';
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
                    $msg = $k - count($errors) . ' Student(s) uploaded successfully';
                    return response()->json(['status' => 1, 'message' => $msg, 'errors' => $errors]);
                }
                return response()->json(['status' => 'error', 'message' => 'use the template without change it please.']);
            } catch (\Throwable $e) {
                $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];

                logError($error);
                return response()->json(['status' => 'error', 'message' => 'upload stop on row ' . $k, 'errors' => $errors]);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }

}
