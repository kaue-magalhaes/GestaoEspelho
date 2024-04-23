<?php

namespace App\Policies;

use App\Models\InternalSystemUser;

class PromotoriaPolicy
{
    public function create(InternalSystemUser $user): bool
    {
        if ($this->checksLevelInSolSystem($user)) {
            return true;
        }

        return false;
    }

    public function update(InternalSystemUser $user): bool
    {
        if ($this->checksLevelInSolSystem($user)) {
            return true;
        }

        return false;
    }

    private function checksLevelInSolSystem(InternalSystemUser $user): bool
    {
        $nivel = $user->niveis()->where('sistema', 'SOL')->first()->toArray()['nivel'];

        return $nivel >= 5;
    }
}
