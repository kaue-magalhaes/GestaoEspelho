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
        'promotor_designado_id',
    ];

    /**
     * Busca o promotor designado para o evento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }
}
