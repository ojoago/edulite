<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_name','school_pid','pid','fee_description','status', 'staff_pid', 'account_pid'
    ];

    public function feeName() : Attribute
    {
        return new Attribute(
            set:fn($value) => strtoupper($value)
        );
    }
}
