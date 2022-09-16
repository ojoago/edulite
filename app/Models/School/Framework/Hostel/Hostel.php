<?php

namespace App\Models\School\Framework\Hostel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','name','pid','capacity','location','staff_pid'
    ];
    public function setNameAttribute($value){
        $this->attributes['name'] = strtoupper(trim($value));
    }
}
