<?php

namespace App\Models\School\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_students' , 'fee' , 'discount' , 'amount' , 'term' , 'session' , 'classes' , 'school_pid'
    ];
}
