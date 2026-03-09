<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Si pas connecté, laisse passer pour que le middleware Auth de Laravel gère
        if (!auth()->check()) {
            return $next($request);
        }


        if (auth()->user()->role !== $role) {
            // Déconnexion de l'utilisateur
            Auth::logout();

            // Invalide la session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirection vers la page de login du panel correspondant
            return redirect()->route('filament.client.auth.login') // ou un login générique
            ->with('error', 'Vous avez été déconnecté car vous n’êtes pas autorisé ici.');
        }

        return $next($request);
    }
}
