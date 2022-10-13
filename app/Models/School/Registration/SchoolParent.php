<?php

namespace App\Models\School\Registration;

use App\Models\School\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolParent extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_pid','school_pid','pid','parent_image_path'
    ];


    public function wardCount()
    {
        return $this->hasMany(Student::class, 'parent_pid', 'pid')->where('school_pid',getSchoolPid())->count();
    }
}
