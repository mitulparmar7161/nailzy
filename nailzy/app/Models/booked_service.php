<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booked_service extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'service_id',
        'price',
        
    ];
}
