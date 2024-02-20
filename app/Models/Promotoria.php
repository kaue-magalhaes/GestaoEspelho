<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotoria extends Model
{
    use HasFactory;
    protected $table = 'promotorias';

    protected $fillable = [
        'nome',
        'promotor_id',
    ];

    public function promotor()
    {
        return $this->belongsTo(Promotor::class);
    }
}
