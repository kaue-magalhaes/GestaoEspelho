<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Espelho extends Model
{
    use HasFactory;

    protected $table = 'espelhos';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
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
     * Busca as promotorias vinculadas ao espelho
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(Promotoria::class);
    }
}
