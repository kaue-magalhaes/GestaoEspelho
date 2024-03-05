<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrgenciaAtendimento extends Model
{
    use HasFactory;

    protected $table = 'urgencia_atendimentos';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
        'promotor_designado_id',
    ];

    /**
     * Busca o promotor designado para a urgência
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }
}
