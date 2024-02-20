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
        'promotor_id',
    ];

    /**
     * Get the promotor that owns the Promotoria
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Promotor::class);
    }
}
