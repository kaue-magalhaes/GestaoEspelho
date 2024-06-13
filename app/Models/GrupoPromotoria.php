<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read string $nome
 * @property-read int $municipio_id
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

    /**
     * Get the municipio that owns the GrupoPromotoria
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }
}
