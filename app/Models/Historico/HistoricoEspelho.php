<?php

namespace App\Models\Historico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
