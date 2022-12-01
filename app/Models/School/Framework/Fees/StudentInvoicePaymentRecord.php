<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInvoicePaymentRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','amount','generated_by','invoice_pid','received_by','channel','code'
    ];
}
