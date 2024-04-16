<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoEvento extends Model
{
    use HasFactory;

    protected $table = 'historico_eventos';

    protected $fillable = [
        'titulo',
        'tipo',
        'periodo_inicio',
        'periodo_fim',
        'historico_promotor_titular_id',
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
     * Converte o id do promotor titular para string
     */
    public function getHistoricoPromotorTitularIdAttribute(int $value): string
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
     * Get the promotorTitular of the HistoricoEvento
     */
    public function promotorTitular(): BelongsTo
    {
        return $this->belongsTo(HistoricoPromotor::class, 'historico_promotor_titular_id');
    }

    /**
     * Get the promotorDesignado of the HistoricoEvento
     */
    public function promotorDesignado(): BelongsTo
    {
        return $this->belongsTo(HistoricoPromotor::class, 'historico_promotor_designado_id');
    }
}
