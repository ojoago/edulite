<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','student_pid','invoice_pid','pid','status'
    ];
}
