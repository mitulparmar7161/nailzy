<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id',
        'day',
        'start_time',
        'end_time',
        
    ];
}
