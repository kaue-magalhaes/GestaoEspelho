<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;

    protected $table = 'historicos';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
    ];
}
