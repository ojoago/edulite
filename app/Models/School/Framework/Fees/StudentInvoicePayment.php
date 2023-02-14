<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInvoicePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','pid','invoice_number','total','amount_paid','status','generated_by','code', 'student_pid'
    ];


    public function student(){

    }

    public function items(){
        return $this->hasMany(StudentInvoice::class, 'psychomotor_pid', 'pid');
    }
}
