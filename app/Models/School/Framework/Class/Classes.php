<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid','staff_pid','class','category_pid','school_pid', 'class_number'
    ];

    public function setClassAttribute($value){
        $this->attributes['class'] = strtoupper($value);
    }
    public function classArms()
    {
        return $this->hasMany(ClassArm::class, 'class_pid', 'pid');
    }
}
