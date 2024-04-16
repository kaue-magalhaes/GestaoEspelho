<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoPromotoria extends Model
{
    use HasFactory;

    protected $table = 'historico_promotorias';

    protected $fillable = [
        'nome',
        'nome_grupo_promotorias',
        'municipio',
        'is_especializada',
        'historico_espelho_id',
        'historico_promotor_titular_id',
        'historico_id',
    ];

    /**
     * get the HistoricoEspelho that owns the Promotoria
     */
    public function espelho(): BelongsTo
    {
        return $this->belongsTo(HistoricoEspelho::class);
    }

    /**
     * get the HistoricoPromotor that owns the HistoricoPromotoria
     */
    public function promotor(): BelongsTo
    {
        return $this->belongsTo(HistoricoPromotor::class, 'promotor_titular_id');
    }

    /**
     * get the HistoricoGrupoPromotoria that owns the HistoricoPromotoria
     */
    public function grupoPromotoria(): BelongsTo
    {
        return $this->belongsTo(HistoricoGrupoPromotoria::class);
    }
}
