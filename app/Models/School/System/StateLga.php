<?php

namespace App\Models\School\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateLga extends Model
{
    use HasFactory;
    protected $fillable = ['state_id','lga'];
}
