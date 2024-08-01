<?php

namespace App\Models\School\Payment;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_students' , 'fee' , 'discount' , 'amount' , 'term' , 'session' , 'classes' , 'school_pid', 'term_pid' , 'session_pid'
    ];

    protected function classes(): Attribute
    {
        return new Attribute(
            set:fn($value)  => json_encode($value) ,
            get:fn($value)  => json_decode($value) ,
    );
    }
}
