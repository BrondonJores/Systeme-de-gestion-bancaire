<?php

namespace App\Providers;

use App\Models\CarteBancaire;
use App\Models\CompteBancaire;
use App\Models\User;
use App\Models\Virement;
use App\Policies\CarteBancairePolicy;
use App\Policies\CompteBancairePolicy;
use App\Policies\UserPolicy;
use App\Policies\VirementPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [

        User::class => UserPolicy::class,
        CompteBancaire::class => CompteBancairePolicy::class,
        Virement::class => VirementPolicy::class,
        CarteBancaire::class => CarteBancairePolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
