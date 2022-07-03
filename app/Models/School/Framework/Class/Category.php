<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid', 'school_pid', 'category', 'staff_pid','description'
    ];
}
