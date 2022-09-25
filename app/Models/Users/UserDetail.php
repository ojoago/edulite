<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_pid','firstname','lastname','othername','fullname',
        'address','dob','gender','religion','title','state','lga', 'about'
    ];

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucfirst(strtolower($value));
    }
    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucfirst(strtolower($value));
    }
    public function setOthernameAttribute($value)
    {
        $this->attributes['othername'] = ucfirst(strtolower($value));
    }
    // public function setFullnameAttribute()
    // {
    //     return $this->attributes['fullname'] = ucwords(trim($this->attributes['lastname'] . ' ' . $this->attributes['firstname'] . ' ' . $this->attributes['othername']));
    // }
}
