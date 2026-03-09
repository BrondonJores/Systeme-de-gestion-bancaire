<?php

namespace App\Policies;

use App\Models\CarteBancaire;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, User $cible)
    {
        return $user->id === $cible->id || $user->role === 'admin';
    }

    public function update(User $user, User $cible)
    {
        return $user->id === $cible->id || $user->role === 'admin';
    }

    public function delete(User $user, User $cible)
    {
        return $user->role === 'admin';
    }
}
