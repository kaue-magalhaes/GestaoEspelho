<?php

namespace App\Models\Historico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPromotor extends Model
{
    use HasFactory;

    protected $table = 'historico_promotores';

    protected $fillable = [
        'nome',
        'is_substituto',
        'historico_id',
    ];
}
