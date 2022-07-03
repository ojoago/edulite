<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'state_id','lga_id','school_name','school_contact','school_address',
        'school_moto','school_handle','pid','user_pid','role_id'
    ];
}
