<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read string $id
 * @property-read string $periodo_inicio
 * @property-read string $periodo_fim
 */
class Espelho extends Model
{
    use HasFactory;

    protected $table = 'espelhos';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
    ];

    /**
     * Busca as promotorias vinculadas ao espelho
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(Promotoria::class);
    }
}
