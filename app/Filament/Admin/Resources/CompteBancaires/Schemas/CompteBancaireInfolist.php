<?php

namespace App\Filament\Admin\Resources\CompteBancaires\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Schema;

class CompteBancaireInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('rib'),
                TextEntry::make('type')->badge(),
                TextEntry::make('solde')->money('MAD', true),
                TextEntry::make('statut')->badge(),
                IconEntry::make('has_interest')->boolean(),
                TextEntry::make('taux_interet'),
                IconEntry::make('has_fees')->boolean(),
                TextEntry::make('frais')->numeric(),
                TextEntry::make('plafond'),
                TextEntry::make('proprietaire.name')->label('Propriétaire'),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('updated_at')->dateTime(),
            ]);
    }
}
