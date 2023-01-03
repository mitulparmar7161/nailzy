<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'employee_id',
        'employee_comment',
        'employee_rating',
    ];
}
