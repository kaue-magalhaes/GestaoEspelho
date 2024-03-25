<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoEspelho extends Model
{
    use HasFactory;

    protected $table = 'historico_espelhos';

    protected $fillable = [
        'periodo_inicio', 
        'periodo_fim',
        'historico_id',
    ];
}
