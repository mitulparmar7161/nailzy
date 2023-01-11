<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class service_image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'service_id',
        'image',
        
    ];
}
