<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';

    protected $fillable = [
        'nome',
    ];

    /**
     * Get all the grupoPromotorias for the Municipio
     */
    public function grupoPromotorias(): HasMany
    {
        return $this->hasMany(GrupoPromotoria::class);
    }
}
