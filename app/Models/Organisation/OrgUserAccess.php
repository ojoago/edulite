<?php

namespace App\Models\Organisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgUserAccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'org_user_pid','access'
    ];
}
