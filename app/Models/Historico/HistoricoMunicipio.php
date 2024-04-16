<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricoMunicipio extends Model
{
    use HasFactory;

    protected $table = 'historico_municipios';

    protected $fillable = [
        'nome',
        'historico_id',
    ];

    /**
     * Get all the grupoPromotorias for the HistoricoMunicipio
     */
    public function grupoPromotorias(): HasMany
    {
        return $this->hasMany(HistoricoGrupoPromotoria::class, 'historico_municipio_id');
    }
}
