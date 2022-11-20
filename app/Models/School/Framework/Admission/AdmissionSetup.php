<?php

namespace App\Models\School\Framework\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionSetup extends Model
{
    use HasFactory;
    protected $fillable =[
        'admission_pid','class_pid','amount','school_pid'
    ];
}
