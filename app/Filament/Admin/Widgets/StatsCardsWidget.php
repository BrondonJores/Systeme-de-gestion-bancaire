<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use App\Models\CompteBancaire;
use App\Models\CarteBancaire;
use App\Models\Virement;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsCardsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Clients', User::where('role', 'client')->count())
                ->icon('heroicon-o-users')
                ->color('BLUE'),

            Stat::make('Total Comptes', CompteBancaire::count())
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Solde Total', CompteBancaire::sum('solde'))
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Cartes actives', CarteBancaire::where('is_actif', true)->count())
                ->icon('heroicon-o-credit-card')
                ->color('warning'),

            Stat::make('Virements en cours', Virement::where('statut', 'en cours')->count())
                ->icon('heroicon-o-arrow-up-right')
                ->color('danger'),

            Stat::make('Virements effectués', Virement::where('statut', 'effectue')->count())
                ->icon('heroicon-o-check')
                ->color('success'),

            Stat::make('Virements échoués', Virement::where('statut', 'echoue')->count())
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
