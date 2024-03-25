<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoUrgenciaAtendimento extends Model
{
    use HasFactory;

    protected $table = 'historico_urgencia_atendimentos';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
        'promotor_designado_id',
        'historico_id',
    ];
}
