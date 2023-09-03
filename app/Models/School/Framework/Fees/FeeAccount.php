<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','pid','bank_name','account_number','account_name', 'bank_code'
    ];
}
