<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricoGrupoPromotoria extends Model
{
    use HasFactory;

    /**
     * Get all the promotorias of the HistoricoGrupoPromotoria
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(HistoricoPromotoria::class);
    }

    /**
     * Get the HistoricoMunicipio of the HistoricoGrupoPromotoria
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(HistoricoMunicipio::class);
    }
}
