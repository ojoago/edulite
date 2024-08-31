<?php

namespace App\Models\School\Staff;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_pid','session_pid', 'term_pid','status','school_pid','path','platform','device','browser','address','cordinates','late' ,'clock_in' ,'clock_out'
    ];

    private $status = ['Absent' , 'Present'];

    protected function cordinates(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ? json_decode($value) : null,
            set: fn($value) => $value ? json_encode($value) : null
        );
    }

    protected function clockIn(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ? formatDateTime($value) : null
        );
    }

    protected function clockOut(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ? formatDateTime($value) : null
        );
    }

    protected function status(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->status[$value]
        );
    }

    protected function path(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ? URL::to($value) : null
        );
    }


}
