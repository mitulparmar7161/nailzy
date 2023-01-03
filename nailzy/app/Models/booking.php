<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    use HasFactory;

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
