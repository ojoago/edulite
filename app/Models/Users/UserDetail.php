<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_pid','firstname','lastname','othername','fullname',
        'address','dob','gender','religion','title','state','lga'
    ];

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = strtoupper($value);
    }
    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = strtoupper($value);
    }
    public function setOthernameAttribute($value)
    {
        $this->attributes['othername'] = strtoupper($value);
    }
}
