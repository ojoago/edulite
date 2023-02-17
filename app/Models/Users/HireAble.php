<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HireAble extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_pid','qualification','course','status','state','lga','area','subjects','years'
    ];

}
