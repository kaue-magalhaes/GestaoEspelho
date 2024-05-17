<?php

namespace App\Models;

use App\Models\Scopes\MembrosScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nome
 */
#[ScopedBy([MembrosScope::class])]
class Promotor extends Model
{
    use HasFactory;

    protected $connection = 'sol';

    protected $table = 'public.usuario';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'is_substituto',
        'evento_id',
    ];

    /**
     * Busca as promotorias vinculadas ao promotor
     */
    public function promotorias(): HasMany
    {
        return $this->hasMany(Promotoria::class, 'promotor_titular_id');
    }

    /**
     * Busca os eventos vinculados ao promotor
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'promotor_titular_id');
    }

    /**
     * Busca as urgências de atendimento vinculadas ao promotor
     */
    public function urgenciasAtendimento(): HasMany
    {
        return $this->hasMany(UrgenciaAtendimento::class, 'promotor_designado_id');
    }
}
