<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalSystemNivel extends Model
{
    use HasFactory;

    protected $fillable = [
        'sistema',
        'nivel',
    ];

    protected $table = 'internal_system_nivels';
}
