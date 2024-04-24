<?php

namespace App\Policies;

use App\Models\InternalSystemUser;

class PromotoriaPolicy
{
    public function create(InternalSystemUser $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function update(InternalSystemUser $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function delete(InternalSystemUser $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }
}
