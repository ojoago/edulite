<?php

namespace App\Http\Controllers\School\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\SchoolStaff;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Staff\StaffController;
use Illuminate\Support\Facades\Validator;

class UploadStaffController extends Controller
{
    private $pwd = 1234567;
    private $header = ['firstname', 'surname', 'othername', 'gsm', 'dob', 'username', 'email', 'address', 'religion', 'gender'];
    public function importStaff(Request $request){
        $validator = Validator::make($request->all(),
                                ['file'=>'required|file|mimes:xlsx,xls,csv|max:30|min:9'],['filemax'=>'Please do not upload more than 100 recored at a time']);
        if(!$validator->fails()){
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
                        if (!empty($row[0]) && !empty($row[1]) && !empty($row[3])) {
                            $username = $row[6] ?? '';
                            if (!AuthController::findGsm($row[3])) {
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
                                $dtl = UserDetailsController::insertUserDetails($detail);
                               if($dtl){
                                    $staff = [
                                        'role' => 300,
                                        'user_pid' => $user->pid,
                                        'staff_id' => StaffController::staffUniqueId()
                                    ];
                                    $sts = StaffController::registerStaffToSchool($staff);
                                    if (!$sts) {
                                        $errors[] = 'Staff on row ' . $k . ' not Linked to School';
                                    }
                               }else{
                                    $errors[] = 'Staff on row ' . $k . ' partially created use edit to completed it please';

                               }
                            } else {
                                $errors[] = 'Staff on row ' . $k . ' not inserted because, Phone number already exists';
                            }
                        } else {
                            $errors[] = 'Staff on row ' . $k . ' not inserted because of either firstname, surname or gsm is empty';
                        }
                        $k++;
                    }
                    $msg = $k - count($errors) . ' Staff uploaded successfully';
                    return response()->json(['status'=>1,'message'=>$msg,'errors'=>$errors]);
                }
                return response()->json(['status'=>'error','message'=>'use the template without change it please.']);
            
            } catch (\Throwable $e) {
                $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];

                logError($error);
                return response()->json(['status' => 'error', 'message' => 'upload stop on row ' . $k,'errors'=>$errors]);
            }
        }
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }

    private function lazyLoop($data): \Generator
    { 
        
        foreach($data as $i => $row){
            // if($i==$limit) break;
            yield $row;
        }
    }

    
        
}