<?php

namespace App\Policies;

use App\Models\CarteBancaire;
use App\Models\User;

class CarteBancairePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user){
        return $user->isAdmin() || $user->isClient() || $user->isConseiller();
    }

    public function view (User $user, CarteBancaire $carteBancaire)
    {
        return $user->id===$carteBancaire->compte->user_id || $user->role === 'admin';
    }

    public function update (User $user, CarteBancaire $carteBancaire)
    {
        return $user->id===$carteBancaire->compte->user_id || $user->role === 'admin';
    }

    public function delete (User $user, CarteBancaire $carteBancaire)
    {
        return $user->role === 'admin';
    }

    public function create (User $user)
    {
        return $user->role === 'admin';
    }
}
