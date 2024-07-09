<?php

namespace App\Http\Controllers\School\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Users\UserDetailsController;
use App\Http\Controllers\School\Rider\RiderController;
use App\Models\School\Rider\SchoolRider;

class UploadRiderController extends Controller
{
    // private $pwd = 123456;
    private $header = ['firstname', 'surname', 'othername', 'gsm', 'username', 'email', 'address', 'religion', 'gender'];
    public function importRider(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            ['file' => 'required|file|mimes:xlsx,xls,csv|max:20|min:9'],
            ['file.max' => 'Please do not upload more than 100 recored at a time']
        );
        if (!$validator->fails()) {
            $k = 0;
            $errors = [];
            try {
                $path = $request->file('file');//->getRealPath();
                $resource = maatWay(model:new SchoolRider,path:$path);
                $resource = phpWay($path);
                $header = $resource['header'];
                $data = $resource['data'];
                if ((($header === $this->header))) {
                    foreach ($data as $row) {
                        if (!empty($row[0]) && !empty($row[1]) && !empty($row[3])) {
                            $username = $row[5] ?? '';
                            if (!AuthController::findGsm($row[3])) {
                                $data = [
                                    'gsm' => ($row[3]),
                                    'email' => AuthController::findEmail($username) ? null : $username,
                                    'account_status' => 1,
                                    'password' => DEFAULT_PASSWORD,
                                    'username' =>  $username ? AuthController::uniqueUsername($username) : AuthController::uniqueUsername($row[0]),
                                ];
                                DB::beginTransaction(); 
                                $user = AuthController::createUser($data);
                                if ($user) {
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
                                    $rider = [
                                        'user_pid' => $user->pid,
                                        'school_pid' => getSchoolPid(),
                                        'pid' => public_id(),
                                        'rider_id' => RiderController::riderUniqueId()
                                    ];
                                    $dtl = UserDetailsController::insertUserDetails($userDetail);
                                    if ($dtl) {
                                        $sts = SchoolController::createSchoolRider($rider);
                                        if ($sts) {
                                            DB::commit();
                                        }else{
                                            DB::rollBack();
                                            $errors[] = 'Rider/Care on row ' . $k . ' Not inserted';
                                        }
                                        $k++;
                                    } else {
                                        DB::rollBack();

                                        $errors[] = 'Rider/care on row ' . $k . ' Not inserted';
                                    }
                                } else {
                                    DB::rollBack();

                                    $errors[] = 'Rider/care on row ' . $k . ' not inserted';
                                }
                            } else {
                                DB::rollBack();

                                $errors[] = 'Rider/Care on row ' . $k . ' not inserted because, Phone number already exists';
                            }
                        } else {
                            DB::rollBack();

                            $errors[] = 'Rider on row ' . $k . ' not inserted because of either firstname, surname or gsm is empty';
                        }
                    }
                    $msg = $k - count($errors) . ' record(s) uploaded successfully';
                    return response()->json(['status' => 1, 'message' => $msg, 'errors' => $errors]);
                }
                return response()->json(['status' => 'error', 'message' => 'use the template without change it please.']);
            } catch (\Throwable $e) {
                $error = ['message' => $e->getMessage(), 'file' => __FILE__, 'line' => __LINE__, 'code' => $e->getCode()];
                DB::rollBack();

                logError($error);
                return response()->json(['status' => 'error', 'message' => 'upload stop on row ' . $k, 'errors' => $errors]);
            }
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    }
}
