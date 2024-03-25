<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoEvento extends Model
{
    use HasFactory;

    protected $table = 'historico_eventos';

    protected $fillable = [
        'titulo',
        'tipo',
        'periodo_inicio',
        'periodo_fim',
        'promotor_titular_id',
        'promotor_designado_id',
        'historico_id',
    ];
}
