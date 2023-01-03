<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salon_review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'salon_id',
        'salon_comment',
        'salon_rating',
    ];
}
