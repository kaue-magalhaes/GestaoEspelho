<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotor extends Model
{
    use HasFactory;

    protected $table = 'promotores';

    protected $fillable = [
        'nome',
        'is_substituto',
        'evento_id',
    ];

    /**
     * Converte o id para string
     */
    public function getIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * Busca as promotorias vinculadas ao promotor
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(Promotoria::class);
    }

    /**
     * Busca os eventos vinculados ao promotor
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'promotor_titular_id');
    }

    /**
     * Busca as urgências de atendimento vinculadas ao promotor
     */
    public function urgenciasAtendimento(): HasMany
    {
        return $this->hasMany(UrgenciaAtendimento::class, 'promotor_designado_id');
    }
}
