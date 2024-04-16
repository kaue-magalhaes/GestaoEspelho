<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoUrgenciaAtendimento extends Model
{
    use HasFactory;

    protected $table = 'historico_urgencia_atendimentos';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
        'historico_promotor_designado_id',
        'historico_id',
    ];

    /**
     * Get the promotor titular of the HistoricoUrgenciaAtendimento
     */
    public function promotor(): BelongsTo
    {
        return $this->belongsTo(HistoricoPromotor::class);
    }
}
