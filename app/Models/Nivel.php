<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read string $sistema
 * @property-read int $nivel
 */
class Nivel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $connection = 'sol';

    protected $table = 'public.niveis';

    protected $primaryKey = 'id';
}
