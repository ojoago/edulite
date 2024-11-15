<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeConfiguration extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','fee_item_pid','category','gender','religion','pid','type', 'payment_model'
    ];
}
