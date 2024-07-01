<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read string $nome
 * @property-read int $municipio
 */
class GrupoPromotoria extends Model
{
    use HasFactory;

    protected $table = 'grupo_promotorias';

    protected $fillable = [
        'nome',
    ];

    /**
     * Get all the promotorias for the GrupoPromotoria
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(Promotoria::class);
    }
}
