<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'state','lga','school_name','school_contact','school_address', 'school_logo',
        'school_moto','school_handle','pid','user_pid', 'school_email','type', 'school_code'
    ];
    
    public function setSchoolNameAttribute($vaule){
        $this->attributes['school_name'] = ucwords(strtolower($vaule));
    }
}
