<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassArm extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid','school_pid','arm','class_pid','staff_pid', 'arm_number'
    ];
    
    public function setArmAttribute($value){
        $this->attributes['arm'] = strtoupper(trim($value));
    }
}
