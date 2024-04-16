<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricoPromotor extends Model
{
    use HasFactory;

    protected $table = 'historico_promotores';

    protected $fillable = [
        'nome',
        'is_substituto',
        'historico_id',
    ];

    /**
     * Converte o id para string
     */
    public function getIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * Get all the promotorias for the HistoricoPromotor
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(HistoricoPromotoria::class, 'historico_promotor_titular_id');
    }

    /**
     * Get all the eventos for the HistoricoPromotor
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(HistoricoEvento::class, 'historico_promotor_titular_id');
    }

    /**
     *  Get all the urgenciasAtendimento for the HistoricoPromotor
     */
    public function urgenciasAtendimento(): HasMany
    {
        return $this->hasMany(HistoricoUrgenciaAtendimento::class, 'historico_promotor_designado_id');
    }
}
