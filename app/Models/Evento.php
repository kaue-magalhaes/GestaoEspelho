<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     *
     * @param  int  $value
     */
    public function getIdAttribute($value): string
    {
        return (string)$value;
    }

    /**
     * Converte o id do promotor titular para string
     *
     * @param  int  $value
     */
    public function getPromotorTitularIdAttribute($value): string
    {
        return (string)$value;
    }

    /**
     * Converte o id do promotor designado para string
     *
     * @param  int  $value
     */
    public function getPromotorDesignadoIdAttribute($value): string
    {
        return (string)$value;
    }

    /**
     * Busca o promotor titular do evento
     */
    public function promotorTitular(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }

    /**
     * Busca o promotor designado para o evento
     */
    public function promotorDesignado(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }
}
