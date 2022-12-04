<?php

namespace App\Models\School\Framework\Comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalComment extends Model
{
    use HasFactory;
    protected $fillable = ['school_pid','min','max','comment','principal_pid','category_pid'];
}
