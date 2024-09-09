<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid', 'school_pid', 'category', 'staff_pid','description','head_pid','number'
    ];

    public function setCategoryAttribute($value){
        $this->attributes['category'] = strtoupper(trim($value));
    }

    public function categoryClass()
    {
        return $this->hasMany(Classes::class, 'category_pid', 'pid');
    }
}
