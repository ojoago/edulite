<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassInvoiceParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','session_pid','term_pid','arm_pid','pid'
    ];
}
