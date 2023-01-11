<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class availability extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'salon_id',
        'day',
        'start_time',
        'end_time',
        
    ];
}
