<?php

namespace App\Models\Organisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;
    protected $fillable = ['user_pid','names','pid','reg_number','state_id'];
}
