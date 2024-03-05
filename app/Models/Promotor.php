<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Busca as promotorias vinculadas ao promotor
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function promotorias(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Promotoria::class);
    }

    /**
     * Busca os eventos vinculados ao promotor
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Evento::class, 'promotor_designado_id');
    }

    /**
     * Busca as urgências de atendimento vinculadas ao promotor
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urgenciasAtendimento(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrgenciaAtendimento::class, 'promotor_designado_id');
    }
}
