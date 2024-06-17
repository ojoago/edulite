<?php

namespace App\Http\Controllers\School\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\SchoolController;

class UploadParentController extends Controller
{
    // private $pwd = 1243657;
    private $header = ['firstname','surname','othername','gsm','username','email','address','religion','gender'];
    public function importParent(Request $request){
        $validator = Validator::make(
            $request->all(),
            ['file' => 'required|file|mimes:xlsx,xls,csv|max:30|min:9'],
            ['file.max' => 'Please do not upload more than 100 recored at a time']
        );
        if (!$validator->fails()) {
            try {
                $path = $request->file('file')->getRealPath();
                // $resource = maatWay(model:new SchoolParent,path:$path);
                $resource = phpWay($path);
                $header = $resource['header'];
                $data = $resource['data'];
                $errors = [];
                $k = 2;
                if ((($header === $this->header))) {
                    $n=0;
                    foreach ($data as $row) {
                        if (!empty($row[0]) && !empty($row[1]) && !empty($row[3])) {
                            $username = $row[4] ?? '';
                            if (!AuthController::findGsm($row[3])) {
                                $data = [
                                    'gsm' => ($row[3]),
                                    // 'email' => AuthController::findEmail($username) ? null : $username,
                                    'account_status' => 1,
                                    'password' => DEFAULT_PASSWORD,
                                    'username' =>  $username ? AuthController::uniqueUsername($username) : AuthController::uniqueUsername($row[0]),
                                ];
                                if ($row[5]) {
                                    $data['email'] = AuthController::findEmail($row[5]) ? null : $row[5];
                                }
                                $user = AuthController::createUser($data);
                                if($user){
                                    // dd($user, $data);
                                    $userDetail = [
                                        'firstname' => $row[0],
                                        'lastname' => $row[1],
                                        'othername' => $row[2],
                                        'gender' => GENDER[(int) $row[8]],
                                        'dob' => $row[3],
                                        'religion' => RELIGION[(int) $row[7]],
                                        'state' => null,
                                        'lga' => null,
                                        'address' => $row[6],
                                        'user_pid' => $user->pid
                                    ];
                                    $parent = [
                                        'user_pid' => $user->pid,
                                        'school_pid' => getSchoolPid(),
                                        'pid' => public_id(),
                                    ];
                                    $dtl = UserDetailsController::insertUserDetails($userDetail);
                                    if($dtl){
                                        $sts = SchoolController::createSchoolParent($parent);
                                        if ($sts) {
                                            $n++;
                                        }else{
                                            $errors[] = 'Parent on row ' . $k . ' not linked to school';
                                        }
                                    }else{

                                        $errors[] = 'parent on row ' . $k . ' partially created use edit to completed it please';
                                    }
                                }else{

                                    $errors[] = 'parent on row ' . $k . ' not inserted';
                                }
                            } else {
                                $errors[] = 'Parent on row ' . $k . ' not inserted because, Phone number already exists';
                            }
                        } else {
                            $errors[] = 'Parent on row ' . $k . ' not inserted because of either firstname, surname or gsm is empty';
                        }
                        $k++;
                    }
                    $msg = $n . ' parent(s) uploaded successfully... & ' . count($errors) . ' error(s)';
                    return response()->json(['status' => 1, 'message' => $msg, 'errors' => $errors]);
                }
                return response()->json(['status' => 'error', 'message' => 'use the template without change it please.']);
            } catch (\Throwable $e) {
                $error = ['error' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__];
                logError($error);
                return response()->json(['status' => 'error', 'message' => 'upload stop on row ' . $k, 'errors' => $errors]);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }
}
