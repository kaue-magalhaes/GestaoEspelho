<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotoria extends Model
{
    use HasFactory;
    protected $table = 'promotorias';

    protected $fillable = [
        'nome',
        'nome_grupo_promotorias',
        'municipio',
        'is_especializada',
        'espelho_id',
        'promotor_titular_id',
    ];

    /**
     * Converte o id para string
     * @param $value
     * @return string
     */
    public function getIdAttribute($value)
    {
        return (string)$value;
    }

    /**
     * Converte o id do promotor titular para string
     * @param $value
     * @return string
     */
    public function getPromotorTitularIdAttribute($value)
    {
        return (string)$value;
    }

    /**
     * Busca o promotor titular da promotoria
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class, 'promotor_titular_id');
    }

    /**
     * busca o espelho que a promotoria está vinculada
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function espelho(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Espelho::class);
    }
}
