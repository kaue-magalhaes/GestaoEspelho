<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read string $id
 * @property-read string $titulo
 * @property-read string $tipo
 * @property-read string $periodo_inicio
 * @property-read string $periodo_fim
 * @property-read string $promotor_titular_id
 * @property-read string $promotor_designado_id
 */
class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'tipo',
        'periodo_inicio',
        'periodo_fim',
        'promotor_titular_id',
        'promotor_designado_id',
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
    public function getPromotorTitularIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * Converte o id do promotor designado para string
     */
    public function getPromotorDesignadoIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * Busca o promotor titular do evento
     */
    public function promotorTitular(): BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }

    /**
     * Busca o promotor designado para o evento
     */
    public function promotorDesignado(): BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }
}
