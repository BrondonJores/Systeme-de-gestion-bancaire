<?php

namespace App\Filament\Admin\Resources\CompteBancaires\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompteBancaireForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('rib')
                    ->required()
                    ->readonly()
                    ->default(fn () => strtoupper(fake()->unique()->iban('MA'))),

                Select::make('type')
                    ->options([
                        'courant' => 'Courant',
                        'epargne' => 'Épargne',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Activation automatique des toggles selon type
                        if ($state === 'epargne') {
                            $set('has_interet', true);
                            $set('has_fees', false);
                        } elseif ($state === 'courant') {
                            $set('has_interet', false);
                            $set('has_fees', true);
                        }
                    }),

                TextInput::make('solde')
                    ->numeric()
                    ->required(),

                Select::make('statut')
                    ->options([
                        'inactif' => 'Inactif',
                        'actif' => 'Actif',
                        'ferme' => 'Fermé',
                    ])
                    ->hiddenOn(['create', 'edit',])
                    ->default('inactif')
                    ->required(),

                Toggle::make('has_interest')
                    ->label('Intérêt')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) $set('has_fees', false);
                    }),

                TextInput::make('taux_interet')
                    ->label('Taux d\'intérêt')
                    ->numeric()
                    ->required(fn ($get) => $get('has_interet'))
                    ->visible(fn ($get) => $get('has_interet'))
                    ->disabled(fn ($get) => $get('has_fees')),

                Toggle::make('has_fees')
                    ->label('Frais')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) $set('has_interet', false);
                    }),

                TextInput::make('frais')
                    ->numeric()
                    ->required(fn ($get) => $get('has_fees'))
                    ->visible(fn ($get) => $get('has_fees'))
                    ->disabled(fn ($get) => $get('has_interet')),

                TextInput::make('plafond')
                    ->numeric(),

                Select::make('user_id')
                    ->relationship('proprietaire', 'name')
                    ->label('Propriétaire')
                    ->required(),
            ]);
    }
}
