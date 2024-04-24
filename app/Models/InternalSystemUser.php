<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        return $this->hasMany(InternalSystemNivel::class, 'usuario_id', 'id');
    }

    public function isAdmin(): bool
    {
        foreach ($this->niveis as $nivel) {
            if ($nivel->sistema === 'Sol' && $nivel->nivel >= 5) {
                return true;
            }
        }

        return false;
    }
}
