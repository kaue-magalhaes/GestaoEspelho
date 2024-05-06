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
     * Converte o id para string
     */
    public function getIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * Converte o id do promotor designado para string
     */
    public function getHistoricoPromotorDesignadoIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * Get the promotor titular of the HistoricoUrgenciaAtendimento
     */
    public function promotor(): BelongsTo
    {
        return $this->belongsTo(HistoricoPromotor::class, 'historico_promotor_designado_id');
    }
}
