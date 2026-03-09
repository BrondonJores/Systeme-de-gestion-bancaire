<?php

namespace App\Policies;

use App\Models\CarteBancaire;
use App\Models\CompteBancaire;
use App\Models\User;
use App\Models\Virement;

class VirementPolicy
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
        return $user->isAdmin() || $user->isConseiller() || $user->isClient();
    }

    public function create(User $user)
    {
        return $user->isClient() || $user->isConseiller() || $user->isAdmin();
    }

    public function view(User $user, Virement $virement)
    {
        return $virement->compteEmetteur->user_id === $user->id
            || $virement->compteDestinataire->user_id === $user->id
            || $user->role === 'admin';
    }

    public function valider(User $user, Virement $virement)
    {
        return $user->isConseiller() || $user->isAdmin();
    }
}
