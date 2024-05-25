<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_pid','firstname','lastname','othername','fullname',
        'address','dob','gender','religion','title','state','lga', 'about'
    ];


    protected function firstname(): Attribute
    {
        return new Attribute(
            set: fn ($value) => ucfirst(strtolower($value))
        );
    }
    protected function lastname(): Attribute
    {
        return new Attribute(
            set: fn ($value) => ucfirst(strtolower($value))
        );
    }
    protected function othername(): Attribute
    {
        return new Attribute(
            set: fn ($value) => ucfirst(strtolower($value))
        );
    }
    
}
