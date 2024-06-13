<?php

namespace App\Policies;

use App\Models\InternalSystemUser;
use App\Models\User;

class PromotoriaPolicy
{
    public function create(InternalSystemUser|User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function update(InternalSystemUser|User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function delete(InternalSystemUser|User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }
}
