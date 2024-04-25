<?php

namespace App\Policies;

use App\Models\InternalSystemUser;

class InternalSystemUserPolicy
{
    public function isAdmin(InternalSystemUser $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }
}
