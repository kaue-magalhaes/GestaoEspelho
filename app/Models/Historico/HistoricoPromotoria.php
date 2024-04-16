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
        'is_especializada',
        'historico_espelho_id',
        'historico_promotor_titular_id',
        'historico_grupo_promotoria_id',
        'historico_id',
    ];

    /**
     * convert the id to string
     */
    public function getIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * convert the promotor_titular_id to string
     */
    public function getHistoricoPromotorTitularIdAttribute(int $value): string
    {
        return (string)$value;
    }

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
        return $this->belongsTo(HistoricoPromotor::class, 'historico_promotor_titular_id');
    }

    /**
     * get the HistoricoGrupoPromotoria that owns the HistoricoPromotoria
     */
    public function grupoPromotoria(): BelongsTo
    {
        return $this->belongsTo(HistoricoGrupoPromotoria::class, 'historico_grupo_promotoria_id');
    }
}
