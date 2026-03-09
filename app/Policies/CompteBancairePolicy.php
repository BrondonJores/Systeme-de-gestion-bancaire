<?php

namespace App\Policies;

use App\Models\CarteBancaire;
use App\Models\CompteBancaire;
use App\Models\User;

class CompteBancairePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user){
        return $user->role === 'admin' || $user->isClient() || $user->isConseiller();
    }

    public function view (User $user, CompteBancaire $compteBancaire)
    {
        return $user->id===$compteBancaire->user_id || $user->role === 'admin';
    }

    public function update (User $user, CompteBancaire $compteBancaire)
    {
        return  $user->role === 'admin';
    }

    public function delete (User $user, CompteBancaire $compteBancaire)
    {
        return $user->role === 'admin';
    }

    public function create (User $user)
    {
        return $user->role === 'admin' || $user->isConseiller();
    }

    public function valider(User $user, CompteBancaire $compteBancaire): bool
    {
        return $user->isAdmin();
    }
}
