<?php

namespace App\Models\School\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','pid','firstname','lastname','state','lga','dob','gender','religion','passport','address', 'admission_number',
        'contact_person','gsm','email','status','session_pid','category_pid','class_pid','arm_pid','term_pid','staff_pid',
        'contact_person','contact_gsm','contact_email','username', 'parent_pid','fullname', 'admission_pid'
    ];

    public function setUsernameAttribute($value){
        $this->attributes['username'] = strtolower(str_replace(' ','',$value));
    }
    public function setEmailAttribute($value){
        $this->attributes['email'] = strtolower($value);
    }
}
