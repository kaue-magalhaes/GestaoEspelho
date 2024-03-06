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
     * Converte o id para string
     * @param $value
     * @return string
     */
    public function getIdAttribute($value)
    {
        return (string)$value;
    }

    /**
     * Converte o id do promotor designado para string
     * @param $value
     * @return string
     */
    public function getPromotorDesignadoIdAttribute($value)
    {
        return (string)$value;
    }

    /**
     * Busca o promotor designado para a urgência
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }
}
