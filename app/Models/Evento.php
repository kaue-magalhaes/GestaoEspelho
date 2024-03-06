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
     * @param $value
     * @return string
     */
    public function getIdAttribute($value)
    {
        return (string)$value;
    }

    /**
     * Busca o promotor titular do evento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotorTitular(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }

    /**
     * Busca o promotor designado para o evento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotorDesignado(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }
}
