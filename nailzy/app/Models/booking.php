<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'salon_id',
        'employee_id',
        'customer_id',
        'booking_date',
        'timeslot_start',
        'timeslot_end',
        'billing_cost',
        'booking_status',
        'booking_remark',
    ];
}
