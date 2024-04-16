<?php

namespace App\Models\Historico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricoEspelho extends Model
{
    use HasFactory;

    protected $table = 'historico_espelhos';

    protected $fillable = [
        'titulo',
        'periodo_inicio',
        'periodo_fim',
        'usuario_id',
        'historico_id',
    ];

    /**
     * Get the user that owns the HistoricoEspelho
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Get all the promotorias for the HistoricoEspelho
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(HistoricoPromotoria::class);
    }
}
