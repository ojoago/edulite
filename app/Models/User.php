<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\Auths\AuthController;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'pid',
        'email',
        'password',
        'gsm',
        'account_status',
        'reset_token',
        'code'
    ];
    // public function setPasswordAttribute($value){
    //     $this->attributes['password'] = Hash::make($value);
    // }
    // public function setUsernameAttribute($value){
    //     $this->attributes['username'] = strtolower(str_replace('-','_',str_replace(' ','',trim($value))));
    // }

    // public function setEmailAttribute($value){
    //     $this->attributes['email'] = Hash::make($value);
    // }

    protected function password(): Attribute
    {
        return new Attribute(
            set:fn ($val) => Hash::make($val),
        );
    }
    protected function username(): Attribute
    {
        return new Attribute(
            set:fn ($val) => strtolower(str_replace('-', '_', str_replace(' ', '_', trim($val)))),
        );
    }
    protected function email(): Attribute
    {
        return new Attribute(
            set:fn ($val) => str_replace(' ','_',strtolower($val)),
        );
    }


    // public function setCodeAttribute($value){
    //     $this->attributes['code'] = strtoupper(AuthController::referrerCode());
    // }

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
