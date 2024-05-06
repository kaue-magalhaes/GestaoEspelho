<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function isAdmin(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }
}
