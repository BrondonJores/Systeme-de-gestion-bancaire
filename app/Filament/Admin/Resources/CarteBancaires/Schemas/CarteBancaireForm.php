<?php

namespace App\Filament\Admin\Resources\CarteBancaires\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CarteBancaireForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('numero_carte')
                    ->label('Numéro de carte')
                    ->required()
                    ->readonly()
                    ->default(fn () => fake()->unique()->creditCardNumber()),

                Select::make('type_carte')
                    ->label('Type de carte')
                    ->options([
                        'debit' => 'Débit',
                        'credit' => 'Crédit',
                    ])
                    ->required(),

                Select::make('id_compte')
                    ->relationship('compte', 'rib')
                    ->label('Compte lié')
                    ->required(),

                DatePicker::make('date_expiration')
                    ->label('Date d\'expiration')
                    ->required(),

                TextInput::make('cvv')
                    ->label('CVV')
                    ->required(),

                Toggle::make('is_actif')
                    ->label('Actif'),
            ]);
    }
}
