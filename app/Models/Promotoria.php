<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotoria extends Model
{
    use HasFactory;

    protected $table = 'promotorias';

    protected $fillable = [
        'nome',
        'is_especializada',
        'espelho_id',
        'promotor_titular_id',
        'grupo_promotoria_id',
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
    public function getPromotorTitularIdAttribute(int $value): string
    {
        return (string)$value;
    }

    /**
     * get the promotor that owns the Promotoria
     */
    public function promotor(): BelongsTo
    {
        return $this->belongsTo(Promotor::class, 'promotor_titular_id');
    }

    /**
     * get the espelho that owns the Promotoria
     */
    public function espelho(): BelongsTo
    {
        return $this->belongsTo(Espelho::class);
    }

    /**
     * get the grupoPromotoria that owns the Promotoria
     */
    public function grupoPromotoria(): BelongsTo
    {
        return $this->belongsTo(GrupoPromotoria::class);
    }
}
