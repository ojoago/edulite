<?php

namespace App\Http\Controllers\School\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\School\Staff\SchoolStaff;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Staff\StaffController;

class UploadStaffController extends Controller
{
    // private $pwd = 1234567;
    private $header = ['firstname', 'surname', 'othername', 'gsm', 'dob', 'username', 'email', 'address', 'religion', 'gender'];
    public function importStaff(Request $request){
        $validator = Validator::make($request->all(),
                                ['file'=>'required|file|mimes:xlsx,xls,csv|max:30|min:9'],['filemax'=>'Please do not upload more than 100 recored at a time']);
        if(!$validator->fails()){
            try {
                $k = 0;
                $path = $request->file('file')->getRealPath();
                // $resource = maatWay(model:new SchoolStaff,path:$path);
                $resource = phpWay($path);
                $header = $resource['header'];
                $data = $resource['data'];
                $errors = [];
                $k = 2;
                if ((($header === $this->header))) {
                    $n = 0;
                    foreach ($data as $row) {
                        if (!empty($row[0]) && !empty($row[1]) && !empty($row[3])) {
                            $username = $row[5] ?? null;
                            if (!AuthController::findGsm($row[3])) {
                                $data = [
                                    'gsm' => ($row[3]),
                                    // 'email' => AuthController::findEmail($username) ? null : $username,
                                    'account_status' => 1,
                                    'password' => DEFAULT_PASSWORD,
                                    'username' =>  $username ? AuthController::uniqueUsername($username) : AuthController::uniqueUsername($row[0]),
                                ];
                                if($row[5]){
                                    $data['email'] = AuthController::findEmail($row[5]) ? null : $row[5];
                                }
                                DB::beginTransaction();
                                $user = AuthController::createUser($data);
                                // dd($user, $data);
                                $detail = [
                                    'firstname' => $row[0],
                                    'lastname' => $row[1],
                                    'othername' => $row[2],
                                    'gender' => GENDER[(int) $row[9]],
                                    'dob' => $row[4],
                                    'religion' => RELIGION[(int) $row[8]],
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
                                    $sts = SchoolController::createSchoolStaff($staff);
                                    if ($sts) {
                                        $n++;
                                        DB::commit();
                                    }else{
                                        DB::rollBack();
                                        $errors[] = 'Staff on row ' . $k . ' not Created';
                                    }
                                }else{
                                DB::rollBack();
                                    $errors[] = 'Staff on row ' . $k . ' Not created';
                                }
                            } else {
                            DB::rollBack();
                                $errors[] = 'Staff on row ' . $k . ' not inserted because, Phone number already exists';
                            }
                        } else {
                        DB::rollBack();
                            $errors[] = 'Staff on row ' . $k . ' not inserted because of either firstname, surname or gsm is empty';
                        }
                        $k++;
                        
                    }
                    $msg = $n . ' Staff uploaded successfully... & ' . count($errors) . ' error(s)';
                    return response()->json(['status'=>1,'message'=>$msg,'errors'=>$errors]);
                }
                return response()->json(['status'=>'error','message'=>'use the template without change it please.']);
            
            } catch (\Throwable $e) {
                $error = ['error' => $e->getMessage(), 'file' => __FILE__];

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
