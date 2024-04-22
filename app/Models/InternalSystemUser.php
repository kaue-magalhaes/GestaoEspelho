<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternalSystemUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'internal_system_users';

    protected $fillable = [
        'name',
        'login_intranet',
        'senha_intranet',
    ];

    public function niveis(): HasMany
    {
        return $this->hasMany(InternalSystemNivel::class, 'id_usuario', 'id');
    }
}
