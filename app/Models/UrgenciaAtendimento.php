<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Converte o id para string
     */
    public function getIdAttribute(int $value): string
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
     * Busca o promotor designado para a urgência
     */
    public function promotor(): BelongsTo
    {
        return $this->belongsTo(Promotor::class, 'promotor_designado_id');
    }
}
