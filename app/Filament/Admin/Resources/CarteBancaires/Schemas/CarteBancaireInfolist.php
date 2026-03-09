<?php

namespace App\Filament\Admin\Resources\CarteBancaires\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CarteBancaireInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('numero_carte')->label('Numéro de carte'),
                TextEntry::make('type_carte')->label('Type de carte'),
                TextEntry::make('compte.rib')->label('Compte lié'),
                TextEntry::make('date_expiration')->label('Date d\'expiration')->date(),
                TextEntry::make('cvv')->label('CVV'),
                IconEntry::make('is_actif')->label('Actif')->boolean(),
                TextEntry::make('created_at')->label('Créé le')->dateTime()->placeholder('-'),
                TextEntry::make('updated_at')->label('Mis à jour le')->dateTime()->placeholder('-'),
            ]);
    }
}
