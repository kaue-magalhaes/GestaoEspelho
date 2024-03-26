<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPromotoria extends Model
{
    use HasFactory;

    protected $table = 'historico_promotorias';

    protected $fillable = [
        'nome',
        'nome_grupo_promotorias',
        'municipio',
        'is_especializada',
        'historico_espelho_id',
        'historico_promotor_titular_id',
        'historico_id',
    ];
}
