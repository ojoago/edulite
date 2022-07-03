<?php

namespace App\Models\Organisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisationUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'org_pid', 'user_pid','pid'
    ];
}
