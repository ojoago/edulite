<?php

namespace App\Models\School\Framework\Comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormMasterComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','min','max','comment','teacher_pid','category_pid', 'title'
    ];
}
