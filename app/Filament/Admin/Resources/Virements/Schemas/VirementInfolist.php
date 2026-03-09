<?php

namespace App\Filament\Admin\Resources\Virements\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VirementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('compteEmetteur.rib')->label('Émetteur'),
                TextEntry::make('compteDestinataire.rib')->label('Destinataire'),
                TextEntry::make('montant'),
                TextEntry::make('type'),
                TextEntry::make('statut'),
                TextEntry::make('reference'),
                TextEntry::make('description')->placeholder('-'),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('updated_at')->dateTime(),
            ]);
    }
}
